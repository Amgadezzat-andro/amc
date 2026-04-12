<?php

namespace Database\Seeders;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    private const LANGUAGE = 'en';

    public function run(): void
    {
        $categoryIds = [];
        $categories = [
            ['slug' => 'audit', 'title' => 'Audit', 'weight_order' => 1],
            ['slug' => 'tax', 'title' => 'Tax', 'weight_order' => 2],
            ['slug' => 'advisory', 'title' => 'Advisory', 'weight_order' => 3],
            ['slug' => 'company', 'title' => 'Company News', 'weight_order' => 4],
        ];

        foreach ($categories as $category) {
            $categoryIds[$category['slug']] = $this->ensureNewsCategory(
                slug: $category['slug'],
                title: $category['title'],
                weightOrder: $category['weight_order']
            );
        }

        $articles = [
            [
                'slug' => 'external-audit-best-practices-for-lebanese-smes-in-2026',
                'title' => 'External Audit Best Practices for Lebanese SMEs in 2026',
                'brief' => 'Small and medium enterprises face evolving audit requirements. Our certified professionals outline the key compliance steps, documentation standards, and common pitfalls to avoid during your next external audit cycle.',
                'category_slug' => 'audit',
                'published_at' => '2026-02-28',
                'reading_time' => 4,
                'image' => 'Frontend/assets/new/Picture3.png',
                'weight_order' => 1,
            ],
            [
                'slug' => 'understanding-vat-filing-changes-and-their-impact-on-cash-flow',
                'title' => 'Understanding VAT Filing Changes and Their Impact on Cash Flow',
                'brief' => 'Recent changes to VAT filing schedules in Lebanon require businesses to adjust their accounting cycles. This article explores practical strategies to maintain healthy cash flow while ensuring full regulatory compliance.',
                'category_slug' => 'tax',
                'published_at' => '2026-02-10',
                'reading_time' => 5,
                'image' => 'Frontend/assets/new/Picture5.png',
                'weight_order' => 2,
            ],
            [
                'slug' => 'mergers-acquisitions-due-diligence-essentials-in-a-volatile-economy',
                'title' => 'Mergers & Acquisitions: Due Diligence Essentials in a Volatile Economy',
                'brief' => 'Navigating M&A transactions requires rigorous financial due diligence, especially in challenging economic environments. A.M.C.\'s advisory team shares the framework we apply to protect client interests and uncover hidden risks.',
                'category_slug' => 'advisory',
                'published_at' => '2026-01-22',
                'reading_time' => 7,
                'image' => 'Frontend/assets/new/Picture6.png',
                'weight_order' => 3,
            ],
            [
                'slug' => 'amc-ranked-among-top-3-employers-for-women-inclusion-in-mena',
                'title' => 'A.M.C. Ranked Among Top 3 Employers for Women Inclusion in MENA',
                'brief' => 'A.M.C. has been recognized by SAWI as one of the top employers in the MENA region for implementing inclusive human capital policies. This milestone reflects our commitment to equity-driven workplace practices.',
                'category_slug' => 'company',
                'published_at' => '2026-01-08',
                'reading_time' => 3,
                'image' => 'Frontend/assets/new1.jpg',
                'weight_order' => 4,
            ],
            [
                'slug' => 'internal-control-review-building-resilience-against-financial-fraud',
                'title' => 'Internal Control Review: Building Resilience Against Financial Fraud',
                'brief' => 'Effective internal controls are the first line of defense against financial fraud and mismanagement. Our audit specialists walk through a structured approach to assessing and strengthening control frameworks.',
                'category_slug' => 'audit',
                'published_at' => '2025-12-18',
                'reading_time' => 5,
                'image' => 'Frontend/assets/new2.jpg',
                'weight_order' => 5,
            ],
            [
                'slug' => 'setting-up-a-company-in-the-uae-a-complete-guide-for-lebanese-entrepreneurs',
                'title' => 'Setting Up a Company in the UAE: A Complete Guide for Lebanese Entrepreneurs',
                'brief' => 'The UAE continues to attract Lebanese businesses seeking regional expansion. A.M.C.\'s corporate advisory team presents an end-to-end guide covering legal structures, licensing, and compliance requirements for 2026.',
                'category_slug' => 'advisory',
                'published_at' => '2025-12-05',
                'reading_time' => 6,
                'image' => 'Frontend/assets/new3.jpg',
                'weight_order' => 6,
            ],
        ];

        $now = now()->timestamp;
        foreach ($articles as $article) {
            $imageId = $this->ensureMedia(
                sourcePath: base_path($article['image']),
                title: 'News - ' . $article['title']
            );

            $newsId = DB::table('news')->where('slug', $article['slug'])->value('id');

            $newsPayload = [
                'category_id' => $categoryIds[$article['category_slug']] ?? null,
                'author' => 'A.M.C.',
                'slug' => $article['slug'],
                'status' => 1,
                'comment_status' => 1,
                'is_campaign' => 0,
                'published_at' => Carbon::parse($article['published_at'])->startOfDay()->timestamp,
                'updated_at' => $now,
                'updated_by' => 1,
                'revision' => 1,
                'changed' => 0,
                'view' => 'page',
                'layout' => 'main',
                'weight_order' => $article['weight_order'],
                'views' => 0,
                'reading_time' => $article['reading_time'],
            ];

            if ($newsId) {
                DB::table('news')->where('id', $newsId)->update($newsPayload);
            } else {
                $newsId = DB::table('news')->insertGetId(array_merge($newsPayload, [
                    'created_at' => $now,
                    'created_by' => 1,
                ]));
            }

            DB::table('news_lang')->updateOrInsert(
                [
                    'news_id' => $newsId,
                    'language' => self::LANGUAGE,
                ],
                [
                    'title' => $article['title'],
                    'image_id' => $imageId,
                    'brief' => $article['brief'],
                    'content' => '<p>' . e($article['brief']) . '</p>',
                    'pdf_file' => null,
                ]
            );
        }
    }

    private function ensureNewsCategory(string $slug, string $title, int $weightOrder): int
    {
        $now = now()->timestamp;

        $id = DB::table('dropdown_list')
            ->where('slug', $slug)
            ->where('category', DropdownList::NEWS_CATEGORY)
            ->value('id');

        $payload = [
            'slug' => $slug,
            'status' => 1,
            'category' => DropdownList::NEWS_CATEGORY,
            'weight_order' => $weightOrder,
            'published_at' => $now,
            'updated_at' => $now,
            'updated_by' => 1,
            'revision' => 1,
            'changed' => 0,
        ];

        if ($id) {
            DB::table('dropdown_list')->where('id', $id)->update($payload);
        } else {
            $id = DB::table('dropdown_list')->insertGetId(array_merge($payload, [
                'created_at' => $now,
                'created_by' => 1,
            ]));
        }

        DB::table('dropdown_list_lang')->updateOrInsert(
            ['parent_id' => $id, 'language' => self::LANGUAGE],
            ['title' => $title]
        );

        return $id;
    }

    private function ensureMedia(string $sourcePath, string $title): ?int
    {
        if (!file_exists($sourcePath)) {
            return null;
        }

        $existingId = DB::table('media')->where('title', $title)->value('id');
        if ($existingId) {
            return (int) $existingId;
        }

        $ext = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        $uuid = (string) Str::uuid();
        $filename = $uuid . '.' . $ext;

        $destDir = storage_path('app/public/media');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        copy($sourcePath, $destDir . '/' . $filename);
        [$width, $height] = @getimagesize($sourcePath) ?: [null, null];

        return DB::table('media')->insertGetId([
            'disk' => 'public',
            'directory' => 'media',
            'visibility' => 'public',
            'name' => $uuid,
            'path' => 'media/' . $filename,
            'width' => $width,
            'height' => $height,
            'size' => filesize($sourcePath),
            'type' => $this->mimeFromExt($ext),
            'ext' => $ext,
            'title' => $title,
            'alt' => $title,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }

    private function mimeFromExt(string $ext): string
    {
        return match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            default => 'image',
        };
    }
}
