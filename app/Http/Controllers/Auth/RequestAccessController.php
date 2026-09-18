<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestAccessController extends Controller
{
    public function index()
    {
        return view('pages.solicitar-acesso.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'termos' => 'accepted',
        ]);

        return redirect()->route('auth.solicitar-acesso.index')->with('sucesso', true);
    }
}
