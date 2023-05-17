<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Faults;
use App\Models\Classes;
use App\Models\Buildings;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\FaultsResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FaultsResource\RelationManagers;

class FaultsResource extends Resource
{
    protected static ?string $model = Faults::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';
    
    protected static ?string $navigationGroup = 'Checklist';

    public static function form(Form $form): Form
    {
        $classes = Classes::pluck('class_name', 'id')->toArray();
        return $form
            ->schema([
                Fieldset::make('Add Faults')
                    ->schema([ 
                        Hidden::make('user_id')->default(auth()->id()),
                        TextInput::make('faults_identified')->required()->unique(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')->sortable(),
                TextColumn::make('faults_identified')->sortable()->searchable(),
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaults::route('/'),
            'create' => Pages\CreateFaults::route('/create'),
            'edit' => Pages\EditFaults::route('/{record}/edit'),
            'view' => Pages\ViewFaults::route('/{record}/view')
        ];
    }    
}
