<?php

declare(strict_types=1);

namespace App\Filament\Viewer\Pages;

use Filament\Pages\Page;

class ViewerDashboardPage extends Page
{
    protected static ?string $title = 'لوحة المستعرض';

    protected static ?string $navigationLabel = 'لوحة المستعرض';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static ?string $slug = 'viewer-dashboard';

    protected string $view = 'filament.viewer.pages.dashboard';
}
