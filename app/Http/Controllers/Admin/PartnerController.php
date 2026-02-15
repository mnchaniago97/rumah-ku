<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->get('type', Partner::TYPE_BANK);

        $partners = Partner::query()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.pages.partners.index', [
            'title' => 'Partner',
            'type' => $type,
            'partners' => $partners,
        ]);
    }

    public function create(Request $request): View
    {
        $type = $request->get('type', Partner::TYPE_BANK);

        return view('admin.pages.partners.create', [
            'title' => 'Tambah Partner',
            'type' => $type,
            'types' => $this->types(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::query()->create($data);

        return redirect()
            ->route('admin.partners.index', ['type' => $data['type']])
            ->with('success', 'Partner berhasil ditambahkan.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.pages.partners.edit', [
            'title' => 'Edit Partner',
            'partner' => $partner,
            'types' => $this->types(),
        ]);
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $this->validated($request, $partner);

        if ($request->hasFile('logo')) {
            if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        return redirect()
            ->route('admin.partners.index', ['type' => $partner->type])
            ->with('success', 'Partner berhasil diperbarui.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }

        $type = $partner->type;
        $partner->delete();

        return redirect()
            ->route('admin.partners.index', ['type' => $type])
            ->with('success', 'Partner berhasil dihapus.');
    }

    private function validated(Request $request, ?Partner $partner = null): array
    {
        $rules = [
            'type' => ['required', 'in:' . implode(',', array_keys($this->types()))],
            'name' => ['required', 'string', 'max:150'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_kpr' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
        ];

        $data = $request->validate($rules);

        $data['is_kpr'] = (bool)($data['is_kpr'] ?? false);
        $data['is_active'] = (bool)($data['is_active'] ?? false);
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        return $data;
    }

    private function types(): array
    {
        return [
            Partner::TYPE_BANK => 'Bank',
            Partner::TYPE_DEVELOPER => 'Developer',
            Partner::TYPE_AGENT => 'Agen',
            Partner::TYPE_OTHER => 'Lainnya',
        ];
    }
}

