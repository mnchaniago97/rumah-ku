<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class JoinController extends Controller
{
    public function show(string $type): View
    {
        $typeOptions = AgentApplication::typeOptions();
        $typeSlug = $type;
        $typeKey = AgentApplication::typeFromSlug($typeSlug);
        abort_unless($typeKey && array_key_exists($typeKey, $typeOptions), 404);

        $config = $this->typeConfig($typeKey);
        $plans = SubscriptionPlan::query()
            ->where('agent_type', $typeKey)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $prefillPlanId = (int) request()->query('plan', 0);
        if ($prefillPlanId <= 0 || !$plans->contains('id', $prefillPlanId)) {
            $prefillPlanId = null;
        }

        return view('frontend.pages.join.show', [
            'title' => $config['page_title'],
            'type' => $typeSlug,
            'typeKey' => $typeKey,
            'typeLabel' => $typeOptions[$typeKey],
            'typeOptions' => $typeOptions,
            'config' => $config,
            'plans' => $plans,
            'prefillPlanId' => $prefillPlanId,
        ]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        $typeOptions = AgentApplication::typeOptions();
        $typeSlug = $type;
        $typeKey = AgentApplication::typeFromSlug($typeSlug);
        abort_unless($typeKey && array_key_exists($typeKey, $typeOptions), 404);

        $user = $request->user();

        if ($user && $user->role === 'agent') {
            return redirect()->route('agent.dashboard');
        }

        $rules = [
            'full_name' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
            'domicile_area' => ['nullable', 'string', 'max:150'],
        ];

        $hasPlans = SubscriptionPlan::query()
            ->where('agent_type', $typeKey)
            ->where('is_active', true)
            ->exists();

        if ($hasPlans) {
            $rules['subscription_plan_id'] = ['required', 'integer'];
        } else {
            $rules['subscription_plan_id'] = ['nullable', 'integer'];
        }

        if (!$user) {
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $typeSpecific = match ($typeKey) {
            AgentApplication::TYPE_PROPERTY_AGENT => [
                'agency_brand' => ['nullable', 'string', 'max:150'],
                'job_title' => ['nullable', 'string', 'max:100'],
                'agent_registration_number' => ['nullable', 'string', 'max:100'],
                'experience_years' => ['nullable', 'integer', 'min:0', 'max:80'],
                'specialization_areas' => ['nullable', 'string', 'max:500'],
            ],
            AgentApplication::TYPE_IN_HOUSE_MARKETING => [
                'company_name' => ['nullable', 'string', 'max:150'],
                'position' => ['nullable', 'string', 'max:100'],
                'work_area' => ['nullable', 'string', 'max:150'],
                'portfolio_url' => ['nullable', 'url', 'max:255'],
            ],
            AgentApplication::TYPE_PROPERTY_OWNER => [
                'property_location' => ['nullable', 'string', 'max:200'],
                'property_kind' => ['nullable', 'string', 'max:100'],
                'intent' => ['nullable', 'in:sell,rent'],
                'approx_price' => ['nullable', 'numeric', 'min:0'],
            ],
            AgentApplication::TYPE_DEVELOPER => [
                'company_name' => ['nullable', 'string', 'max:150'],
                'project_name' => ['nullable', 'string', 'max:150'],
                'project_location' => ['nullable', 'string', 'max:200'],
                'units_estimate' => ['nullable', 'integer', 'min:0', 'max:1000000'],
                'website_url' => ['nullable', 'url', 'max:255'],
            ],
            default => [],
        };

        $data = $request->validate(array_merge($rules, $typeSpecific));

        $selectedPlan = null;
        if (!empty($data['subscription_plan_id'])) {
            $selectedPlan = SubscriptionPlan::query()
                ->where('id', (int)$data['subscription_plan_id'])
                ->where('agent_type', $typeKey)
                ->where('is_active', true)
                ->first();

            if (!$selectedPlan) {
                return back()
                    ->withErrors(['subscription_plan_id' => 'Paket langganan tidak valid untuk tipe ini.'])
                    ->withInput();
            }
        }

        if (!$user) {
            $user = User::create([
                'name' => $data['full_name'],
                'email' => $data['email'],
                'role' => 'user',
                'agent_type' => null,
                'is_active' => true,
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'] ?? null,
                'ktp_full_name' => $data['full_name'],
                'whatsapp_phone' => $data['whatsapp_phone'] ?? null,
                'domicile_area' => $data['domicile_area'] ?? null,
                'agency_brand' => $typeKey === AgentApplication::TYPE_PROPERTY_AGENT ? ($data['agency_brand'] ?? null) : null,
                'job_title' => $typeKey === AgentApplication::TYPE_PROPERTY_AGENT ? ($data['job_title'] ?? null) : null,
                'agent_registration_number' => $typeKey === AgentApplication::TYPE_PROPERTY_AGENT ? ($data['agent_registration_number'] ?? null) : null,
                'experience_years' => $typeKey === AgentApplication::TYPE_PROPERTY_AGENT ? ($data['experience_years'] ?? null) : null,
                'specialization_areas' => $typeKey === AgentApplication::TYPE_PROPERTY_AGENT ? ($data['specialization_areas'] ?? null) : null,
            ]);

            Auth::login($user);
        } else {
            $user->fill([
                'phone' => $data['phone'] ?? $user->phone,
                'ktp_full_name' => $data['full_name'] ?? $user->ktp_full_name,
                'whatsapp_phone' => $data['whatsapp_phone'] ?? $user->whatsapp_phone,
                'domicile_area' => $data['domicile_area'] ?? $user->domicile_area,
            ]);

            if ($typeKey === AgentApplication::TYPE_PROPERTY_AGENT) {
                $user->fill([
                    'agency_brand' => $data['agency_brand'] ?? $user->agency_brand,
                    'job_title' => $data['job_title'] ?? $user->job_title,
                    'agent_registration_number' => $data['agent_registration_number'] ?? $user->agent_registration_number,
                    'experience_years' => $data['experience_years'] ?? $user->experience_years,
                    'specialization_areas' => $data['specialization_areas'] ?? $user->specialization_areas,
                ]);
            }

            $user->save();
        }

        $alreadyPending = AgentApplication::query()
            ->where('user_id', $user->id)
            ->where('status', AgentApplication::STATUS_PENDING)
            ->exists();

        if ($alreadyPending) {
            return redirect()
                ->route('join.show', ['type' => $typeSlug])
                ->with('success', 'Pendaftaran Anda sudah kami terima. Mohon tunggu verifikasi admin.');
        }

        $payload = collect($data)
            ->except(['full_name', 'email', 'password', 'password_confirmation', 'phone', 'whatsapp_phone', 'domicile_area'])
            ->all();

        if ($selectedPlan) {
            $payload['subscription_plan'] = [
                'id' => $selectedPlan->id,
                'name' => $selectedPlan->name,
                'price' => $selectedPlan->price,
                'period_label' => $selectedPlan->period_label,
                'badge' => $selectedPlan->badge,
            ];
        }

        AgentApplication::create([
            'user_id' => $user->id,
            'requested_type' => $typeKey,
            'requested_plan_id' => $selectedPlan?->id,
            'status' => AgentApplication::STATUS_PENDING,
            'name' => $data['full_name'],
            'email' => $user->email,
            'phone' => $data['phone'] ?? null,
            'whatsapp_phone' => $data['whatsapp_phone'] ?? null,
            'domicile_area' => $data['domicile_area'] ?? null,
            'payload' => $payload,
        ]);

        return redirect()
            ->route('join.show', ['type' => $typeSlug])
            ->with('success', 'Pendaftaran berhasil dikirim. Admin akan meninjau dan mengaktifkan akses dashboard sesuai tipe yang disetujui.');
    }

    private function typeConfig(string $type): array
    {
        return match ($type) {
            AgentApplication::TYPE_PROPERTY_AGENT => [
                'page_title' => 'Daftar Agen Properti',
                'hero_title' => 'Jual Properti Cepat, Raih Keuntungan Maksimal',
                'hero_subtitle' => 'Gabung sebagai Agen Properti dan kelola listing secara efisien.',
                'cta_label' => 'Daftar jadi agen',
            ],
            AgentApplication::TYPE_IN_HOUSE_MARKETING => [
                'page_title' => 'Daftar In-House Marketing',
                'hero_title' => 'Jual Properti Baru dengan Mudah',
                'hero_subtitle' => 'Kelola iklan, leads, dan closing lebih cepat untuk proyek Anda.',
                'cta_label' => 'Daftar sekarang',
            ],
            AgentApplication::TYPE_PROPERTY_OWNER => [
                'page_title' => 'Pasang Iklan Pemilik Properti',
                'hero_title' => 'Pasang Iklan Jual & Sewakan Properti Pribadi',
                'hero_subtitle' => 'Iklankan properti Anda langsung, praktis, dan terarah.',
                'cta_label' => 'Iklankan sekarang',
            ],
            AgentApplication::TYPE_DEVELOPER => [
                'page_title' => 'Daftar Developer',
                'hero_title' => 'Pasarkan Proyek Properti Anda Bersama Kami',
                'hero_subtitle' => 'Dapatkan eksposur terbaik dan dukungan pemasaran proyek.',
                'cta_label' => 'Mulai iklankan properti',
            ],
            default => [
                'page_title' => 'Pendaftaran',
                'hero_title' => 'Pendaftaran',
                'hero_subtitle' => '',
                'cta_label' => 'Daftar',
            ],
        };
    }
}
