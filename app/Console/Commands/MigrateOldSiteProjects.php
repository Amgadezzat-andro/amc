<?php

namespace App\Console\Commands;

use App\Filament\Resources\Project\Model\Project;
use App\Filament\Resources\Project\Model\ProjectLang;
use App\Models\Media\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateOldSiteProjects extends Command
{
    protected $signature = 'migrate:old-site-projects {--dry-run}';
    protected $description = 'Import projects from old site (agenergies.co.tz) with main image and content';

    private const OLD_BASE = 'https://agenergies.co.tz';

    private array $categoryMap = [3 => 1, 4 => 2, 5 => 3];

    private array $rows = [
        ['id' => 3, 'image' => 'upload/16869947708553.jpg', 'title' => 'THE KAKANDE MINISTRIES IN KAMPALA UGANDA', 'category_id' => 3],
        ['id' => 5, 'image' => 'upload/168699572118042.jpg', 'title' => 'Maganzo hospital – Mwanza', 'category_id' => 3],
        ['id' => 6, 'image' => 'upload/168699713424761.jpg', 'title' => 'Mchukwi Mission Hospital', 'category_id' => 3],
        ['id' => 7, 'image' => 'upload/168700012842839.jpg', 'title' => 'St Francis Ifakara referral Regional Hospital', 'category_id' => 3],
        ['id' => 8, 'image' => 'upload/168700087148075.jpg', 'title' => 'Litembo Hospital and Liheti vocational training Center in Mbinga', 'category_id' => 3],
        ['id' => 9, 'image' => 'upload/168700183039416.jpg', 'title' => 'Don Bosco Morogoro', 'category_id' => 3],
        ['id' => 11, 'image' => 'upload/16870021983352.jpg', 'title' => 'Sisters of Mary Secondary School Congregation of the Philippines', 'category_id' => 3],
        ['id' => 12, 'image' => 'upload/16870032766841.jpg', 'title' => 'Capital Drilling (T) Limited Mwanza', 'category_id' => 3],
        ['id' => 13, 'image' => 'upload/168700312228111.jpg', 'title' => 'Climate Action Network – Tanzania', 'category_id' => 5],
        ['id' => 15, 'image' => 'upload/170772034247878.jpg', 'title' => 'ENGEN petrol station', 'category_id' => 3],
        ['id' => 16, 'image' => 'upload/170772067031754.jpg', 'title' => 'BELL COMMUNICATION', 'category_id' => 3],
        ['id' => 17, 'image' => 'upload/171637041226633.png', 'title' => 'Ghaddar Residence', 'category_id' => 4],
        ['id' => 18, 'image' => 'upload/171637020038740.jpg', 'title' => 'Sisters of St. Vincent Pallotti in Morogoro', 'category_id' => 3],
        ['id' => 19, 'image' => 'upload/173537065149435.png', 'title' => 'Paramiho', 'category_id' => 3],
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
            $title = $row['title'];
            $slug = Str::slug($title);
            if (Project::where('slug', $slug)->exists()) {
                $this->line("Skip (exists): {$title}");
                continue;
            }
            $content = $descriptions[$row['id']] ?? '';
            $parsed = $this->parseSpecsAndBenefits($content);
            $imageUrl = self::OLD_BASE . '/' . ltrim($row['image'], '/');
            $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
            $name = Str::uuid()->toString();
            $categoryId = $this->categoryMap[$row['category_id']] ?? 1;

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

                $project = Project::create([
                    'category_id' => $categoryId,
                    'slug' => $slug,
                    'status' => 1,
                    'published_at' => now(),
                    'weight_order' => 10,
                    'specifications' => $parsed['specifications'],
                    'benefits' => $parsed['benefits'],
                ]);

                ProjectLang::unguarded(fn () => ProjectLang::create([
                    'project_id' => $project->id,
                    'language' => 'en',
                    'title' => $this->utf8mb3Safe($title),
                    'brief' => $this->utf8mb3Safe(Str::limit(strip_tags($content), 300)),
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
        $path = base_path('database/data/old_project_descriptions.php');
        if (!is_file($path)) {
            return [];
        }
        return require $path;
    }

    private function parseSpecsAndBenefits(string $html): array
    {
        $specs = [];
        $benefits = [];
        $text = strip_tags(str_replace(['<br />', '<br>'], "\n", $html));
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (preg_match_all('/<li[^>]*>(.*?)<\/li>/si', $html, $liMatches)) {
            foreach ($liMatches[1] as $li) {
                $clean = trim(html_entity_decode(strip_tags($li), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($clean === '') {
                    continue;
                }
                $isBenefit = preg_match('/\b(reduce|lower|avoid|save|sustainable|reliable|support|empower|transform|improve|enhance|secure|provide|power|supply)\b/i', $clean);
                if ($isBenefit) {
                    $benefits[] = ['key' => Str::limit($clean, 40), 'value' => $clean];
                } else {
                    $specs[] = $this->specKeyValue($clean);
                }
            }
        }

        $bulletLines = preg_split('/\n|\r\n/', $text);
        foreach ($bulletLines as $line) {
            $line = trim($line);
            if (preg_match('/^[\-\*]\s*(.+)$/', $line, $m)) {
                $clean = trim($m[1]);
                if (strlen($clean) < 5) {
                    continue;
                }
                $isBenefit = preg_match('/\b(reduce|lower|avoid|save|sustainable|reliable|support|empower|transform|improve|enhance|secure)\b/i', $clean);
                if ($isBenefit) {
                    $benefits[] = ['key' => Str::limit($clean, 40), 'value' => $clean];
                } else {
                    $specs[] = $this->specKeyValue($clean);
                }
            }
        }

        if (preg_match_all('/(\d+)\s*(?:x\s*)?(?:pieces?\s+of\s+)?(?:PV\s+)?panels?\s+(?:of\s+)?(\d+)\s*W(?:atts?)?/i', $text, $m, PREG_SET_ORDER)) {
            foreach ($m as $x) {
                $specs[] = ['key' => 'PV panels', 'value' => "{$x[1]} x {$x[2]}W"];
            }
        }
        if (preg_match_all('/(\d+)\s*panels?\s+(?:of\s+)?(\d+)\s*w/i', $text, $m, PREG_SET_ORDER)) {
            foreach ($m as $x) {
                $specs[] = ['key' => 'PV panels', 'value' => "{$x[1]} x {$x[2]}W"];
            }
        }
        if (preg_match_all('/(\d+(?:\.\d+)?)\s*KW(?:\s+[\w\-]+)?\s*(?:hybrid|grid[- ]?tie|solar)?\s*inverter[^.]*?(?:(\d+)\s*KW)?/i', $text, $m, PREG_SET_ORDER)) {
            foreach (array_slice($m, 0, 3) as $x) {
                $val = isset($x[2]) ? $x[2] . ' KW' : $x[1] . ' KW';
                $specs[] = ['key' => 'Inverter', 'value' => $val];
            }
        }
        if (preg_match_all('/(\d+)\s*batter(?:y|ies)\s*(?:\([^)]+\))?\s*(?:of\s+)?(\d+)\s*Kwh/i', $text, $m, PREG_SET_ORDER)) {
            foreach (array_slice($m, 0, 2) as $x) {
                $specs[] = ['key' => 'Batteries', 'value' => "{$x[1]} x {$x[2]} Kwh"];
            }
        }
        if (preg_match_all('/(\d+(?:\.\d+)?)\s*KWp?\s*(?:solar|PV)?/i', $text, $m, PREG_SET_ORDER)) {
            $seen = [];
            foreach ($m as $x) {
                $v = $x[1] . ' KWp';
                if (!in_array($v, $seen, true)) {
                    $seen[] = $v;
                    $specs[] = ['key' => 'System size', 'value' => $v];
                }
            }
        }
        if (preg_match_all('/(\d+)\s*KWH?\s*(?:lithium\s+)?battery/i', $text, $m, PREG_SET_ORDER)) {
            foreach (array_slice($m, 0, 2) as $x) {
                $specs[] = ['key' => 'Battery bank', 'value' => $x[1] . ' KWh'];
            }
        }

        $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $benefitKeywords = '/\b(reduce|lower|avoid|save|sustainable|reliable|support|empower|transform|improve|enhance|secure|provide|power|supply|cost-effective|day\s+and\s+night|24\/24|never\s+go\s+dark|lifeline|hope)\b/i';
        foreach ($sentences as $s) {
            $s = trim($s);
            if (strlen($s) < 20 || strlen($s) > 250) {
                continue;
            }
            if (preg_match($benefitKeywords, $s) && !preg_match('/\d+\s*(?:PV|panels?|KW|batter)/i', $s)) {
                $benefits[] = ['key' => Str::limit($s, 45), 'value' => $s];
            }
        }

        $seenSpec = $seenBen = [];
        $specs = array_values(array_filter($specs, function ($s) use (&$seenSpec) {
            $k = ($s['key'] ?? '') . '|' . ($s['value'] ?? '');
            if (in_array($k, $seenSpec, true)) {
                return false;
            }
            $seenSpec[] = $k;
            return true;
        }));
        $benefits = array_values(array_filter($benefits, function ($b) use (&$seenBen) {
            $k = ($b['key'] ?? '') . '|' . ($b['value'] ?? '');
            if (in_array($k, $seenBen, true)) {
                return false;
            }
            $seenBen[] = $k;
            return true;
        }));
        return ['specifications' => array_slice($specs, 0, 20), 'benefits' => array_slice($benefits, 0, 15)];
    }

    private function specKeyValue(string $clean): array
    {
        if (preg_match('/^(\d+)\s*x\s*(\d+)\s*W/i', $clean, $m)) {
            return ['key' => 'PV panels', 'value' => "{$m[1]} x {$m[2]}W"];
        }
        if (preg_match('/^(\d+)\s*KW/i', $clean, $m)) {
            return ['key' => 'Capacity', 'value' => $m[1] . ' KW'];
        }
        $key = Str::limit($clean, 35);
        return ['key' => $key, 'value' => $clean];
    }

    private function utf8mb3Safe(string $s): string
    {
        $s = preg_replace_callback('/[\x{1D400}-\x{1D419}]/u', fn (array $m) => \chr(0x41 + mb_ord($m[0]) - 0x1D400), $s);
        return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $s);
    }
}
