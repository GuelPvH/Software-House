<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'pending_email' => fn (Blueprint $t) => $t->string('pending_email')->nullable(),
            'totp_last_step' => fn (Blueprint $t) => $t->bigInteger('totp_last_step')->default(-1),
            'is_admin' => fn (Blueprint $t) => $t->boolean('is_admin')->default(false),
            'account_role' => fn (Blueprint $t) => $t->string('account_role')->nullable(),
            'access_active' => fn (Blueprint $t) => $t->boolean('access_active')->default(true),
            'session_version' => fn (Blueprint $t) => $t->unsignedInteger('session_version')->default(0),
            'preferences' => fn (Blueprint $t) => $t->json('preferences')->nullable(),
            'avatar_path' => fn (Blueprint $t) => $t->string('avatar_path')->nullable(),
            'last_login_at' => fn (Blueprint $t) => $t->timestamp('last_login_at')->nullable(),
            'totp_secret' => fn (Blueprint $t) => $t->text('totp_secret')->nullable(),
            'totp_confirmed_at' => fn (Blueprint $t) => $t->timestamp('totp_confirmed_at')->nullable(),
            'recovery_codes' => fn (Blueprint $t) => $t->text('recovery_codes')->nullable(),
        ];
        foreach ($columns as $name => $definition) {
            if (! Schema::hasColumn('users', $name)) {
                Schema::table('users', $definition);
            }
        }
        foreach (['projects', 'tasks'] as $table) {
            if (! Schema::hasColumn($table, 'version')) {
                Schema::table($table, fn (Blueprint $t) => $t->unsignedInteger('version')->default(1));
            }
        }
        if (! Schema::hasColumn('tasks', 'labels')) {
            Schema::table('tasks', fn (Blueprint $t) => $t->json('labels')->nullable());
        }
        Schema::create('access_requests', function (Blueprint $t): void {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->string('status')->default('pending');
            $t->string('assigned_role')->nullable();
            $t->timestamp('email_confirmed_at')->nullable();
            $t->string('verification_hash', 64)->nullable();
            $t->timestamp('verification_expires_at')->nullable();
            $t->foreignId('reviewed_by')->nullable()->constrained('users');
            $t->timestamp('reviewed_at')->nullable();
            $t->text('review_note')->nullable();
            $t->timestamps();
        });
        Schema::create('internal_mail_outbox', function (Blueprint $t): void {
            $t->id();
            $t->string('recipient');
            $t->string('subject');
            $t->text('body');
            $t->string('status')->default('pending')->index();
            $t->unsignedInteger('attempts')->default(0);
            $t->text('last_error')->nullable();
            $t->timestamp('sent_at')->nullable();
            $t->timestamps();
        });
        Schema::create('internal_audit_events', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained('users');
            $t->string('action');
            $t->string('entity')->nullable();
            $t->string('entity_id')->nullable();
            $t->json('details')->nullable();
            $t->timestamps();
        });
        Schema::create('internal_settings', function (Blueprint $t): void {
            $t->string('key')->primary();
            $t->text('value')->nullable();
            $t->timestamps();
        });
        Schema::create('internal_checklist_items', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('task_id')->constrained('tasks');
            $t->string('title');
            $t->boolean('completed')->default(false);
            $t->timestamps();
        });
        Schema::create('internal_route_registry', function (Blueprint $t): void {
            $t->id();
            $t->string('route_name')->unique();
            $t->string('label');
            $t->json('roles');
            $t->timestamps();
        });
        Schema::create('internal_developer_profiles', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained('users');
            $t->string('specialty')->nullable();
            $t->text('skills')->nullable();
            $t->timestamps();
        });
    }

    public function down(): never
    {
        throw new RuntimeException('Migração aditiva: reversão destrutiva bloqueada para preservar tabelas e dados.');
    }
};
