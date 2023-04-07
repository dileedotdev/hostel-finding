<?php

declare(strict_types=1);

namespace App\Filament\Resources\VisitResource\Widgets;

use App\Models\Visit;
use Dinhdjj\FilamentModelWidgets\Stats\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->can('viewAny', Visit::class);
    }

    protected function getCards(): array
    {
        return [
            Card::query(Visit::whereVisitorId(null), now()->subMonth(), now())
                ->cache()
                ->count(label: __('stats.visit.count.*.guest')),
            Card::query(Visit::where('visitor_id', '!=', null), now()->subMonth(), now())
                ->cache()
                ->count(label: __('stats.visit.count.*.user')),
        ];
    }
}
