<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Faults;
use App\Models\Classes;
use App\Models\Buildings;
use App\Models\Checklist;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Models\ChecklistNoFaults;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChecklistNoFaultsResource\Pages;
use App\Filament\Resources\ChecklistNoFaultsResource\RelationManagers;

class ChecklistNoFaultsResource extends Resource
{
    protected static ?string $model = ChecklistNoFaults::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $pluralModelLabel = 'Checklist Without Faults';

    protected static ?string $navigationGroup = 'Checklist';

    //protected static ?int $navigationSort = 5;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([ 
                    // Hidden::make('user_id')
                    //     ->default(auth()->id()),
                        Select::make('building_id')
                            ->label('Building Name')
                            ->options(Buildings::all()?->pluck('building_name', 'id')?->toArray())
                            ->searchable()
                            ->reactive()
                            ->required(),
                        
                        Select::make('class_id')
                            ->label('Class Name')
                            ->multiple()
                            ->options(function ($get) {
                                $building_id = $get('building_id');
                                if (!empty($building_id)) {
                                    $classes =  Classes::where('building_id', $building_id)->get();
                                     return  $classes?->pluck('class_name', 'id')?->toArray();
                                } else {
                                    return [];
                                }
                            })
                            ->visible(fn ($get) => !empty($get('building_id'))),

                    // Select::make('fault_id')
                    //     ->multiple()
                    //     ->label('Fault Identified')
                    //     ->options(Faults::all()->pluck('faults_identified', 'id'))
                    //     ->searchable(),
                    MarkdownEditor::make('message')
                        ->label('Message'),
                    DatePicker::make('date_created')
                        ->default(Carbon::now()),
                    DatePicker::make('date_resolved')
                        ->default(Carbon::now())
                        ->label('Date Resolved'),
                    Select::make('user_id')
                        ->label('Resolved by')
                        ->default(Auth::user()->name)
                        ->options(User::pluck('name','id')->toArray()),
                    Select::make('status')
                        ->default('Solved')
                        ->options([
                            'Pending' => ' Pending',
                            'Solved' => 'Solved',
                        ])
                        ->required(),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            // TextColumn::make('id')
            //     ->sortable(),
            TextColumn::make('building_id')
            ->label('Building Name')
            ->getStateUsing(function($record){
            if(is_null($record->class) ){
                return "No Buildings";
            }else if(is_null($record->class) ){
            $buildings = Buildings::find($record?->class)->first();
            return $buildings?->building_name;
            }else{
                $building = $record->building;
                return $building?->building_name;

            }
        })
            ->sortable(),
            TextColumn::make('class.class_name')
                ->label('Class Name')
                ->sortable()
                ->searchable()
                ->limit(15),
                // TextColumn::make('faults.faults_identified')
                // ->label('Faults Identified')
                // // ->getStateUsing(function ($record) {
                // //     if (count($record->faultschecked) < 1) {
                // //         return "No Faults";
                // //     } else {
                // //     //     $faultschecked = $record->faultschecked->first();
                // //     //    //dd($faultschecked?->fault_id);
                // //         $faultsi = Faults::find($record->id)?->first();
                // //         return $faultsi?->faults_identified;
                // //     }
                // // })
                // ->sortable()
                // ->searchable()
                // ->limit(30)
                // ->toggleable(),
            TextColumn::make('message')
                ->label('Message')
                ->sortable()
                ->limit(10)
                ->searchable()
                ->toggleable(),
            BadgeColumn::make('status')
                ->sortable()
                ->searchable()
                // ->getStateUsing(function($record){

                //     $faultschecked = $record->faultschecked->first();
                //     $resolution = $faultschecked?->resolution?->first();
                //     return $resolution?->status;
                    
                // })
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
            TextColumn::make('created_at')
                ->dateTime('d-m-Y')
                ->sortable()
                ->searchable()
                ->toggleable(),
            // TextColumn::make('deleted_at')
            //     ->dateTime('d-m-Y')
            //     ->sortable()
            //     ->searchable(),
        
        ])
        ->filters([
            TrashedFilter::make(),
            SelectFilter::make('status')
            ->options([
                'Pending'=>'Pending',
                'Solved'=>'Solved'
            ])

        ])
        ->actions([
            Tables\Actions\ViewAction::make()->iconButton(),
            Tables\Actions\EditAction::make()->iconButton(),
            DeleteAction::make()->iconButton(),
            Tables\Actions\RestoreAction::make()->iconButton(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\RestoreBulkAction::make(),
        ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChecklistNoFaults::route('/'),
            'create' => Pages\CreateChecklistNoFaults::route('/create'),
            'edit' => Pages\EditChecklistNoFaults::route('/{record}/edit'),
            'view' => Pages\ViewChecklistNoFaults::route('/{record}/view'),
        ];
    }    
}
