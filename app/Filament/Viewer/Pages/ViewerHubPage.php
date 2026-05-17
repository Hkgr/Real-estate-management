<?php

declare(strict_types=1);

namespace App\Filament\Viewer\Pages;

use Filament\Pages\Page;

class ViewerHubPage extends Page
{
    protected static ?string $title = 'بوابة المستعرض';

    protected static ?string $navigationLabel = 'الرئيسية';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -10;

    protected static ?string $slug = 'hub';

    protected string $view = 'filament.viewer.pages.hub';
}
