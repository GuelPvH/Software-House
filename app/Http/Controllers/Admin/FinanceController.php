<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceFormRequest;
use App\Models\AuditEvent;
use App\Models\FinancialTransaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class FinanceController extends Controller
{
    public function index(): View
    {
        return view('pages.admin.finance.index', ['transactions' => FinancialTransaction::latest()->paginate(25)]);
    }

    public function store(FinanceFormRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['paid_at'] = $data['status'] === 'paid' ? now() : null;
        $data['created_by'] = $request->user()?->id;
        $item = FinancialTransaction::create($data);
        AuditEvent::create(['user_id' => $request->user()?->id, 'action' => 'finance.created', 'entity' => 'transaction', 'entity_id' => $item->id]);

        return back()->with('success', 'Lançamento registrado.');
    }

    public function update(FinanceFormRequest $request, FinancialTransaction $transaction): RedirectResponse
    {
        $data = $request->validated();
        $data['paid_at'] = $data['status'] === 'paid' ? ($transaction->paid_at ?? now()) : null;
        $transaction->update($data);
        AuditEvent::create(['user_id' => $request->user()?->id, 'action' => 'finance.updated', 'entity' => 'transaction', 'entity_id' => $transaction->id]);

        return back()->with('success', 'Lançamento atualizado.');
    }
}
