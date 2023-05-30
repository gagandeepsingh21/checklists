<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use App\Models\Checklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class MyChecklist extends BaseWidget
{
    use HasWidgetShield;

    public static function canView(): bool
    {
        return Gate::allows('widget_MyChecklist');
    }
    protected static ?string $heading = 'My Checklists';

    protected function getTableQuery(): Builder
    {
        return Checklist::where('user_id', Auth::id())->latest();   
    }

    protected function getTableColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('building_name')
                ->searchable(),
                TextColumn::make('class_name')
                ->searchable(),
                TextColumn::make('faults_identified')
                ->searchable(),
    
            ]),
            Panel::make([
                Stack::make([
        TextColumn::make('id')
            ->sortable(),
        TextColumn::make('building_name')
            ->sortable()
            ->searchable(),
        TextColumn::make('class_name')
            ->sortable()
            ->searchable(),
        TextColumn::make('faults_identified')
            ->sortable()
            ->searchable(),
        BadgeColumn::make('status')
            ->sortable()
            ->searchable()
            ->color(static function ($state): string {
                if ($state === 'Pending') {
                    return 'danger';
                }else if ($state === 'Solved'){
                    return 'success';
                }else if ($state === 'No Faults'){
                    return 'secondary';
                }
            }),
        TextColumn::make('created_at')
            ->dateTime('d-m-Y')
            ->sortable()
        ]),
        ])->collapsible(),
            
        ];
    }
    protected function getTableRecordsPerPageSelectOptions(): array 
    {
        return [5, 10, 25, 100];
    } 
}
