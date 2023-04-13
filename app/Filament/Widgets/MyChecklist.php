<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use App\Models\Checklist;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class MyChecklist extends BaseWidget
{
    protected static ?string $heading = 'My Checklists';

    protected function getTableQuery(): Builder
    {
        return Checklist::where('user_id', Auth::id())->latest();   
    }
        protected function getTableHeaderActions(): array
{
    return [
    
        FilamentExportHeaderAction::make('export')->button()
        
    ];
}

    protected function getTableColumns(): array
    {
        return [
        TextColumn::make('id')
            ->sortable(),
        TextColumn::make('building_name')
            ->sortable()
            ->searchable(),
        TextColumn::make('class_name')
            ->sortable()
            ->searchable(),
        // TextColumn::make('faults_identified')
        //     ->sortable()
        //     ->searchable(),
        BadgeColumn::make('status')
            ->sortable()
            ->searchable()
            ->color(static function ($state): string {
                if ($state === 'Pending') {
                    return 'danger';
                }else if ($state === 'Solved'){
                    return 'success';
                }
            }),
        TextColumn::make('created_at')
            ->dateTime('d-m-Y')
            ->sortable()
            
        ];
    }
    protected function getTableRecordsPerPageSelectOptions(): array 
    {
        return [5, 10, 25, 50, 100];
    } 
}
