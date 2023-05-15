<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Buildings;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\BuildingsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BuildingsResource\RelationManagers;

class BuildingsResource extends Resource
{
    protected static ?string $model = Buildings::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Checklist';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Add Buildings')
                    ->schema([
                    Hidden::make('user_id')
                        ->default(auth()->id()),
                    TextInput::make('building_name')
                        ->required()
                        ->unique(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('building_name')
                    ->searchable(),
                ]),
                Panel::make([
                    Stack::make([
                        TextColumn::make('id')
                            ->sortable(),
                        TextColumn::make('building_name')
                            ->sortable()
                            ->searchable(),
                        TextColumn::make('deleted_at')
                            ->sortable()
                            ->searchable(),
                    ]),
                ])->collapsible(),
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
            'index' => Pages\ListBuildings::route('/'),
            'create' => Pages\CreateBuildings::route('/create'),
            'edit' => Pages\EditBuildings::route('/{record}/edit'),
            'view' => Pages\ViewBuildings::route('/{record}/view')
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
