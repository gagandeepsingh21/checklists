<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Checklist;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ChecklistResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChecklistResource\RelationManagers;

class ChecklistResource extends Resource
{
    
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Checklist';

    public static function form(Form $form): Form
    {
        
        return $form
            ->schema([
                    Card::make()
                    ->schema([ 
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                            
                        Select::make('building_name')
                            ->options([
                                'Central Building' => 'Central Building',
                                'MSB and Oval Building' => 'MSB and Oval Building',
                                'STMB and SBS' => 'STMB and SBS',
                                'STC' => 'STC',
                            ])
                            ->searchable()
                            ->required(),
                        Select::make('class_name')
                            ->options([
                                'LT1' => 'LT1',
                                'LT2' => 'LT2',
                                'LT3' => 'LT3',
                                'LT4' => 'LT4',
                                'LT5' => 'LT5',
                                'LT6' => 'LT6',
                                'ROOM B' => 'ROOM B',
                                'ROOM 2' => 'ROOM 2',
                                'ROOM 3' => 'ROOM 3',
                                'ROOM 4' => 'ROOM 4',
                                'ROOM 10' => 'ROOM 10',
                                'ROOM 11' => 'ROOM 11',
                                'ROOM 12' => 'ROOM 12',
                                'ROOM 23' => 'ROOM 23',
                                'ROOM 25' => 'ROOM 25',
                                'ROOM 26' => 'ROOM 26',
                                'MSB 1' => 'MSB 1',
                                'MSB 2' => 'MSB 2',
                                'MSB 3' => 'MSB 3',
                                'MSB 4' => 'MSB 4',
                                'MSB 5' => 'MSB 5',
                                'MSB 6' => 'MSB 6',
                                'MSB 7' => 'MSB 7',
                                'MSB 8' => 'MSB 8',
                                'MSB 9' => 'MSB 9',
                                'MSB 10' => 'MSB 10',
                                'MSB 11' => 'MSB 11',
                                'MSB 12' => 'MSB 12',
                                'MSB 13' => 'MSB 13',
                                'MSB 14' => 'MSB 14',
                                'SHABA' => 'SHABA',
                                'ZUMARIDI' => 'ZUMARIDI',
                                'B-01' => 'B-01',
                                'B-02' => 'B-02',
                                'B-03' => 'B-03',
                                'B-04' => 'B-04',
                                'GF-01' => 'GF-01',
                                'GF-02' => 'GF-02',
                                'F1-02' => 'F1-02',
                                'F1-03' => 'F1-03',
                                'F1-04' => 'F1-04',
                                'F1-05' => 'F1-05',
                                'F2-01' => 'F2-01',
                                'F2-02' => 'F2-02',
                                'F2-03' => 'F2-03',
                                'F2-04' => 'F2-04',
                                'F2-05' => 'F2-05',
                                'SBS 1' => 'SBS 1',
                                'SBS 2' => 'SBS 2',
                            ])
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('faults_identified')
                            ->multiple()
                            ->options([
                                'Sound(Amp & Speakers)' => 'Sound(Amp & Speakers)',
                                'Alignment & Clarity' => 'Alignment & Clarity',
                                'Screen' => 'Screen',
                                'Screen Controller' => 'Screen Controller',
                                'Browser Ops/ Remote' => 'Browser Ops/ Remote',
                                'Network' => 'Network',
                                'Internet' => 'Internet',
                                'Anti-virus' => 'Anti-virus',
                                'PC & Projector Cabinet Security' => 'PC & Projector Cabinet Security',
                                'AV Guideline Sheet' => 'AV Guideline Sheet',
                                'Clock' => 'Wireless & APs',
                                'Potrait' => 'Potrait',
                                'Light' => 'Light',
                                'Door' => 'Door',
                            ])
                            ->searchable()
                            ->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                TextColumn::make('message')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->searchable(),
            
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                
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
