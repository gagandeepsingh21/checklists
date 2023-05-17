<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class MyProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pages.my-profile';

    protected static ?string $navigationGroup = 'User Management';
    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('page_MyProfile');
    }

    public function mount()
    {
        abort_unless(Gate::allows('page_MyProfile'), 403);
    }
}
