<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Faults;
use App\Models\Classes;
use App\Models\Buildings;
use App\Models\Checklist;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
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
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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

    protected static ?string $recordTitleAttribute = 'building_name';

    public static function form(Form $form): Form
    { 
        return $form
            ->schema([
                Card::make()
                    ->schema([ 
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                            
                        Select::make('building_name')
                            ->options(Buildings::all()->pluck('building_name', 'building_name'))
                            ->searchable()
                            ->reactive()
                            ->required(),

                        Select::make('class_name')
                            ->options(fn($get) => Classes::join('buildings', 'classes.building_id', '=', 'buildings.id')->where('building_name', $get('building_name'))->pluck('class_name', 'class_name'))
                            ->visible(fn($get) => $get('building_name') !== null),
                        Select::make('faults_identified')
                            ->multiple()
                            ->options(Faults::all()->pluck('faults_identified', 'faults_identified'))
                            ->searchable(),
                        MarkdownEditor::make('message')
                            ->required(),
                        Select::make('status')
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
                TextColumn::make('building_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('class_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('faults_identified')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('message')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
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
                    ->searchable()
                    ->toggleable(),
                // TextColumn::make('deleted_at')
                //     ->dateTime('d-m-Y')
                //     ->sortable()
                //     ->searchable(),
            
            ])
            ->filters([
                TrashedFilter::make(),
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
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $faultsIdentified = $record->faults_identified;
        if (is_array($faultsIdentified)) {
            $faultsIdentified = implode(', ', $faultsIdentified);
        }

        return [
            'Class name' => $record->class_name,
            'Faults identified' => $faultsIdentified,
        ];
    }


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
