<?php

namespace App\Filament\Resources\ToolsResource\Pages;

use App\Filament\Resources\ToolsResource;
use App\Models\Tools;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;

class ListTools extends ListRecords
{
    protected static string $resource = ToolsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // 1. Custom Tabs
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Data')
                ->icon('heroicon-o-user-group')
                ->iconPosition(IconPosition::After)
                ->badgeColor('danger')
                ->badge(Tools::query()->withTrashed()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->withTrashed()),
            'active' => Tab::make('Data Aktif')
                ->icon('heroicon-o-user-group')
                ->iconPosition(IconPosition::After)
                ->badgeColor('success')
                ->badge(Tools::query()->withoutTrashed()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->withoutTrashed()),
            'inactive' => Tab::make('Data Tidak Aktif')
                ->icon('heroicon-o-user-group')
                ->iconPosition(IconPosition::After)
                ->badgeColor('danger')
                ->badge(Tools::query()->onlyTrashed()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->onlyTrashed()),
        ];
    }

    // 2. By Default Tab yang terbuka mau mana dulu?
    public function getDefaultActiveTab(): string|int|null
    {
        return 'active';
    }
}
