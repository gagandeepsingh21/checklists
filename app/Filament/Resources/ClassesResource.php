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
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\ClassesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use lluminate\Database\Eloquent\Relations\BelongsTo;
use App\Filament\Resources\ClassesResource\RelationManagers;

class ClassesResource extends Resource
{
    protected static ?string $model = Classes::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Checklist';

    protected static ?string $recordTitleAttribute = 'class_name';

    protected static ?int $navigationSort = 2;

    
    public static function form(Form $form): Form
    {
        $buildings = Buildings::pluck('building_name', 'id')->toArray();
    
        return $form
        
            ->schema([

                Fieldset::make('Add Classes')
                    ->schema([
                        // Hidden::make('user_id')->default(auth()->id()),
                        BelongsToSelect::make('building_id')
                            ->label('Building Name')
                            ->options($buildings)
                            ->required(),
                        TextInput::make('class_name')->required()->unique(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // TextColumn::make('id')->sortable(),
                TextColumn::make('building.building_name', 'Buildings')->sortable()->searchable()->toggleable(),
                TextColumn::make('class_name')->sortable()->searchable(),
                //TextColumn::make('deleted_at')->sortable()->searchable()->toggleable(),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
                Tables\Actions\RestoreAction::make()->iconButton(),
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
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Building name' => $record->building->building_name,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClasses::route('/create'),
            'edit' => Pages\EditClasses::route('/{record}/edit'),
            'view' => Pages\ViewClasses::route('/{record}/view')
        ];
    }    
}
