<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\ProjectType;
use App\Models\StatusLeads;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

final class LeadsOrcamentosController extends Controller
{
    public function __construct(
        private Leads $leads,
        private ProjectType $projectType,
        private StatusLeads $statusLeads) {}

    public function index(Request $request): View|string
    {
        if ($request->ajax()) {
            $leadId = $request->query('lead_id') ?? $request->query('lead');
            if ($leadId) {
                $lead = $this->leads->with(['projectType', 'statusLead'])->findOrFail($leadId);

                return view('components.admin.leads.details', compact('lead'))->render();
            }
        }

        $querys = (object) [
            'search' => $request->query('search'),
            'fk_project_type' => $request->query('fk_project_type'),
            'status_leads' => $request->query('status_leads'),
            'periodo' => $request->query('periodo'),
        ];

        $leads = $this->leads->findAll($querys);
        $projectsTypes = $this->projectType->all();
        $statusLeads = $this->statusLeads->all();
        $selectedLead = $leads->first();

        return view('pages.admin.leads.index', compact('leads', 'projectsTypes', 'statusLeads', 'selectedLead'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'company' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'fk_project_type' => 'required|integer',
            'deadline' => 'required|date',
            'objective' => 'required|string',
            'estimated_value' => 'required|numeric|min:0',
        ]);

        $data['fk_status_lead'] = (int) $request->input('fk_status_lead', 1);

        try {
            $this->leads->create($data);

            return redirect()->route('admin.leads.index')->with('success', 'Lead criado com sucesso!');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao criar lead!');
        }
    }

    public function delete(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $lead = $this->leads->findOrFail($request->input('id'));
            $lead->delete();

            return redirect()->route('admin.leads.index')->with('success', 'Lead excluído com sucesso!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Erro ao excluir lead!');
        }
    }
}
