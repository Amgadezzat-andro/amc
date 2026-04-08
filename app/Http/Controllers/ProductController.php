<?php

namespace App\Http\Controllers;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Filament\Resources\Product\Model\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $categoryId = request()->integer('category', 0) ?: null;
        $brandId = request()->integer('brand', 0) ?: null;

        $query = Product::active()
            ->with(['mainImage', 'category', 'brand'])
            ->orderBy('weight_order')
            ->orderByDesc('published_at');
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        $data['products'] = $query->paginate(12)->onEachSide(2)->withQueryString();
        $data['productsTotal'] = Product::active()->count();
        $data['categoryCounts'] = Product::active()
            ->reorder()
            ->selectRaw('category_id, count(*) as c')
            ->groupBy('category_id')
            ->pluck('c', 'category_id');
        $data['currentCategory'] = $categoryId;
        $data['currentBrand'] = $brandId;

        $locale = app()->getLocale();
        $data['productCategories'] = Cache::rememberForever('product_categories_list_' . $locale, function () {
            return DropdownList::with('translations')->active()
                ->where('category', DropdownList::PRODUCT_CATEGORY)
                ->get()
                ->sortBy('title')
                ->values();
        });

        $data['productBrands'] = Cache::rememberForever('product_brands_list_' . $locale, function () {
            return DropdownList::with('translations')->active()
                ->where('category', DropdownList::PRODUCT_BRAND)
                ->get()
                ->sortBy('title')
                ->values();
        });

        return view('products.index', $data);
    }

    public function view($locale, $slug)
    {
        $product = Product::active()
            ->with(['mainImage', 'category', 'brand'])
            ->where('slug', $slug)
            ->firstOrFail();
        return view('products.view', ['product' => $product]);
    }
}
