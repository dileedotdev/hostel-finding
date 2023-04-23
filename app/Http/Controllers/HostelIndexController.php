<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Hostel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HostelIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $outstandingHostels = Hostel::with(['owner', 'categories', 'media'])
            ->withAggregate('votes', 'score')
            ->withCount('visitLogs')
            ->orderBy('visit_logs_count', 'desc')
            ->whereNotNull('found_at')
            ->limit(12)
            ->get()
        ;

        return view('hostels.index', [
            'outstandingHostels' => $outstandingHostels,
            'trendingCategories' => Category::withCount('hostels')->orderBy('hostels_count', 'desc')->limit(12)->get(),
            'trendingAmenities' => Amenity::withCount('hostels')->orderBy('hostels_count', 'desc')->limit(12)->get(),
        ]);
    }
}
