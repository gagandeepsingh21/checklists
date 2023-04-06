<?php

namespace App\Http\Livewire;

use Filament\Tables;
use Livewire\Component;
use Barryvdh\DomPDF\PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MyModelExport;
use App\Models\Checklist;
use Filament\Resources\Table;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class Reports extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    
    public function generatePdf()
    {
        $data = Checklist::query()->select('checklists.*', 'users.name')->join('users', 'users.id', '=', 'checklists.user_id');
        $pdf = PDF::loadView('myview', ['data' => $data]);
        return $pdf->download('myreport.pdf');
    }
    
    public function generateExcel()
    {
        $data = Checklist::query()->select('checklists.*', 'users.name')->join('users', 'users.id', '=', 'checklists.user_id');;
        return Excel::download(new MyModelExport($data), 'myreport.xlsx');
    }
    
    protected function getTableQuery(): Builder 
    {
        return Checklist::query()->select('checklists.*', 'users.name')->join('users', 'users.id', '=', 'checklists.user_id');    
    } 
    
    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')
                ->label('Created By')
                ->sortable()
                ->searchable(),
            TextColumn::make('building_name')->sortable()->searchable(),
            TextColumn::make('class_name')->sortable()->searchable(),
            TextColumn::make('faults_identified')->sortable()->searchable(),
            TextColumn::make('message')->sortable()->searchable(),
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
                ->searchable(),
            TextColumn::make('deleted_at')
                ->dateTime('d-m-Y')
                ->sortable()
                ->searchable(),
        ];
    }
    
    public function render() : View
    {
        return view('livewire.reports');
    }
}
