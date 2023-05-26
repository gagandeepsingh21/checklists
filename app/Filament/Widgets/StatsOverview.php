<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Filament\Widgets\StatsOverviewWidget\Card;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    use HasWidgetShield;

public static function canView(): bool
{
    return Gate::allows('widget_StatsOverview');
}
    protected static ?string $pollingInterval = '10s';
    
    protected function getCards(): array
    {
        $totalUsers = DB::table('users')->whereNull('deleted_at')->count();
        $totalbuildings = DB::table('buildings')->whereNull('deleted_at')->count();
        $totalclasses = DB::table('classes')->whereNull('deleted_at')->count();
        $completedRequests = DB::table('checklists')->where('status', 'solved')->whereNull('deleted_at')->count();
        $pendingRequests = DB::table('checklists')->where('status', 'pending')->whereNull('deleted_at')->count();
        $totalRequests = $completedRequests + $pendingRequests;
        return [
        Card::make('Total Users', $totalUsers)
            ->description($totalUsers. ' ' .'Users')
            ->descriptionIcon('heroicon-s-trending-up'),
        Card::make('Total Buildings', $totalbuildings)
            ->description($totalbuildings. ' ' .'Buildings')
            ->descriptionIcon('heroicon-s-trending-up'),
         Card::make('Total Classes', $totalclasses)
            ->description($totalclasses. ' ' .'Classes')
            ->descriptionIcon('heroicon-s-trending-up'),
        Card::make('Total Reports', $totalRequests)
            ->description($totalRequests. ' ' .'Reports')
            ->descriptionIcon('heroicon-s-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Card::make('Completed Reports', $completedRequests)
            ->description($completedRequests. ' ' .'Reports Completed')
            ->descriptionIcon('heroicon-s-trending-down')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Card::make('Pending Reports', $pendingRequests)
            ->description($pendingRequests. ' ' .'Reports Pending')
            ->descriptionIcon('heroicon-s-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger'),
        ];
    }
}
