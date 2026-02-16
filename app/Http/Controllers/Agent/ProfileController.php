<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();

        return view('agent.pages.profile', [
            'title' => 'Profil Saya',
            'user' => $user,
        ]);
    }

    public function updateCompany(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Only developers can update company profile
        if ($user->agent_type !== AgentApplication::TYPE_DEVELOPER) {
            abort(403, 'Only developers can update company profile.');
        }

        $data = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_logo' => ['nullable', 'image', 'max:2048'],
            'company_address' => ['nullable', 'string', 'max:1000'],
            'company_phone' => ['nullable', 'string', 'max:50'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'company_description' => ['nullable', 'string', 'max:2000'],
            'company_npwp' => ['nullable', 'string', 'max:50'],
            'company_siup' => ['nullable', 'string', 'max:50'],
            'company_nib' => ['nullable', 'string', 'max:50'],
        ]);

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($user->company_logo) {
                $oldPath = str_replace('/storage/', '', $user->company_logo);
                Storage::disk('uploads')->delete($oldPath);
            }
            
            $path = $request->file('company_logo')->store('company-logos', 'uploads');
            $data['company_logo'] = '/storage/' . $path;
        }

        $user->update($data);

        return redirect()
            ->route('agent.profile')
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }
}
