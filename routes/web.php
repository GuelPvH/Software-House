<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ContatosController;
use App\Http\Controllers\Admin\PublicProjectsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', [VehicleController::class, 'index'])->name('vehicles.index');

Route::get('/deploy/inicio', fn () => view('pages.publico.deploy.inicio-deploy'))->name('publico.deploy.inicio-deploy');

Route::get('/deploy/servicos', fn () => view('pages.publico.deploy.servicos-deploy'))->name('publico.deploy.servicos-deploy');

Route::delete('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::view('/publico', 'pages.publico.index')->name('publico.index');

Route::get('/up/deep', function () {
    $checks = [
        'app' => true,
        'db' => rescue(fn (): bool => (bool) DB::connection()->getPdo(), false, report: false),
        'redis' => rescue(fn (): bool => Redis::connection()->ping(), false, report: false),
    ];

    $healthy = ! in_array(false, $checks, strict: true);

    return response()->json($checks, $healthy ? 200 : 503);
})->name('health.deep');

Route::get('/contato', [ContatosController::class, 'index'])->name('publico.contato.index');
Route::post('/contato/store', [ContatosController::class, 'store'])->name('publico.contato.store');

Route::get('/projetos', [PublicProjectsController::class, 'index'])->name('publico.projetos.index');

require __DIR__.'/internal.php';
