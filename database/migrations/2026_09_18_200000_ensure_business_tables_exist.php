<?php

declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('clients')) {
            Schema::create('clients', function (Blueprint $t): void {
                $t->id();
                $t->string('name');
                $t->string('company_name')->nullable();
                $t->string('email')->nullable();
                $t->string('phone')->nullable();
                $t->string('type')->default('company');
                $t->string('status')->default('active');
                $t->foreignId('created_by')->nullable()->constrained('users');
                $t->timestamps();
                $t->softDeletes();
            });
        }
        if (! Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $t): void {
                $t->id();
                $t->foreignId('client_id')->constrained('clients');
                $t->string('name');
                $t->text('description')->nullable();
                $t->string('status')->default('planning');
                $t->string('priority')->default('medium');
                $t->foreignId('responsible_id')->nullable()->constrained('users');
                $t->decimal('budget', 15, 2)->nullable();
                $t->unsignedInteger('progress')->default(0);
                $t->date('deadline')->nullable();
                $t->timestamps();
                $t->softDeletes();
            });
        }
        if (! Schema::hasTable('project_members')) {
            Schema::create('project_members', function (Blueprint $t): void {
                $t->id();
                $t->foreignId('project_id')->constrained('projects');
                $t->foreignId('user_id')->constrained('users');
                $t->string('project_role')->default('developer');
                $t->timestamp('joined_at')->useCurrent();
                $t->timestamp('left_at')->nullable();
                $t->timestamps();
                $t->unique(['project_id', 'user_id']);
            });
        }
        if (! Schema::hasTable('stages')) {
            Schema::create('stages', function (Blueprint $t): void {
                $t->id();
                $t->foreignId('project_id')->constrained('projects');
                $t->string('name');
                $t->integer('order_index')->default(0);
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $t): void {
                $t->id();
                $t->foreignId('project_id')->constrained('projects');
                $t->foreignId('stage_id')->nullable()->constrained('stages');
                $t->string('title');
                $t->text('description')->nullable();
                $t->string('status')->default('backlog');
                $t->string('priority')->default('medium');
                $t->foreignId('assigned_to')->nullable()->constrained('users');
                $t->foreignId('created_by')->nullable()->constrained('users');
                $t->date('due_date')->nullable();
                $t->timestamp('completed_at')->nullable();
                $t->integer('position')->default(0);
                $t->timestamps();
                $t->softDeletes();
            });
        }
        if (! Schema::hasTable('task_comments')) {
            Schema::create('task_comments', function (Blueprint $t): void {
                $t->id();
                $t->foreignId('task_id')->constrained('tasks');
                $t->foreignId('user_id')->constrained('users');
                $t->text('content');
                $t->timestamps();
                $t->softDeletes();
            });
        }
        if (! Schema::hasTable('financial_transactions')) {
            Schema::create('financial_transactions', function (Blueprint $t): void {
                $t->id();
                $t->foreignId('project_id')->nullable()->constrained('projects');
                $t->foreignId('client_id')->nullable()->constrained('clients');
                $t->string('type');
                $t->string('description');
                $t->string('counterparty')->nullable();
                $t->decimal('amount', 15, 2);
                $t->date('due_date');
                $t->timestamp('paid_at')->nullable();
                $t->string('status')->default('pending');
                $t->text('notes')->nullable();
                $t->foreignId('created_by')->nullable()->constrained('users');
                $t->timestamps();
                $t->softDeletes();
            });
        }
        if (! Schema::hasTable('project_types')) {
            Schema::create('project_types', function (Blueprint $t): void {
                $t->id();
                $t->string('name');
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('status_leads')) {
            Schema::create('status_leads', function (Blueprint $t): void {
                $t->id();
                $t->string('name');
                $t->timestamps();
            });
        }
        if (! Schema::hasTable('leads')) {
            Schema::create('leads', function (Blueprint $t): void {
                $t->id();
                $t->string('name');
                $t->string('company')->nullable();
                $t->string('email');
                $t->string('phone')->nullable();
                $t->foreignId('fk_project_type')->nullable()->constrained('project_types');
                $t->foreignId('fk_status_lead')->nullable()->constrained('status_leads');
                $t->decimal('estimated_value', 15, 2)->nullable();
                $t->date('deadline')->nullable();
                $t->text('objective')->nullable();
                $t->text('notes')->nullable();
                $t->string('source')->nullable();
                $t->text('lost_reason')->nullable();
                $t->unsignedBigInteger('assigned_to')->nullable();
                $t->unsignedBigInteger('client_id')->nullable();
                $t->unsignedBigInteger('created_by')->nullable();
                $t->timestamps();
                $t->softDeletes();
            });
        }
    }

    public function down(): never
    {
        throw new RuntimeException('Reversão destrutiva bloqueada.');
    }
};
