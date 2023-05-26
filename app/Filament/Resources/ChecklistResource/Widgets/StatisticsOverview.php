<?php

namespace App\Filament\Resources\ChecklistResource\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatisticsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        
            
        $completedRequests = DB::table('checklists')->whereNull('deleted_at')->where('status', 'solved')->count();
        $pendingRequests = DB::table('checklists')->whereNull('deleted_at')->where('status', 'pending')->count();
        $totalRequests = $completedRequests + $pendingRequests;
        return [
        Card::make('Total Requests', $totalRequests)
            ->description($totalRequests. ' ' .'Requests')
            ->descriptionIcon('heroicon-s-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Card::make('Completed Requests', $completedRequests)
            ->description($completedRequests. ' ' .'Requests Completed')
            ->descriptionIcon('heroicon-s-trending-down')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Card::make('Pending Requests', $pendingRequests)
            ->description($pendingRequests. ' ' .'Requests Pending')
            ->descriptionIcon('heroicon-s-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger'),
        ];
        
    }
}
