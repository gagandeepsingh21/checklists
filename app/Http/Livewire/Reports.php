<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Barryvdh\DomPDF\PDF;
use App\Models\Checklist;
use Filament\Resources\Table;
use App\Exports\MyModelExport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Webbingbrasil\FilamentDateFilter\DateFilter;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class Reports extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    protected function getTableQuery(): Builder 
{
    return Checklist::query()
        ->select('checklists.*', 'users.name as name')
        ->leftJoin('users', 'users.id', '=', 'checklists.user_id');    
}

    protected function getTableColumns(): array 
    {
        return [

            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('building_name')->sortable()->searchable(),
            TextColumn::make('class_name')->sortable()->searchable(),
            TextColumn::make('faults_identified')->sortable()->searchable()->toggleable(),
            TextColumn::make('message')->sortable()->searchable()->toggleable(),
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
            TextColumn::make('date_created')
                ->dateTime('d-m-Y')
                ->sortable()
                ->toggleable(),
                
            // TextColumn::make('deleted_at')
            //     ->dateTime('d-m-Y')
            //     ->sortable()
            //     ->searchable(),
            
        ];
    }
    protected function getTableFilters(): array
    {
        return [ 

            DateFilter::make('date_created')
            ->label(__('Created At'))
            ->range()
            ->fromLabel(__('From'))
            ->untilLabel(__('Until')),
            Tables\Filters\SelectFilter::make('status')
            ->options([
                'Solved' => 'Solved',
                'Pending' => ' Pending',
                'No Faults' => 'No Faults'
            ])
            
        ]; 
    }
    
//     protected function getTableHeaderActions(): array
// {
//     return [
    
//         FilamentExportHeaderAction::make('export')->button()
        
//     ];
// }

protected function getTableBulkActions(): array
{
    return [
        
        FilamentExportBulkAction::make('Export'),
    
    ];
}
    public function render() : View
    {
        return view('livewire.reports');
    }
}
