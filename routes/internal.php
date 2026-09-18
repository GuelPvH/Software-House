<?php

declare(strict_types=1);
use App\Http\Controllers\Admin\AccessController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\LeadsOrcamentosController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TechnicalController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RequestAccessController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Middleware\InternalAccess;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::redirect('/admin/login', '/login')->name('admin.login.index');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:login')->name('login.store');
    Route::get('/solicitar-acesso', [RequestAccessController::class, 'index'])->name('access.index');
    Route::post('/solicitar-acesso', [RequestAccessController::class, 'store'])->middleware('throttle:5,1')->name('access.store');
    Route::get('/esqueci-senha', [PasswordController::class, 'forgot'])->name('password.request');
    Route::post('/esqueci-senha', [PasswordController::class, 'email'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/redefinir-senha/{token}', [PasswordController::class, 'reset'])->name('password.reset');
    Route::post('/redefinir-senha', [PasswordController::class, 'update'])->middleware('throttle:5,1')->name('password.update');
    Route::get('/segundo-fator', [TwoFactorController::class, 'challenge'])->name('two-factor.challenge');
    Route::post('/segundo-fator', [TwoFactorController::class, 'verify'])->middleware('throttle:5,1')->name('two-factor.verify');
});
Route::get('/confirmar-acesso/{access}/{token}', [RequestAccessController::class, 'verify'])->middleware('throttle:10,1')->name('access.verify');
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->middleware(InternalAccess::class.':dashboard')->name('dashboard');
    Route::middleware(InternalAccess::class.':projects')->prefix('projetos')->name('projects.')->group(function (): void {
        Route::get('/', [ProjectController::class, '__invoke'])->name('index');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::patch('/{board}', [ProjectController::class, 'update'])->name('update');
        Route::patch('/{board}/listas/{column}', [ProjectController::class, 'updateColumn'])->name('columns.update');
        Route::post('/{board}/arquivados/{cardId}/restaurar', [ProjectController::class, 'restore'])->name('cards.restore');
        Route::post('/{board}/listas', [ProjectController::class, 'column'])->name('columns');
        Route::post('/{board}/cartoes', [ProjectController::class, 'storeCard'])->name('cards.store');
        Route::patch('/{board}/cartoes/{card}', [ProjectController::class, 'updateCard'])->name('cards.update');
        Route::delete('/{board}/cartoes/{card}', [ProjectController::class, 'archive'])->name('cards.archive');
        Route::post('/{board}/mover', [ProjectController::class, 'move'])->name('move');
        Route::post('/{board}/cartoes/{card}/comentarios', [ProjectController::class, 'comment'])->name('comments');
        Route::post('/{board}/cartoes/{card}/checklist', [ProjectController::class, 'checklist'])->name('checklist');
        Route::patch('/{board}/cartoes/{card}/checklist/{item}', [ProjectController::class, 'toggle'])->name('checklist.toggle');
    });
    Route::middleware(InternalAccess::class.':leads')->prefix('leads-orcamentos')->name('leads.')->controller(LeadsOrcamentosController::class)->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete', 'delete')->name('destroy');
    });
    Route::middleware(InternalAccess::class.':services')->prefix('servicos')->name('services.')->controller(ServicesController::class)->group(function (): void {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{service}', 'update')->name('update');
        Route::patch('/unpublish/{id}', 'unpublish')->name('unpublish');
    });
    Route::middleware(InternalAccess::class.':finance')->prefix('financeiro')->name('finance.')->group(function (): void {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::post('/', [FinanceController::class, 'store'])->name('store');
        Route::patch('/{transaction}', [FinanceController::class, 'update'])->name('update');
    });
    Route::middleware(InternalAccess::class.':access')->group(function (): void {
        Route::get('/acessos', [AccessController::class, 'index'])->name('access.index');
        Route::post('/acessos/{access}', [AccessController::class, 'review'])->name('access.review');
    });
    Route::middleware(InternalAccess::class.':technical')->group(function (): void {
        Route::get('/tecnico', [TechnicalController::class, 'index'])->name('technical.index');
        Route::patch('/tecnico/usuarios/{user}', [TechnicalController::class, 'user'])->name('technical.user');
        Route::post('/tecnico/rotas', [TechnicalController::class, 'routes'])->name('technical.routes');
    });
    Route::prefix('configuracoes')->name('settings.')->middleware(InternalAccess::class.':settings')->group(function (): void {
        foreach (['profile' => '', 'notifications' => 'notificacoes', 'security' => 'seguranca'] as $name => $path) {
            Route::get('/'.$path, [SettingsController::class, 'show'])->name($name);
        }
        Route::post('/perfil', [SettingsController::class, 'profile'])->name('profile.save');
        Route::get('/email/confirmar', [SettingsController::class, 'verifyEmail'])->middleware('signed')->name('email.verify');
        Route::get('/foto/{user}', [SettingsController::class, 'photo'])->name('photo');
        Route::post('/notificacoes', [SettingsController::class, 'notifications'])->name('notifications.save');
        Route::post('/seguranca', [SettingsController::class, 'security'])->name('security.save');
        Route::post('/sessoes', [SettingsController::class, 'sessions'])->name('sessions');
        Route::post('/2fa/iniciar', [SettingsController::class, 'setupTwoFactor'])->name('two-factor.setup');
        Route::post('/2fa/confirmar', [SettingsController::class, 'confirmTwoFactor'])->middleware('throttle:5,1')->name('two-factor.confirm');
        Route::post('/2fa/desativar', [SettingsController::class, 'disableTwoFactor'])->name('two-factor.disable');
        Route::post('/2fa/recuperacao', [SettingsController::class, 'recoveryCodes'])->name('two-factor.recovery');
        Route::middleware(InternalAccess::class.':company')->group(function (): void {
            Route::get('/empresa/logo', [SettingsController::class, 'logo'])->name('company.logo');
            Route::get('/empresa', [SettingsController::class, 'show'])->name('company');
            Route::post('/empresa', [SettingsController::class, 'company'])->name('company.save');
        });
        Route::middleware(InternalAccess::class.':integrations')->group(function (): void {
            Route::get('/integracoes', [SettingsController::class, 'show'])->name('integrations');
            Route::post('/integracoes/email', [SettingsController::class, 'testMail'])->middleware('throttle:5,1')->name('mail.test');
            Route::post('/integracoes/email/{mail}', [SettingsController::class, 'retryMail'])->middleware('throttle:5,1')->name('mail.retry');
            Route::post('/integracoes/chave', [SettingsController::class, 'token'])->name('token');
        });
    });
});
