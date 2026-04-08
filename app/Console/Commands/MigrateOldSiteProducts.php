<?php

namespace App\Console\Commands;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Filament\Resources\Product\Model\Product;
use App\Filament\Resources\Product\Model\ProductLang;
use App\Models\Media\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateOldSiteProducts extends Command
{
    protected $signature = 'migrate:old-site-products {--dry-run}';
    protected $description = 'Import products from old site; requires categories/brands migrated first';

    private const OLD_BASE = 'https://agenergies.co.tz';

    private array $oldCategoryIdToSlug = [
        6 => 'solar-panels',
        16 => 'batteries',
        19 => 'inverters',
        20 => 'solar-water-heaters',
        21 => 'solar-water-pumps',
        22 => 'solar-system-accessories',
        23 => 'domestic-and-commercial-electrical-components',
        24 => 'small-solar-systems',
        25 => 'pump-system',
        26 => 'water-heater-accessories',
        27 => 'streetlight',
        28 => 'pv-cable',
        29 => 'fuse',
        30 => 'portable-power-station',
    ];

    private array $oldBrandIdToSlug = [
        3 => 'ocean-3',
        4 => 'byd-4',
        5 => 'solar-born-5',
        6 => 'lead-acid-6',
        8 => 'ja-8',
        9 => 'schneider-9',
        10 => 'wochn-10',
        11 => 'growatt-11',
        12 => 'growatt-12',
        13 => 'ag-13',
        14 => 'ritar-14',
        15 => 'suntree-15',
        16 => 'schneider-16',
        17 => 'growatt-17',
        18 => 'synsynk-18',
        19 => 'schneider-19',
        20 => 'ag-20',
        21 => 'samking-21',
        22 => 'suntree-22',
        23 => 'suntree-23',
        24 => 'growatt-24',
    ];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        if ($dryRun) {
            $this->warn('Dry run – no DB or storage changes.');
        }
        Auth::onceUsingId(1);
        $products = $this->loadProducts();
        if (empty($products)) {
            $this->warn('No products in database/data/old_products.php');
            return 0;
        }
        $categoryIdMap = DropdownList::where('category', DropdownList::PRODUCT_CATEGORY)
            ->get()
            ->keyBy('slug')
            ->map(fn ($i) => $i->id);
        $brandIdMap = DropdownList::where('category', DropdownList::PRODUCT_BRAND)
            ->get()
            ->keyBy('slug')
            ->map(fn ($i) => $i->id);

        $userId = 1;
        $now = now();
        $dir = 'media/' . $now->format('Y/m/d');

        foreach ($products as $row) {
            $catSlug = $this->oldCategoryIdToSlug[$row['category_id']] ?? null;
            $brandSlug = $this->oldBrandIdToSlug[$row['brand_id']] ?? null;
            $newCategoryId = $catSlug ? ($categoryIdMap[$catSlug] ?? null) : null;
            $newBrandId = $brandSlug ? ($brandIdMap[$brandSlug] ?? null) : null;
            if (!$newCategoryId || !$newBrandId) {
                $this->line("Skip product {$row['product_id']}: category or brand not found.");
                continue;
            }

            $slug = Str::slug(Str::limit($row['product_title'], 80)) . '-' . $row['product_id'];
            if (Product::where('slug', $slug)->exists()) {
                $this->line("Skip (exists): {$row['product_title']}");
                continue;
            }

            $brief = trim($row['description'] ?? '') ?: trim($row['more_description'] ?? '');
            $imageId = null;

            if (!empty($row['image1']) && !$dryRun) {
                $imageUrl = self::OLD_BASE . '/' . ltrim($row['image1'], '/');
                try {
                    $response = Http::timeout(60)->connectTimeout(30)->get($imageUrl);
                } catch (\Illuminate\Http\Client\ConnectionException $e) {
                    $this->warn("Image skip (unreachable): {$imageUrl}");
                    $response = null;
                }
                if ($response && $response->successful()) {
                    $ext = pathinfo($row['image1'], PATHINFO_EXTENSION) ?: 'jpg';
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
                        'title' => $row['product_title'],
                        'created_by' => $userId,
                        'updated_by' => $userId,
                    ]);
                    $imageId = $media->id;
                }
            }

            if (!$dryRun) {
                $product = Product::create([
                    'category_id' => $newCategoryId,
                    'brand_id' => $newBrandId,
                    'slug' => $slug,
                    'status' => (int) ($row['product_status'] ?? 1),
                    'published_at' => now(),
                    'weight_order' => 10,
                    'specifications' => [],
                ]);
                ProductLang::unguarded(fn () => ProductLang::create([
                    'product_id' => $product->id,
                    'language' => 'en',
                    'title' => $this->utf8mb3Safe($row['product_title']),
                    'brief' => $this->utf8mb3Safe(Str::limit($brief, 500)),
                    'image_id' => $imageId,
                ]));
            }
            $this->info("Product: {$row['product_title']}");
        }

        return 0;
    }

    private function loadProducts(): array
    {
        $path = base_path('database/data/old_products.php');
        if (!is_file($path)) {
            return [];
        }
        return require $path;
    }

    private function utf8mb3Safe(string $s): string
    {
        $s = preg_replace_callback('/[\x{1D400}-\x{1D419}]/u', fn (array $m) => \chr(0x41 + mb_ord($m[0]) - 0x1D400), $s);
        return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $s);
    }
}
