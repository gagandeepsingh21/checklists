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
use App\Models\Department;
use App\Models\FaultChecked;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ChecklistResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChecklistResource\RelationManagers;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\ChecklistResource\Widgets\StatisticsOverview;

class ChecklistResource extends Resource
{
    
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Checklist';

    // protected static ?string $pluralModelLabel = 'Checklist With Faults';

    protected static ?int $navigationSort = 4;


    //protected static ?string $recordTitleAttribute = 'faults_identified';

    public static function form(Form $form): Form
    { 

        return $form
            ->schema([
                Card::make()
                    ->schema([ 
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                            Select::make('building_id')
                                ->label('Building Name')
                                ->options(Buildings::all()?->pluck('building_name', 'id')?->toArray())
                                ->searchable()
                                ->reactive()
                                ->required(),
                            
                            Select::make('class_id')
                                ->label('Class Name')
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

                        Select::make('fault_id')
                            ->multiple()
                            ->label('Fault Identified')
                            ->options(Faults::all()->pluck('faults_identified', 'id'))
                            ->searchable(),
                        MarkdownEditor::make('message')
                            ->label('Message'),
                        DatePicker::make('date_created')
                            ->default(Carbon::now()),
                        Select::make('resolved_by')
                            ->label('Resolved by')
                            ->default(Auth::user()->name)
                            ->options(User::pluck('name','name')->toArray()),
                        DatePicker::make('date_resolved')
                            ->default(Carbon::now())
                            ->label('Date Resolved'),
                        Select::make('status')
                            ->default('Pending')
                            ->options([
                                'Pending' => ' Pending',
                                'Solved' => 'Solved',
                            ])
                            ->required(),
                    ])
            ]);
    }
    // [
    //     'Sound(Amp & Speakers)' => 'Sound(Amp & Speakers)',
    //     'Alignment & Clarity' => 'Alignment & Clarity',
    //     'Screen' => 'Screen',
    //     'Screen Controller' => 'Screen Controller',
    //     'Browser Ops/ Remote' => 'Browser Ops/ Remote',
    //     'Network' => 'Network',
    //     'Internet' => 'Internet',
    //     'Anti-virus' => 'Anti-virus',
    //     'PC & Projector Cabinet Security' => 'PC & Projector Cabinet Security',
    //     'AV Guideline Sheet' => 'AV Guideline Sheet',
    //     'Clock' => 'Wireless & APs',
    //     'Potrait' => 'Potrait',
    //     'Light' => 'Light',
    //     'Door' => 'Door',
    // ]
    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                // TextColumn::make('id')
                //     ->sortable(),
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
                    ->sortable()
                    ->searchable(),
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

    // public static function getGlobalSearchResultDetails(Model $record): array
    // {
    //     $buildingName = $record->building_name;
    //     if (is_array($buildingName)) {
    //         $buildingName = implode(', ', $buildingName);
    //     }
    //     $faultsIdentified = $record->faults_identified;
    //     if (is_array($faultsIdentified)) {
    //         $faultsIdentified = implode(', ', $faultsIdentified);
    //     }
    //     $className = $record->class_name;
    //     if (is_array($className)) {
    //         $className = implode(', ', $className);
    //     }
    //     return [
    //         'Class name' => $record->class_name,
    //         'Faults identified' => $faultsIdentified,
    //     ];
    // }


    public static function getWidgets(): array
{
    return [
        StatisticsOverview::class
    ];
}
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChecklists::route('/'),
            'create' => Pages\CreateChecklist::route('/create'),
            'edit' => Pages\EditChecklist::route('/{record}/edit'),
            'view' => Pages\ViewChecklist::route('/{record}/view')
        ];
    }    
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
}
}
