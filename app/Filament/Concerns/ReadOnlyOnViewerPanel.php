<?php

namespace App\Filament\Concerns;

use Filament\Facades\Filament;

trait ReadOnlyOnViewerPanel
{
    protected static function isViewerPanel(): bool
    {
        return Filament::getCurrentPanel()?->getId() === 'viewer';
    }

    public static function canCreate(): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canCreate();
    }

    public static function canEdit($record): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canEdit($record);
    }

    public static function canDelete($record): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canDelete($record);
    }

    public static function canDeleteAny(): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canDeleteAny();
    }

    public static function canForceDelete($record): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canForceDelete($record);
    }

    public static function canForceDeleteAny(): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canForceDeleteAny();
    }

    public static function canRestore($record): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canRestore($record);
    }

    public static function canRestoreAny(): bool
    {
        if (static::isViewerPanel()) {
            return false;
        }

        return parent::canRestoreAny();
    }
}
