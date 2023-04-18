<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    // public static function getEloquentQuery(): Builder{

    //     return static::getModel()::query()->where('id', auth()->id());
    // }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->password()
                    ->required(fn (Page $livewire): bool => $livewire instanceof createUser)
                    ->minLength(8)
                    ->same('passwordConfirmation')
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                TextInput::make('passwordConfirmation')
                    ->password()
                    ->label('Password Confirmation')
                    ->required(fn (Page $livewire): bool => $livewire instanceof createUser)
                    ->minLength(8)
                    ->dehydrated(false),
                // Select::make('roles')
                //     ->options(Role::query()->pluck('name', 'id'))
                ]),
                Section::make("Assign Roles")->schema([
                    CheckboxList::make('roles')->relationship('roles','name'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('roles.name')
                    ->sortable()
                    ->searchable()
                    ->color(static function ($state): string {
                        if ($state === 'super_admin') {
                            return 'success';
                        }else if ($state === 'Admin'){
                            return 'primary';
                        }
                 
                        return 'danger';
                    }),       
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),          
                // TextColumn::make('deleted_at')
                //     ->dateTime('d-m-Y')
                //     ->sortable()
                //     ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d-m-Y')
                    ->sortable()
                    ->searchable(),
                
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
               
            ])
            ->bulkActions([
                
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}/view'),
        ];
    }    
}
