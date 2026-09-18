<?php

declare(strict_types=1);

use App\Console\Commands\FleetSummaryCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(FleetSummaryCommand::class)
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->description('Enfileira a geracao do resumo da frota');

Schedule::command('backup:run')->dailyAt('03:00');
Schedule::command('backup:clean')->dailyAt('04:00');
Schedule::command('backup:monitor')->dailyAt('05:00');

Schedule::command('internal:mail-reconcile')->everyMinute()->withoutOverlapping();
Schedule::command('internal:digests')->everyFiveMinutes()->withoutOverlapping();
