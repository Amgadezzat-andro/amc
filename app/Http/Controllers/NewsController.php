<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Filament\Resources\News\Model\News;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index()
    {
        $lng = app()->getLocale();

        $data['lng'] = $lng;

        $data['newsBanner'] = Cache::remember("news_index_banner_{$lng}", now()->addMinutes(10), function () {
            return Bms::activeWithCategory('news-index-banner')->with(['mainImage', 'frontButtons'])->first();
        });

        $data['allNews'] = Cache::remember('news_all', 300, function () {
            return News::active()->with(['mainImage', 'category'])->orderByDesc('published_at')->get();
        });

        return view('news.index', $data);
    }

    public function view($locale, $slug)
    {
        $lng = app()->getLocale();

        $data['lng'] = $lng;

        $data['targetItem'] = News::active()
            ->where('slug', $slug)
            ->first();

        if (!$data['targetItem']) {
            abort(404);
        }

        $data['targetItem']->increment('views');

        $data['relatedNews'] = News::active()
            ->where('slug', '!=', $slug)
            ->with(['mainImage', 'category'])
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        return view('news.view', $data);
    }
}



