<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Classes;
use App\Models\Building;
use App\Models\Buildings;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\ClassesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use lluminate\Database\Eloquent\Relations\BelongsTo;
use App\Filament\Resources\ClassesResource\RelationManagers;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $buildings = Buildings::pluck('building_name', 'id')->toArray();
    
        return $form
            ->schema([
                Hidden::make('user_id')->default(auth()->id()),
                BelongsToSelect::make('building_id')
                    ->options($buildings)
                    ->required(),
                TextInput::make('class_name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
            TextColumn::make('building.building_name', 'Buildings')->sortable(),
            TextColumn::make('class_name')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasses::route('/create'),
            'edit' => Pages\EditClasses::route('/{record}/edit'),
        ];
    }    
}
