<?php

declare(strict_types=1);

namespace App\Enums;

enum AccountRole: string
{
    case Developer = 'developer';
    case Finance = 'finance';
    case Manager = 'manager';
    case Owner = 'project_owner';
    case Technical = 'technical_admin';

    public function label(): string
    {
        return match ($this) {
            self::Developer => 'Desenvolvedor', self::Finance => 'Financeiro',
            self::Manager => 'Gestor', self::Owner => 'Project Owner', self::Technical => 'Administrador técnico',
        };
    }

    /** @return list<string> */
    public function modules(): array
    {
        return match ($this) {
            self::Developer => ['dashboard', 'projects', 'settings'],
            self::Finance => ['dashboard', 'finance', 'settings'],
            self::Owner => ['dashboard', 'leads', 'projects', 'settings'],
            self::Technical => ['dashboard', 'technical', 'access', 'settings', 'company', 'integrations'],
            self::Manager => ['dashboard', 'leads', 'projects', 'services', 'finance', 'settings', 'company', 'integrations', 'access', 'technical'],
        };
    }
}
