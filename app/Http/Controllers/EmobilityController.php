<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Emobility\Model\Emobility;
use Illuminate\Support\Facades\Cache;

class EmobilityController extends Controller
{
    public function index()
    {
        $data['vehicles'] = Cache::remember('emobility_list', 300, function () {
            return Emobility::active()
                ->with(['mainImage'])
                ->orderBy('weight_order')
                ->orderByDesc('published_at')
                ->get();
        });

        return view('emobility.index', $data);
    }

    public function view($locale, $slug)
    {
        $vehicle = Emobility::active()
            ->with(['mainImage'])
            ->where('slug', $slug)
            ->firstOrFail();
        return view('emobility.view', ['vehicle' => $vehicle]);
    }
}
