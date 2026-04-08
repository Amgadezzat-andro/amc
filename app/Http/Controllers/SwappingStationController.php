<?php

namespace App\Http\Controllers;

use App\Filament\Resources\SwappingStation\Model\SwappingStation;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SwappingStationController extends Controller
{
    public function index(): View
    {
        $stations = Cache::remember('swapping_stations_list', 300, function () {
            return SwappingStation::active()
                ->orderBy('weight_order')
                ->orderByDesc('published_at')
                ->get();
        });

        $stationsJson = $stations->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'address' => $s->address,
                'hours' => $s->hours,
                'lat' => (float) $s->lat,
                'lng' => (float) $s->lng,
            ];
        });

        return view('swapping-stations.index', [
            'stations' => $stations,
            'stationsJson' => $stationsJson,
        ]);
    }
}
