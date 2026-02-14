<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgentApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $type = $request->query('type');

        $query = AgentApplication::query()->with(['user', 'approver', 'requestedPlan', 'approvedPlan'])->latest();

        if (filled($status)) {
            $query->where('status', $status);
        }

        if (filled($type)) {
            $query->where('requested_type', $type);
        }

        return view('admin.pages.agent-applications.index', [
            'title' => 'Pendaftaran Agent',
            'applications' => $query->paginate(15)->withQueryString(),
            'status' => $status,
            'type' => $type,
            'typeOptions' => AgentApplication::typeOptions(),
        ]);
    }

    public function show(AgentApplication $agentApplication): View
    {
        $plans = SubscriptionPlan::query()
            ->where('agent_type', $agentApplication->requested_type)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.pages.agent-applications.show', [
            'title' => 'Detail Pendaftaran',
            'application' => $agentApplication->load(['user', 'approver', 'requestedPlan', 'approvedPlan']),
            'typeOptions' => AgentApplication::typeOptions(),
            'plans' => $plans,
        ]);
    }

    public function approve(Request $request, AgentApplication $agentApplication): RedirectResponse
    {
        if ($agentApplication->status !== AgentApplication::STATUS_PENDING) {
            return redirect()
                ->route('admin.agent-applications.show', $agentApplication)
                ->with('success', 'Status pendaftaran sudah diproses.');
        }

        $data = $request->validate([
            'approved_type' => ['nullable', 'string', 'max:50'],
            'approved_plan_id' => ['nullable', 'integer'],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $approvedType = $data['approved_type'] ?: $agentApplication->requested_type;

        $approvedPlanId = null;
        if (!empty($data['approved_plan_id'])) {
            $plan = SubscriptionPlan::query()
                ->where('id', (int)$data['approved_plan_id'])
                ->where('agent_type', $approvedType)
                ->where('is_active', true)
                ->first();

            if (!$plan) {
                return back()
                    ->withErrors(['approved_plan_id' => 'Paket tidak valid untuk tipe yang disetujui.'])
                    ->withInput();
            }

            $approvedPlanId = $plan->id;
        } else {
            $approvedPlanId = $agentApplication->requested_plan_id;
        }

        $agentApplication->update([
            'status' => AgentApplication::STATUS_APPROVED,
            'approved_type' => $approvedType,
            'approved_plan_id' => $approvedPlanId,
            'approved_by' => $request->user()?->id,
            'approved_at' => now(),
            'admin_note' => $data['admin_note'] ?? null,
            'rejected_at' => null,
        ]);

        $user = $agentApplication->user;
        $user->update([
            'role' => 'agent',
            'agent_type' => $approvedType,
            'agent_subscription_plan_id' => $approvedPlanId,
            'agent_verified_at' => $user->agent_verified_at ?? now(),
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.agent-applications.index')
            ->with('success', 'Pendaftaran disetujui. User sekarang memiliki akses dashboard agent.');
    }

    public function reject(Request $request, AgentApplication $agentApplication): RedirectResponse
    {
        if ($agentApplication->status !== AgentApplication::STATUS_PENDING) {
            return redirect()
                ->route('admin.agent-applications.show', $agentApplication)
                ->with('success', 'Status pendaftaran sudah diproses.');
        }

        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $agentApplication->update([
            'status' => AgentApplication::STATUS_REJECTED,
            'admin_note' => $data['admin_note'] ?? null,
            'rejected_at' => now(),
            'approved_at' => null,
            'approved_by' => null,
            'approved_type' => null,
            'approved_plan_id' => null,
        ]);

        return redirect()
            ->route('admin.agent-applications.index')
            ->with('success', 'Pendaftaran ditolak.');
    }
}
