<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reports';

    protected static ?string $navigationGroup = 'Reports';

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('page_Reports');
    }

    public function mount()
    {
        abort_unless(Gate::allows('page_Reports'), 403);
    }
}
