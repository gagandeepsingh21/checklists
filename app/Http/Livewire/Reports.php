<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Filament\Tables;
use App\Models\Faults;
use Livewire\Component;
use Barryvdh\DomPDF\PDF;
use App\Models\Buildings;
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

            TextColumn::make('id')->sortable()->url(fn (Checklist $record):string => route('filament.resources.checklists.edit', ['record' => $record])),
            TextColumn::make('name')->sortable()->searchable()->url(fn (Checklist $record):string => route('filament.resources.checklists.edit', ['record' => $record])),
            TextColumn::make('class.building.building_name')
            ->label('Building Name')
            ->getStateUsing(function($record){
            if(is_null($record->class) ){
                return "No Buildings";
            }else{
            $buildings = Buildings::find($record?->class)->first();
            return $buildings?->building_name;
            }
        })
            ->sortable()
            ->searchable(),
        TextColumn::make('class.class_name')
            ->label('Class Name')
            ->sortable()
            ->searchable(),
        TextColumn::make('faultschecked.fault_id')
            ->label('Faults Identified')
            ->getStateUsing(function($record){
                if(count($record->faultschecked) < 1){
                    return "No Faults";
                }else{ 
                $faults = Faults::find($record?->faultschecked)->first();
                return $faults?->faults_identified;
                }
            })
            ->sortable()
            ->searchable()
            ->limit(10)
            ->toggleable(),
        TextColumn::make('faultschecked.message')
            ->label('Message')
            ->sortable()
            ->limit(10)
            ->searchable()
            ->toggleable(),
        BadgeColumn::make('faultschecked.resolution.status')
            ->sortable()
            ->searchable()
            ->getStateUsing(function($record){

                $faultschecked = $record->faultschecked->first();
                $resolution = $faultschecked?->resolution?->first();
                return $resolution?->status;
                
            })
            ->color(static function ($state): string {
                if ($state === 'Pending') {
                    return 'danger';
                }else{
                    return 'success';
                }
            }),
        TextColumn::make('date_created')
            ->label('Date Checked')
            ->dateTime('d-m-Y')
            ->sortable()
            ->searchable()
            ->toggleable(),
        // TextColumn::make('created_at')
        //     ->dateTime('d-m-Y')
        //     ->sortable()
        //     ->searchable()
        //     ->toggleable(),
        // TextColumn::make('deleted_at')
        //     ->dateTime('d-m-Y')
        //     ->sortable()
        //     ->searchable(),
            
        ];
    }
    protected function getTableFilters(): array
    {
        return [ 
            // SelectFilter::make('name')
            //     ->label('Name')
            //     ->multiple()
            //     ->options(User::pluck('name', 'id')),
            DateFilter::make('date_created')
                ->label(__('Created At')),
            Tables\Filters\SelectFilter::make('status')
            ->options([
                'Solved' => 'Solved',
                'Pending' => ' Pending',
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
