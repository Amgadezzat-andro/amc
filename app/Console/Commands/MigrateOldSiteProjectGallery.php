<?php

namespace App\Console\Commands;

use App\Filament\Resources\Project\Model\Project;
use App\Models\Media\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateOldSiteProjectGallery extends Command
{
    protected $signature = 'migrate:old-site-project-gallery {--dry-run}';
    protected $description = 'Import project gallery images from old site into Project.gallery_image_ids';

    private const OLD_BASE = 'https://agenergies.co.tz';

    private array $oldProjectIdToSlug = [
        3 => 'the-kakande-ministries-in-kampala-uganda',
        6 => 'mchukwi-mission-hospital',
        12 => 'capital-drilling-t-limited-mwanza',
        15 => 'engen-petrol-station',
        16 => 'bell-communication',
        17 => 'ghaddar-residence',
        18 => 'sisters-of-st-vincent-pallotti-in-morogoro',
    ];

    private array $rows = [
        ['project_id' => 2, 'image' => 'upload/168149693944435.jpg'],
        ['project_id' => 2, 'image' => 'upload/168149693922047.jpg'],
        ['project_id' => 2, 'image' => 'upload/168149694015834.jpg'],
        ['project_id' => 2, 'image' => 'upload/168149694038152.jpg'],
        ['project_id' => 2, 'image' => 'upload/168149694046807.jpg'],
        ['project_id' => 3, 'image' => 'upload/168699492823623.jpg'],
        ['project_id' => 3, 'image' => 'upload/16869949284700.jpg'],
        ['project_id' => 3, 'image' => 'upload/168699502631705.jpg'],
        ['project_id' => 6, 'image' => 'upload/16916567776202.jpg'],
        ['project_id' => 6, 'image' => 'upload/169165677739319.jpg'],
        ['project_id' => 12, 'image' => 'upload/16916573716410.jpg'],
        ['project_id' => 12, 'image' => 'upload/169165737142163.jpg'],
        ['project_id' => 12, 'image' => 'upload/16916573716737.jpg'],
        ['project_id' => 12, 'image' => 'upload/16916573711989.jpg'],
        ['project_id' => 12, 'image' => 'upload/169165737141326.jpg'],
        ['project_id' => 15, 'image' => 'upload/170772041826820.jpg'],
        ['project_id' => 15, 'image' => 'upload/170772041830990.jpg'],
        ['project_id' => 15, 'image' => 'upload/170772041822173.jpg'],
        ['project_id' => 15, 'image' => 'upload/17077204189934.jpg'],
        ['project_id' => 16, 'image' => 'upload/170772080429356.jpg'],
        ['project_id' => 16, 'image' => 'upload/170772080441049.jpg'],
        ['project_id' => 16, 'image' => 'upload/170772080416641.jpg'],
        ['project_id' => 16, 'image' => 'upload/170772080425105.jpg'],
        ['project_id' => 17, 'image' => 'upload/170772122328754.jpg'],
        ['project_id' => 17, 'image' => 'upload/17077212232688.jpg'],
        ['project_id' => 17, 'image' => 'upload/170772122340617.jpg'],
        ['project_id' => 17, 'image' => 'upload/170772122349350.jpg'],
        ['project_id' => 18, 'image' => 'upload/171602308338952.jpg'],
        ['project_id' => 18, 'image' => 'upload/171602308338453.jpg'],
        ['project_id' => 18, 'image' => 'upload/171602308315143.jpg'],
        ['project_id' => 18, 'image' => 'upload/171602308339082.jpg'],
        ['project_id' => 18, 'image' => 'upload/17160230833244.jpg'],
        ['project_id' => 18, 'image' => 'upload/171637011913659.jpg'],
        ['project_id' => 18, 'image' => 'upload/17163701196424.jpg'],
        ['project_id' => 18, 'image' => 'upload/171637011914629.jpg'],
        ['project_id' => 18, 'image' => 'upload/171637011910550.jpg'],
        ['project_id' => 18, 'image' => 'upload/171637011922964.jpg'],
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
        $projectGalleryIds = [];

        foreach ($this->rows as $row) {
            $slug = $this->oldProjectIdToSlug[$row['project_id']] ?? null;
            if (!$slug) {
                continue;
            }
            $project = Project::where('slug', $slug)->first();
            if (!$project) {
                $this->line("Skip project not found: {$slug}");
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
                    'title' => "Gallery {$project->id}",
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]);

                $projectGalleryIds[$project->id] = $projectGalleryIds[$project->id] ?? $project->gallery_image_ids ?? [];
                $projectGalleryIds[$project->id][] = $media->id;
            }
            $this->info("Gallery image: {$slug} <- {$row['image']}");
        }

        if (!$dryRun && $projectGalleryIds) {
            foreach ($projectGalleryIds as $projectId => $ids) {
                Project::where('id', $projectId)->update(['gallery_image_ids' => $ids]);
            }
        }

        return 0;
    }
}
