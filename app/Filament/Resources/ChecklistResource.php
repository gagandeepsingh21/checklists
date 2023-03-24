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
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ChecklistResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChecklistResource\RelationManagers;

class ChecklistResource extends Resource
{
    
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Admin Management';

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
                                'Central building(Phase 1)' => 'Central building(Phase 1)',
                                'MSB' => 'MSB',
                                'STMB' => 'STMB',
                                'STC' => 'STC',
                            ])
                            ->searchable()
                            ->required(),
                        Select::make('class_name')
                            ->options([
                                'MSB1' => 'MSB1',
                                'MSB2' => 'MSB2',
                                'STMB1' => 'STMB1',
                                'lT2' => 'LT2',
                            ])
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('faults_identified')
                            ->multiple()
                            ->options([
                                'Door' => 'Door',
                                'Projector' => 'Projector',
                                'PC' => 'STMB',
                                'Light' => 'Light',
                                'Switches' => 'Switches',
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
            
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
        ];
    }    
}
