<?php

namespace App\Http\Controllers;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Filament\Resources\News\Model\News;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index()
    {
        $data['latestNews'] = Cache::remember('news_latest_3', 300, function () {
            return News::active()
                ->with(['mainImage', 'category'])
                ->orderByDesc('published_at')
                ->limit(3)
                ->get();
        });

        $data['trendingNews'] = Cache::remember('news_trending_6', 300, function () {
            return News::active()
                ->with(['mainImage', 'category'])
                ->orderByDesc('views')
                ->limit(6)
                ->get();
        });

        $data['newsCategories'] = Cache::rememberForever('news_categories_list', function () {
            return DropdownList::with('translations')->active()
                ->where('category', DropdownList::NEWS_CATEGORY)
                ->orderBy('weight_order')
                ->get();
        });

        $data['allNews'] = Cache::remember('news_all', 300, function () {
            return News::active()->with(['mainImage', 'category'])->orderByDesc('published_at')->get();
        });

        return view('news.index', $data);
    }

    public function view($locale, $slug)
    {
        $data['targetItem'] = Cache::rememberForever("news_" . $slug . (new News())->getTable(), function () use ($slug) {
            return News::active()
                ->where('slug', $slug)
                ->first();
        });
        if ($data['targetItem']) {
            $data['targetItem']->increment('views');
            $data['relatedNews'] = Cache::rememberForever("related_news_" . $slug . (new News())->getTable(), function () use ($slug) {
                return News::active()
                    ->where('slug', '!=', $slug)
                    ->limit(6)
                    ->get();
            });

            return view('news.view', $data);
        }

        abort(404);
    }
}



