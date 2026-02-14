<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $type = $request->query('type');

        $query = SubscriptionPlan::query()->orderBy('agent_type')->orderBy('sort_order')->orderBy('id');
        if (filled($type)) {
            $query->where('agent_type', $type);
        }

        return view('admin.pages.subscription-plans.index', [
            'title' => 'Pricing / Paket Langganan',
            'plans' => $query->paginate(20)->withQueryString(),
            'type' => $type,
            'typeOptions' => AgentApplication::typeOptions(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $type = $request->query('type');

        return view('admin.pages.subscription-plans.create', [
            'title' => 'Tambah Paket',
            'type' => $type,
            'typeOptions' => AgentApplication::typeOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $typeOptions = array_keys(AgentApplication::typeOptions());
        $subtitleOptions = array_keys(SubscriptionPlan::subtitleOptions());
        $badgeOptions = array_keys(SubscriptionPlan::badgeOptions());

        $agentType = (string)$request->input('agent_type', '');
        $nameOptions = array_keys(SubscriptionPlan::allowedNamesForAgentType($agentType));

        $data = $request->validate([
            'agent_type' => ['required', 'string', 'in:' . implode(',', $typeOptions)],
            'name' => ['required', 'string', Rule::in($nameOptions)],
            'subtitle' => ['nullable', 'string', Rule::in($subtitleOptions)],
            'badge' => ['nullable', 'string', Rule::in($badgeOptions)],
            'price' => ['nullable', 'numeric', 'min:0'],
            'period_label' => ['nullable', 'string', 'max:50'],
            'is_highlight' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'features_text' => ['nullable', 'string', 'max:4000'],
            'access_json' => ['nullable', 'string', 'max:8000'],
        ]);

        $features = collect(preg_split('/\\r\\n|\\r|\\n/', (string)($data['features_text'] ?? '')))
            ->map(fn ($v) => trim((string)$v))
            ->filter(fn ($v) => $v !== '')
            ->values()
            ->all();

        $access = null;
        if (filled($data['access_json'] ?? null)) {
            $decoded = json_decode((string)$data['access_json'], true);
            if (!is_array($decoded)) {
                return back()
                    ->withErrors(['access_json' => 'Access harus berupa JSON object/array yang valid.'])
                    ->withInput();
            }
            $access = $decoded;
        }

        SubscriptionPlan::create([
            'agent_type' => $data['agent_type'],
            'name' => $data['name'],
            'subtitle' => $data['subtitle'] ?? null,
            'badge' => $data['badge'] ?? null,
            'is_highlight' => (bool)($data['is_highlight'] ?? false),
            'price' => isset($data['price']) ? (int)$data['price'] : null,
            'period_label' => $data['period_label'] ?? null,
            'features' => count($features) ? $features : null,
            'access' => $access,
            'is_active' => array_key_exists('is_active', $data) ? (bool)$data['is_active'] : true,
            'sort_order' => (int)($data['sort_order'] ?? 0),
        ]);

        return redirect()
            ->route('admin.subscription-plans.index', ['type' => $data['agent_type']])
            ->with('success', 'Paket berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPlan $subscriptionPlan): View
    {
        return view('admin.pages.subscription-plans.edit', [
            'title' => 'Edit Paket',
            'plan' => $subscriptionPlan,
            'typeOptions' => AgentApplication::typeOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $typeOptions = array_keys(AgentApplication::typeOptions());
        $subtitleOptions = array_keys(SubscriptionPlan::subtitleOptions());
        $badgeOptions = array_keys(SubscriptionPlan::badgeOptions());

        $agentType = (string)$request->input('agent_type', $subscriptionPlan->agent_type);
        $nameOptions = array_keys(SubscriptionPlan::allowedNamesForAgentType($agentType));

        $data = $request->validate([
            'agent_type' => ['required', 'string', 'in:' . implode(',', $typeOptions)],
            'name' => ['required', 'string', Rule::in($nameOptions)],
            'subtitle' => ['nullable', 'string', Rule::in($subtitleOptions)],
            'badge' => ['nullable', 'string', Rule::in($badgeOptions)],
            'price' => ['nullable', 'numeric', 'min:0'],
            'period_label' => ['nullable', 'string', 'max:50'],
            'is_highlight' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'features_text' => ['nullable', 'string', 'max:4000'],
            'access_json' => ['nullable', 'string', 'max:8000'],
        ]);

        $features = collect(preg_split('/\\r\\n|\\r|\\n/', (string)($data['features_text'] ?? '')))
            ->map(fn ($v) => trim((string)$v))
            ->filter(fn ($v) => $v !== '')
            ->values()
            ->all();

        $access = null;
        if (filled($data['access_json'] ?? null)) {
            $decoded = json_decode((string)$data['access_json'], true);
            if (!is_array($decoded)) {
                return back()
                    ->withErrors(['access_json' => 'Access harus berupa JSON object/array yang valid.'])
                    ->withInput();
            }
            $access = $decoded;
        }

        $subscriptionPlan->update([
            'agent_type' => $data['agent_type'],
            'name' => $data['name'],
            'subtitle' => $data['subtitle'] ?? null,
            'badge' => $data['badge'] ?? null,
            'is_highlight' => (bool)($data['is_highlight'] ?? false),
            'price' => isset($data['price']) ? (int)$data['price'] : null,
            'period_label' => $data['period_label'] ?? null,
            'features' => count($features) ? $features : null,
            'access' => $access,
            'is_active' => array_key_exists('is_active', $data) ? (bool)$data['is_active'] : $subscriptionPlan->is_active,
            'sort_order' => (int)($data['sort_order'] ?? 0),
        ]);

        return redirect()
            ->route('admin.subscription-plans.index', ['type' => $data['agent_type']])
            ->with('success', 'Paket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $type = $subscriptionPlan->agent_type;
        $subscriptionPlan->delete();

        return redirect()
            ->route('admin.subscription-plans.index', ['type' => $type])
            ->with('success', 'Paket berhasil dihapus.');
    }
}
