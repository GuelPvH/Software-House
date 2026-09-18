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

final class LoginController extends Controller
{
    public function __construct(
        private Leads $leads,
        private ProjectType $projectType,
        private StatusLeads $statusLeads) {}

    public function index(Request $request): View|string
    {
        return view('pages.admin.login.index');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            return redirect()->route('admin.dashboard')->with('success', 'Logado com sucesso!');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao logar!');
        }
    }
}
