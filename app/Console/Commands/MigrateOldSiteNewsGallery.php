<?php

namespace App\Console\Commands;

use App\Filament\Resources\News\Model\News;
use App\Models\Media\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateOldSiteNewsGallery extends Command
{
    protected $signature = 'migrate:old-site-news-gallery {--dry-run}';
    protected $description = 'Import news gallery images from old site into News.gallery_image_ids';

    private const OLD_BASE = 'https://agenergies.co.tz';

    private array $oldNewsIdToSlug = [
        3 => 'partnership-with-schneider',
        5 => 'training-with-sunsynk',
        6 => 'erbs-aed-2023-exhibition',
        7 => 'ag-group-at-the-tanzania-mining-investment-forum-2023',
        9 => 'partnership-with-trina-solar',
        11 => 'tanzania-france-business-mission-and-forum',
        12 => 'panel-discussion-during-renewable-energy-week-2024',
        13 => 'renewable-energy-week-2024-tanzania',
        14 => 'malawi-investment-and-trade-forum',
        15 => 'bsl-battery-training',
        16 => 'victron-and-bsl-training',
    ];

    private array $rows = [
        ['news_id' => 6, 'image' => 'upload/169477662510489.jpg'],
        ['news_id' => 6, 'image' => 'upload/169477662548561.jpg'],
        ['news_id' => 6, 'image' => 'upload/169477662542673.jpg'],
        ['news_id' => 6, 'image' => 'upload/169477662547787.jpg'],
        ['news_id' => 6, 'image' => 'upload/169477662516074.jpg'],
        ['news_id' => 3, 'image' => 'upload/169502846725661.jpg'],
        ['news_id' => 3, 'image' => 'upload/16950284678033.jpg'],
        ['news_id' => 3, 'image' => 'upload/169502846717208.jpg'],
        ['news_id' => 3, 'image' => 'upload/169502846748717.jpg'],
        ['news_id' => 3, 'image' => 'upload/169502846732850.jpg'],
        ['news_id' => 5, 'image' => 'upload/16950285197420.jpg'],
        ['news_id' => 5, 'image' => 'upload/169502851921267.jpg'],
        ['news_id' => 5, 'image' => 'upload/169502851910925.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673339207.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673325795.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673327628.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673349602.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673321704.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673336414.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673334425.jpg'],
        ['news_id' => 7, 'image' => 'upload/16988367336152.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673345560.jpg'],
        ['news_id' => 7, 'image' => 'upload/16988367338078.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673346271.jpg'],
        ['news_id' => 7, 'image' => 'upload/169883673331364.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123736900.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123739263.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123744135.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123719948.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123717012.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123726598.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123721689.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123730995.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123734910.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123737623.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123743615.jpg'],
        ['news_id' => 7, 'image' => 'upload/169884123722096.jpg'],
        ['news_id' => 9, 'image' => 'upload/171637002430872.png'],
        ['news_id' => 9, 'image' => 'upload/171637002438025.png'],
        ['news_id' => 9, 'image' => 'upload/171637002445703.png'],
        ['news_id' => 9, 'image' => 'upload/171637002440546.png'],
        ['news_id' => 9, 'image' => 'upload/17163700249459.png'],
        ['news_id' => 11, 'image' => 'upload/171878381348410.png'],
        ['news_id' => 11, 'image' => 'upload/171878381343742.png'],
        ['news_id' => 12, 'image' => 'upload/171878413923676.png'],
        ['news_id' => 12, 'image' => 'upload/171878413928813.png'],
        ['news_id' => 12, 'image' => 'upload/17187841398254.png'],
        ['news_id' => 13, 'image' => 'upload/17187845003926.png'],
        ['news_id' => 13, 'image' => 'upload/17187845001579.png'],
        ['news_id' => 13, 'image' => 'upload/171878450049441.png'],
        ['news_id' => 13, 'image' => 'upload/171878450042405.png'],
        ['news_id' => 13, 'image' => 'upload/171878450046951.png'],
        ['news_id' => 13, 'image' => 'upload/171878450046871.png'],
        ['news_id' => 13, 'image' => 'upload/171878450035117.png'],
        ['news_id' => 14, 'image' => 'upload/171878503419857.png'],
        ['news_id' => 14, 'image' => 'upload/17187850344769.png'],
        ['news_id' => 14, 'image' => 'upload/17187850344207.png'],
        ['news_id' => 14, 'image' => 'upload/17187850348963.png'],
        ['news_id' => 14, 'image' => 'upload/171878503422469.png'],
        ['news_id' => 14, 'image' => 'upload/171878503447322.png'],
        ['news_id' => 14, 'image' => 'upload/171878503441928.png'],
        ['news_id' => 14, 'image' => 'upload/171878503425841.png'],
        ['news_id' => 14, 'image' => 'upload/171878503437698.png'],
        ['news_id' => 14, 'image' => 'upload/171878503421351.png'],
        ['news_id' => 14, 'image' => 'upload/171878503413282.png'],
        ['news_id' => 14, 'image' => 'upload/17187850343621.png'],
        ['news_id' => 14, 'image' => 'upload/17187850344241.png'],
        ['news_id' => 14, 'image' => 'upload/171878503423622.png'],
        ['news_id' => 15, 'image' => 'upload/172086666723599.png'],
        ['news_id' => 15, 'image' => 'upload/172086666732645.png'],
        ['news_id' => 15, 'image' => 'upload/172086666712448.png'],
        ['news_id' => 15, 'image' => 'upload/172086666747040.png'],
        ['news_id' => 15, 'image' => 'upload/172086666747346.png'],
        ['news_id' => 16, 'image' => 'upload/172838294943289.jpg'],
        ['news_id' => 16, 'image' => 'upload/172838294936383.jpg'],
        ['news_id' => 16, 'image' => 'upload/172838294936070.jpg'],
        ['news_id' => 16, 'image' => 'upload/17283829493853.jpg'],
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
        $newsGalleryIds = [];

        foreach ($this->rows as $row) {
            $slug = $this->oldNewsIdToSlug[$row['news_id']] ?? null;
            if (!$slug) {
                continue;
            }
            $news = News::where('slug', $slug)->first();
            if (!$news) {
                $this->line("Skip news not found: {$slug}");
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
                    'title' => "Gallery {$news->id}",
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]);

                $newsGalleryIds[$news->id] = $newsGalleryIds[$news->id] ?? $news->gallery_image_ids ?? [];
                $newsGalleryIds[$news->id][] = $media->id;
            }
            $this->info("Gallery image: {$slug} <- {$row['image']}");
        }

        if (!$dryRun && $newsGalleryIds) {
            foreach ($newsGalleryIds as $newsId => $ids) {
                News::where('id', $newsId)->update(['gallery_image_ids' => $ids]);
            }
        }

        return 0;
    }
}
