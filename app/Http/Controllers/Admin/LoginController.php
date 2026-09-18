<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

final class LoginController extends Controller
{
    public function index(): RedirectResponse
    {
        return to_route('login');
    }

    public function store(): RedirectResponse
    {
        return to_route('login');
    }
}
