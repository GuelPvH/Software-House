<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicProjectsController extends Controller
{
    public function index(Request $request): View|string
    {
        return view('pages.publico.projetos.index');
    }
}
