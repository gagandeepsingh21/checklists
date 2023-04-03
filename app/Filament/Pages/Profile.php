<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.profile';
    protected static ?string $title = 'My profile';
 
    protected static ?string $navigationLabel = 'My profile';
    
}
