<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index(Request $request): View|string
    {
        return view('pages.publico.inicio.index');
    }
}
