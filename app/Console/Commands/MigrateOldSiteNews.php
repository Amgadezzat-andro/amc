<?php

namespace App\Console\Commands;

use App\Filament\Resources\News\Model\News;
use App\Filament\Resources\News\Model\NewsLang;
use App\Models\Media\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateOldSiteNews extends Command
{
    protected $signature = 'migrate:old-site-news {--dry-run}';
    protected $description = 'Import news from old site (agenergies.co.tz) with images';

    private const OLD_BASE = 'https://agenergies.co.tz';

    private array $rows = [
        ['id' => 3, 'image' => 'upload/16915895705853.jpg', 'news_title' => 'Partnership with SCHNEIDER', 'description' => null, 'date' => '2023-06-27'],
        ['id' => 5, 'image' => 'upload/169158945012992.jpg', 'news_title' => 'Training with SUNSYNK', 'description' => null, 'date' => '2023-07-28'],
        ['id' => 6, 'image' => 'upload/169477500737397.jpg', 'news_title' => "ERB's AED 2023 Exhibition", 'description' => null, 'date' => '2023-09-15'],
        ['id' => 7, 'image' => 'upload/169883573049968.jpg', 'news_title' => 'AG Group at the Tanzania Mining & Investment Forum 2023', 'description' => null, 'date' => '2023-10-27'],
        ['id' => 8, 'image' => 'upload/169960644134224.jpg', 'news_title' => 'Unlocking Efficiency: The Power of Energy Audits', 'description' => null, 'date' => '2023-11-09'],
        ['id' => 9, 'image' => 'upload/171614410113430.jpeg', 'news_title' => 'Partnership with TRINA SOLAR', 'description' => null, 'date' => '2024-04-20'],
        ['id' => 10, 'image' => 'upload/171878356515764.jpg', 'news_title' => 'Uganda Tanzania Business Forum 2024', 'description' => null, 'date' => '2024-05-23'],
        ['id' => 11, 'image' => 'upload/171878377739021.png', 'news_title' => 'Tanzania-France Business Mission and Forum', 'description' => null, 'date' => '2024-05-27'],
        ['id' => 12, 'image' => 'upload/171878410435253.png', 'news_title' => 'panel discussion during Renewable Energy Week 2024', 'description' => null, 'date' => '2024-06-06'],
        ['id' => 13, 'image' => 'upload/171878442229054.png', 'news_title' => 'Renewable Energy Week 2024 - Tanzania', 'description' => null, 'date' => '2024-06-06'],
        ['id' => 14, 'image' => 'upload/171878493633278.png', 'news_title' => 'Malawi Investment and Trade Forum', 'description' => null, 'date' => '2024-12-06'],
        ['id' => 15, 'image' => 'upload/172086629924569.png', 'news_title' => 'BSL BATTERY TRAINING', 'description' => null, 'date' => '2024-07-11'],
        ['id' => 16, 'image' => 'upload/172838289638022.jpg', 'news_title' => 'VICTRON and BSL Training', 'description' => null, 'date' => '2024-09-23'],
        ['id' => 17, 'image' => 'upload/173537469845502.jpg', 'news_title' => 'AG Energies Recognized as the Outstanding Solar Energy Solutions Brand of 2024', 'description' => null, 'date' => '2024-12-05'],
    ];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        if ($dryRun) {
            $this->warn('Dry run – no DB or storage changes.');
        }

        Auth::onceUsingId(1);
        $descriptions = $this->loadDescriptions();
        $userId = 1;
        $now = now();
        $dir = 'media/' . $now->format('Y/m/d');

        foreach ($this->rows as $row) {
            $title = $row['news_title'];
            $content = $descriptions[$row['id']] ?? '';
            $slug = Str::slug($title);
            if (News::where('slug', $slug)->exists()) {
                $this->line("Skip (exists): {$title}");
                continue;
            }

            $imageUrl = self::OLD_BASE . '/' . ltrim($row['image'], '/');
            $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
            $name = Str::uuid()->toString();

            if (!$dryRun) {
                $response = Http::timeout(30)->get($imageUrl);
                if (!$response->successful()) {
                    $this->error("Download failed: {$imageUrl}");
                    continue;
                }
                $path = "{$dir}/{$name}.{$ext}";
                Storage::disk('public')->put($path, $response->body());
                $fullPath = storage_path('app/public/' . $path);
                $size = @getimagesize($fullPath);
                $width = $size[0] ?? null;
                $height = $size[1] ?? null;
                $sizeBytes = strlen($response->body());
                $mime = $size['mime'] ?? 'image/jpeg';

                $media = Media::create([
                    'disk' => 'public',
                    'directory' => $dir,
                    'visibility' => 'public',
                    'name' => $name,
                    'path' => $path,
                    'width' => $width,
                    'height' => $height,
                    'size' => $sizeBytes,
                    'type' => $mime,
                    'ext' => $ext,
                    'title' => $title,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]);

                $publishedAt = strtotime($row['date']) ?: time();
                $news = News::create([
                    'category_id' => 1,
                    'author' => 'Ag Energies',
                    'slug' => $slug,
                    'status' => 1,
                    'is_campaign' => 0,
                    'published_at' => $publishedAt,
                    'revision' => 1,
                    'changed' => 0,
                    'weight_order' => 10,
                    'views' => 0,
                ]);

                NewsLang::unguarded(fn () => NewsLang::create([
                    'news_id' => $news->id,
                    'language' => 'en',
                    'title' => $this->utf8mb3Safe($title),
                    'brief' => $this->utf8mb3Safe(Str::limit(strip_tags($content), 200)),
                    'content' => $this->utf8mb3Safe($content),
                    'image_id' => $media->id,
                ]));
            }

            $this->info("Imported: {$title}");
        }

        return 0;
    }

    private function loadDescriptions(): array
    {
        $path = base_path('database/data/old_news_descriptions.php');
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
