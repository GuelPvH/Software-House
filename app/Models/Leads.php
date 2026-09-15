<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

final class Leads extends Model
{
    use SoftDeletes;

    protected $table = 'leads';

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'fk_project_type',
        'fk_status_lead',
        'deadline',
        'objective',
        'estimated_value',
        'source',
        'notes',
        'lost_reason',
        'assigned_to',
        'client_id',
        'created_by',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'estimated_value' => 'decimal:2',
            'fk_project_type' => 'integer',
            'fk_status_lead' => 'integer',
        ];
    }

    /**
     * @return LengthAwarePaginator<int, Leads>
     */
    public function findAll(object $querys): LengthAwarePaginator
    {
        return self::query()
            ->with(['projectType', 'statusLead'])
            ->when($querys->search ?? null, function ($q, $search): void {
                $q->where(function ($sub) use ($search): void {
                    $sub->where('name', 'like', '%'.$search.'%')
                        ->orWhere('company', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%');
                });
            })
            ->when($querys->fk_project_type ?? null, function ($q, $type): void {
                $q->where('fk_project_type', $type);
            })
            ->when($querys->status_leads ?? null, function ($q, $status): void {
                if (is_numeric($status)) {
                    $q->where('fk_status_lead', (int) $status);
                } else {
                    $q->whereHas('statusLead', function ($sub) use ($status): void {
                        $sub->where('name', $status);
                    });
                }
            })
            ->when($querys->periodo ?? null, function ($q, $periodo): void {
                match ($periodo) {
                    'today', 'hoje' => $q->whereDate('created_at', today()),
                    'this_week', 'semana' => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'this_month', 'mes', 'este_mes' => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                    'this_year', 'ano' => $q->whereYear('created_at', now()->year),
                    default => null,
                };
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * @return BelongsTo<ProjectType, $this>
     */
    public function projectType(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class, 'fk_project_type');
    }

    /**
     * @return BelongsTo<StatusLeads, $this>
     */
    public function statusLead(): BelongsTo
    {
        return $this->belongsTo(StatusLeads::class, 'fk_status_lead');
    }
}
