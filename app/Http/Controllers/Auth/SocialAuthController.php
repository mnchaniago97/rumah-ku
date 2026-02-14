<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    private const PROVIDERS = ['google', 'facebook'];

    private function loginRouteNameFromPreviousUrl(?string $previousUrl): string
    {
        if (!$previousUrl) {
            return 'login';
        }

        $path = parse_url($previousUrl, PHP_URL_PATH);
        if (is_string($path) && str_starts_with($path, '/agent/')) {
            return 'agent.login';
        }

        return 'login';
    }

    public function redirect(Request $request, string $provider): RedirectResponse
    {
        $provider = strtolower($provider);
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        $previousUrl = url()->previous();
        $request->session()->put('social_auth.previous_url', $previousUrl);

        $loginRoute = $this->loginRouteNameFromPreviousUrl($previousUrl);

        $clientId = config("services.$provider.client_id");
        if (!$clientId) {
            $envKey = strtoupper($provider).'_CLIENT_ID';

            return redirect()
                ->route($loginRoute)
                ->withErrors(['email' => "Konfigurasi social login belum lengkap. Isi `$envKey` di file .env."]);
        }

        $driver = Socialite::driver($provider);

        if ($provider === 'google') {
            $driver = $driver->with(['prompt' => 'select_account']);
        }

        if ($provider === 'facebook') {
            $driver = $driver->scopes(['email']);
        }

        return $driver->redirect();
    }

    public function callback(Request $request, string $provider): RedirectResponse
    {
        $provider = strtolower($provider);
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);

        $previousUrl = $request->session()->get('social_auth.previous_url');
        $loginRoute = $this->loginRouteNameFromPreviousUrl(is_string($previousUrl) ? $previousUrl : null);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable) {
            return redirect()
                ->route($loginRoute)
                ->withErrors(['email' => 'Login gagal. Silakan coba lagi.']);
        }

        $email = $socialUser->getEmail();
        if (!$email) {
            return redirect()
                ->route($loginRoute)
                ->withErrors(['email' => 'Provider tidak mengirim email. Pastikan izin email diaktifkan.']);
        }

        $providerId = (string) $socialUser->getId();
        $providerColumn = $provider === 'google' ? 'google_id' : 'facebook_id';

        $user = User::query()
            ->where($providerColumn, $providerId)
            ->orWhere('email', $email)
            ->first();

        $name = $socialUser->getName() ?: $socialUser->getNickname() ?: $email;
        $avatar = $socialUser->getAvatar();

        if (!$user) {
            $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => now(),
                'role' => 'user',
                'is_active' => true,
                $providerColumn => $providerId,
                'avatar' => $avatar,
                'password' => Hash::make(Str::random(32)),
            ]);
        } else {
            $updates = [];

            if (!$user->{$providerColumn}) {
                $updates[$providerColumn] = $providerId;
            }

            if (!$user->email_verified_at) {
                $updates['email_verified_at'] = now();
            }

            if (!$user->avatar && $avatar) {
                $updates['avatar'] = $avatar;
            }

            if ($updates) {
                $user->forceFill($updates)->save();
            }
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        if ($user->role === 'agent') {
            return redirect()->route('agent.dashboard');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/');
    }
}
