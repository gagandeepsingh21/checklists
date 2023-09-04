<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use App\Models\Faults;
use App\Models\Classes;
use App\Models\Buildings;
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

            TextColumn::make('building.building_name')
            ->label('Building Name')
            ->getStateUsing(function($record){
            if(is_null($record->class) ){
                return "No Buildings";
            }else{
            $buildings = Buildings::find($record?->class)->first();
            return $buildings?->building_name;
            }
        })
            ->sortable(),
            // ->searchable(),
        TextColumn::make('class.class_name')
            ->label('Class Name')
            ->sortable()
            ->searchable(),
            TextColumn::make('faults.faults_identified')
            ->label('Faults Identified')
            // ->getStateUsing(function ($record) {
            //     if (count($record->faultschecked) < 1) {
            //         return "No Faults";
            //     } else {
            //     //     $faultschecked = $record->faultschecked->first();
            //     //    //dd($faultschecked?->fault_id);
            //         $faultsi = Faults::find($record->id)?->first();
            //         return $faultsi?->faults_identified;
            //     }
            // })
            ->sortable()
            ->searchable()
            ->limit(30)
            ->toggleable(),
        TextColumn::make('message')
            ->label('Message')
            ->sortable()
            ->limit(10)
            ->searchable()
            ->toggleable(),
        TextColumn::make('message')
            ->label('Message')
            ->sortable()
            ->limit(10)
            ->searchable()
            ->toggleable(),
        BadgeColumn::make('status')
            ->sortable()
            ->searchable()
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
    
        //     Split::make([
        //         TextColumn::make('building_name')
        //         ->searchable(),
        //         TextColumn::make('class_name')
        //         ->searchable(),
        //         TextColumn::make('faults_identified')
        //         ->searchable(),
    
        //     ]),
        //     Panel::make([
        //         Stack::make([
        // TextColumn::make('id')
        //     ->sortable(),
        // TextColumn::make('building_name')
        //     ->sortable()
        //     ->searchable(),
        // TextColumn::make('class_name')
        //     ->sortable()
        //     ->searchable(),
        // TextColumn::make('faults_identified')
        //     ->sortable()
        //     ->searchable(),
        // // BadgeColumn::make('status')
        // //     ->sortable()
        // //     ->searchable()
        // //     ->color(static function ($state): string {
        // //         if ($state === 'Pending') {
        // //             return 'danger';
        // //         }else if ($state === 'Solved'){
        // //             return 'success';
        // //         }else if ($state === 'No Faults'){
        // //             return 'secondary';
        // //         }
        // //     }),
        // TextColumn::make('created_at')
        //     ->dateTime('d-m-Y')
        //     ->sortable()
        // ]),
        // ])->collapsible(),
            
        ];
    }
    protected function getTableRecordsPerPageSelectOptions(): array 
    {
        return [5, 25, 100];
    } 
}
