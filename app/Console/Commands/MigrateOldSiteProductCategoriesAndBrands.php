<?php

namespace App\Console\Commands;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Filament\Resources\DropdownList\Model\DropdownListLang;
use App\Models\Media\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateOldSiteProductCategoriesAndBrands extends Command
{
    protected $signature = 'migrate:old-site-product-categories-brands {--dry-run}';
    protected $description = 'Import product categories and brands from old site into DropdownList (Product Category, Product Brand)';

    private const OLD_BASE = 'https://agenergies.co.tz';

    private array $productCategories = [
        ['id' => 6, 'name' => 'Solar Panels', 'image' => 'upload/168612673415155.jpg', 'status' => 1],
        ['id' => 16, 'name' => 'Batteries', 'image' => 'upload/168612735645882.jpg', 'status' => 1],
        ['id' => 19, 'name' => 'Inverters', 'image' => 'upload/168612743829164.jpg', 'status' => 1],
        ['id' => 20, 'name' => 'Solar Water Heaters', 'image' => 'upload/16861276777612.jpg', 'status' => 1],
        ['id' => 21, 'name' => 'Solar Water Pumps', 'image' => 'upload/168612810026070.jpg', 'status' => 1],
        ['id' => 22, 'name' => 'Solar System Accessories', 'image' => 'upload/168612782435151.jpg', 'status' => 1],
        ['id' => 23, 'name' => 'Domestic and commercial electrical  components', 'image' => 'upload/16902807624138.jpg', 'status' => 1],
        ['id' => 24, 'name' => 'Small Solar Systems', 'image' => 'upload/16922697529151.jpg', 'status' => 1],
        ['id' => 25, 'name' => 'Pump System', 'image' => null, 'status' => 0],
        ['id' => 26, 'name' => 'Water Heater Accessories', 'image' => 'upload/169227149148251.png', 'status' => 1],
        ['id' => 27, 'name' => 'Streetlight', 'image' => 'upload/169227174146163.jpeg', 'status' => 1],
        ['id' => 28, 'name' => 'PV Cable', 'image' => 'upload/169227191312213.jpg', 'status' => 1],
        ['id' => 29, 'name' => 'FUSE', 'image' => 'upload/169227431613872.jpg', 'status' => 1],
        ['id' => 30, 'name' => 'Portable Power Station', 'image' => 'upload/171637475514286.png', 'status' => 1],
    ];

    private array $brands = [
        ['brand_id' => 3, 'category_id' => 6, 'name' => 'OCEAN'],
        ['brand_id' => 4, 'category_id' => 16, 'name' => 'BYD'],
        ['brand_id' => 5, 'category_id' => 6, 'name' => 'SOLAR BORN'],
        ['brand_id' => 6, 'category_id' => 16, 'name' => 'Lead Acid'],
        ['brand_id' => 8, 'category_id' => 6, 'name' => 'JA'],
        ['brand_id' => 9, 'category_id' => 19, 'name' => 'Schneider'],
        ['brand_id' => 10, 'category_id' => 22, 'name' => 'WOCHN'],
        ['brand_id' => 11, 'category_id' => 22, 'name' => 'GROWATT'],
        ['brand_id' => 12, 'category_id' => 22, 'name' => 'GROWATT'],
        ['brand_id' => 13, 'category_id' => 27, 'name' => 'AG'],
        ['brand_id' => 14, 'category_id' => 16, 'name' => 'RITAR'],
        ['brand_id' => 15, 'category_id' => 29, 'name' => 'SUNTREE'],
        ['brand_id' => 16, 'category_id' => 22, 'name' => 'SCHNEIDER'],
        ['brand_id' => 17, 'category_id' => 19, 'name' => 'GROWATT'],
        ['brand_id' => 18, 'category_id' => 19, 'name' => 'SYNSYNK'],
        ['brand_id' => 19, 'category_id' => 19, 'name' => 'SCHNEIDER'],
        ['brand_id' => 20, 'category_id' => 24, 'name' => 'AG'],
        ['brand_id' => 21, 'category_id' => 21, 'name' => 'SAMKING'],
        ['brand_id' => 22, 'category_id' => 28, 'name' => 'SUNTREE'],
        ['brand_id' => 23, 'category_id' => 29, 'name' => 'SUNTREE'],
        ['brand_id' => 24, 'category_id' => 30, 'name' => 'GROWATT'],
    ];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        if ($dryRun) {
            $this->warn('Dry run – no DB or storage changes.');
        }
        Auth::onceUsingId(1);
        $userId = 1;
        $now = now();
        $dir = 'media/' . $now->format('Y/m/d');
        $oldCategoryIdToNewId = [];

        foreach ($this->productCategories as $idx => $row) {
            $slug = Str::slug($row['name']);
            if (DropdownList::where('slug', $slug)->where('category', DropdownList::PRODUCT_CATEGORY)->exists()) {
                $this->line("Skip category (exists): {$row['name']}");
                continue;
            }
            $imageId = null;
            if ($row['image'] && !$dryRun) {
                $imageUrl = self::OLD_BASE . '/' . ltrim($row['image'], '/');
                $response = Http::timeout(30)->get($imageUrl);
                if ($response->successful()) {
                    $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                    $name = Str::uuid()->toString();
                    $path = "{$dir}/{$name}.{$ext}";
                    Storage::disk('public')->put($path, $response->body());
                    $fullPath = storage_path('app/public/' . $path);
                    $size = @getimagesize($fullPath);
                    $media = Media::create([
                        'disk' => 'public',
                        'directory' => $dir,
                        'visibility' => 'public',
                        'name' => $name,
                        'path' => $path,
                        'width' => $size[0] ?? null,
                        'height' => $size[1] ?? null,
                        'size' => strlen($response->body()),
                        'type' => $size['mime'] ?? 'image/jpeg',
                        'ext' => $ext,
                        'title' => $row['name'],
                        'created_by' => $userId,
                        'updated_by' => $userId,
                    ]);
                    $imageId = $media->id;
                }
            }

            if (!$dryRun) {
                $item = DropdownList::create([
                    'slug' => $slug,
                    'status' => $row['status'],
                    'category' => DropdownList::PRODUCT_CATEGORY,
                    'published_at' => now(),
                    'weight_order' => 10 + $idx,
                    'revision' => 0,
                    'changed' => 0,
                ]);
                $oldCategoryIdToNewId[$row['id']] = $item->id;
                DropdownListLang::unguarded(fn () => DropdownListLang::create([
                    'parent_id' => $item->id,
                    'language' => 'en',
                    'title' => $row['name'],
                    'image' => $imageId,
                ]));
            }
            $this->info("Category: {$row['name']}");
        }

        foreach ($this->brands as $row) {
            $slug = Str::slug($row['name']) . '-' . $row['brand_id'];
            if (DropdownList::where('slug', $slug)->where('category', DropdownList::PRODUCT_BRAND)->exists()) {
                $this->line("Skip brand (exists): {$row['name']}");
                continue;
            }
            if (!$dryRun) {
                $item = DropdownList::create([
                    'slug' => $slug,
                    'status' => 1,
                    'category' => DropdownList::PRODUCT_BRAND,
                    'published_at' => now(),
                    'weight_order' => 10,
                    'revision' => 0,
                    'changed' => 0,
                ]);
                DropdownListLang::unguarded(fn () => DropdownListLang::create([
                    'parent_id' => $item->id,
                    'language' => 'en',
                    'title' => $row['name'],
                ]));
            }
            $this->info("Brand: {$row['name']}");
        }

        return 0;
    }
}
