<?php

declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('stages', 'is_done')) {
            Schema::table('stages', fn (Blueprint $t) => $t->boolean('is_done')->default(false));
        }
        DB::table('stages')->whereIn('name', ['Concluído', 'Concluída', 'Concluídos', 'Concluídas', 'Entregue', 'Done'])->update(['is_done' => true]);
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $t): void {
                $t->id();
                $t->string('name')->unique();
                $t->string('display_name');
                $t->text('description')->nullable();
                $t->boolean('is_system')->default(true);
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('user_roles')) {
            Schema::create('user_roles', function (Blueprint $t): void {
                $t->id();
                $t->foreignId('user_id')->constrained('users');
                $t->foreignId('role_id')->constrained('roles');
                $t->unsignedBigInteger('assigned_by')->nullable();
                $t->timestamp('expires_at')->nullable();
                $t->timestamps();
                $t->unique(['user_id', 'role_id']);
            });
        }
        foreach (['developer' => 'Desenvolvedor', 'finance' => 'Financeiro', 'manager' => 'Gestor', 'product_owner' => 'Project Owner', 'super_admin' => 'Administrador técnico'] as $key => $label) {
            if (! DB::table('roles')->where('name', $key)->exists()) {
                DB::table('roles')->insert(['name' => $key, 'display_name' => $label, 'is_system' => true, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }

    public function down(): never
    {
        throw new RuntimeException('Reversão destrutiva bloqueada.');
    }
};
