<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

final class ContatosController extends Controller {
    public function index(Request $request): View|string
    {
        return view('pages.publico.contato.index');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            return redirect()->back()->with('success', 'Proposta enviada com sucesso!');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao enviar proposta!');
        }
    }
}
