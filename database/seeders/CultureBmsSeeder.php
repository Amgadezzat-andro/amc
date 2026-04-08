<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CultureBmsSeeder extends Seeder
{
    private function mimeFromExt(string $ext): string
    {
        return match (strtolower($ext)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            default => 'image/png',
        };
    }

    private function ensureMedia(string $src, string $title): int
    {
        $existing = DB::table('media')->where('title', $title)->value('id');
        if ($existing) {
            return (int) $existing;
        }

        $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        $uuid = (string) Str::uuid();
        $filename = "{$uuid}.{$ext}";
        $destDir = storage_path('app/public/media');

        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        copy($src, "{$destDir}/{$filename}");
        [$w, $h] = @getimagesize($src) ?: [null, null];

        return DB::table('media')->insertGetId([
            'disk' => 'public',
            'directory' => 'media',
            'visibility' => 'public',
            'name' => $uuid,
            'path' => "media/{$filename}",
            'width' => $w,
            'height' => $h,
            'size' => filesize($src),
            'type' => $this->mimeFromExt($ext),
            'ext' => $ext,
            'alt' => $title,
            'title' => $title,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }

    private function upsertBms(string $slug, string $category, int $weight): int
    {
        $id = DB::table('bms')->where('slug', $slug)->value('id');

        $payload = [
            'slug' => $slug,
            'category' => $category,
            'status' => 1,
            'weight_order' => $weight,
            'revision' => 1,
            'changed' => 0,
            'published_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
        ];

        if ($id) {
            DB::table('bms')->where('id', $id)->update($payload);
            return (int) $id;
        }

        $payload['created_at'] = now()->timestamp;
        return DB::table('bms')->insertGetId($payload);
    }

    private function upsertBmsLang(int $bmsId, array $fields): void
    {
        DB::table('bms_lang')
            ->where('parent_id', $bmsId)
            ->where('language', 'en')
            ->delete();

        DB::table('bms_lang')->insert(array_merge([
            'parent_id' => $bmsId,
            'language' => 'en',
        ], $fields));
    }

    public function run(): void
    {
        $assets = base_path('Frontend/assets/new');

        $heroImg = $this->ensureMedia("{$assets}/Picture19.png", 'Culture Header');
        $feature1Img = $this->ensureMedia("{$assets}/Picture20.png", 'Culture Commitment to Thriving');
        $feature2Img = $this->ensureMedia("{$assets}/Picture21.png", 'Culture Zero Corruption');
        $feature3Img = $this->ensureMedia("{$assets}/Picture22.png", 'Culture Work Life Balance');

        $riseRespectImg = $this->ensureMedia("{$assets}/Picture23.png", 'Culture Respect');
        $riseIntegrityImg = $this->ensureMedia("{$assets}/Picture23.png", 'Culture Integrity');
        $riseSkillsImg = $this->ensureMedia("{$assets}/Picture24.png", 'Culture Skills');
        $riseEqualityImg = $this->ensureMedia("{$assets}/Picture25.png", 'Culture Equality');

        $equity1Img = $this->ensureMedia("{$assets}/Picture26.png", 'Culture DEI');
        $equity2Img = $this->ensureMedia("{$assets}/Picture27.png", 'Culture Supporting Families');
        $equity3Img = $this->ensureMedia("{$assets}/Picture28.png", 'Culture Fair Recruitment');
        $equity4Img = $this->ensureMedia("{$assets}/Picture29.png", 'Culture Women Inclusion');

        // Header
        $headerId = $this->upsertBms('culture-header-main', 'culture-header', 1);
        $this->upsertBmsLang($headerId, [
            'title' => 'Possibility starts with our people',
            'brief' => 'A legacy of over 30 years proves one simple truth: our people make it happen. Through their collaboration and connection, they are driving a more sustainable future and developing groundbreaking solutions. Our strong culture, built on a foundation of shared values, empowers every team member to make an impact.',
            'image_id' => $heroImg,
        ]);

        // Feature cards (How We Do)
        $feature1Id = $this->upsertBms('culture-feature-commitment', 'culture-feature-card', 1);
        $this->upsertBmsLang($feature1Id, [
            'title' => 'Commitment to Thriving',
            'brief' => 'In today\'s dynamic business environment, we recognize that engagement alone can lead to burnout. To support our employees\' well-being, we conduct an annual thriving survey to assess their mental health and help empower them during work hours.',
            'image_id' => $feature1Img,
        ]);

        $feature2Id = $this->upsertBms('culture-feature-corruption', 'culture-feature-card', 2);
        $this->upsertBmsLang($feature2Id, [
            'title' => 'Zero tolerance for Corruption',
            'brief' => 'We are committed to integrity, transparency, and ethical conduct. With a zero-tolerance policy on corruption, we promote a culture of honesty and accountability while ensuring fair and ethical practices to prevent violations.',
            'image_id' => $feature2Img,
        ]);

        $feature3Id = $this->upsertBms('culture-feature-balance', 'culture-feature-card', 3);
        $this->upsertBmsLang($feature3Id, [
            'title' => 'Championing Work-Life Balance',
            'brief' => 'We believe true success includes both professional achievement and a healthy work-life balance. We are committed to fostering an environment where employees can excel in their careers while also attending to their personal lives.',
            'image_id' => $feature3Img,
        ]);

        // RISE Values
        $respectId = $this->upsertBms('culture-rise-respect', 'culture-core-value-respect', 1);
        $this->upsertBmsLang($respectId, [
            'title' => 'Respect',
            'brief' => 'This commitment helps us attract and retain talent, strengthening our long-term success with all stakeholders, by fostering a positive, productive workplace where everyone feels valued and empowered.',
            'image_id' => $riseRespectImg,
        ]);

        $integrityId = $this->upsertBms('culture-rise-integrity', 'culture-core-value-integrity', 1);
        $this->upsertBmsLang($integrityId, [
            'title' => 'Integrity',
            'brief' => 'We value trust and honesty, committing to transparency, accountability, and the highest ethical standards in all interactions with employees, clients, and partners.',
            'image_id' => $riseIntegrityImg,
        ]);

        $skillsId = $this->upsertBms('culture-rise-skills', 'culture-core-value-skills', 1);
        $this->upsertBmsLang($skillsId, [
            'title' => 'Skills',
            'brief' => 'We prioritize continuous learning and skill development, encouraging our team to enhance both technical and soft skills through workshops and training to deliver exceptional service to our clients.',
            'image_id' => $riseSkillsImg,
        ]);

        $equalityId = $this->upsertBms('culture-rise-equality', 'culture-core-value-Equaility', 1);
        $this->upsertBmsLang($equalityId, [
            'title' => 'Equality',
            'brief' => 'We ensure all employees are treated with fairness, respect, and dignity. Through merit-based recruitment, promotion, and retention, we promote equity and fairness in all stakeholder interactions.',
            'image_id' => $riseEqualityImg,
        ]);

        // Equity-driven section: intro + cards in same category
        $equityIntroId = $this->upsertBms('culture-equity-intro', 'culture-equity-driven-card', 1);
        $this->upsertBmsLang($equityIntroId, [
            'title' => 'Equity-Driven Culture',
            'brief' => 'We strive to be the employer of choice by fostering an environment where talent is valued, development is prioritized, and employees thrive.',
        ]);

        $equityCard1Id = $this->upsertBms('culture-equity-dei', 'culture-equity-driven-card', 2);
        $this->upsertBmsLang($equityCard1Id, [
            'title' => 'Commitment to Diversity, Equity & Inclusion',
            'brief' => 'As part of our commitment to Diversity, Equity & Inclusion, we are dedicated to advancing five key agendas: enhancing gender diversity and equality, promoting intersectional justice and equity, addressing socio-economic disparities and fostering social mobility, supporting multi-generational talent throughout all life stages, and building an accessible, inclusive workplace for individuals of all abilities.',
            'image_id' => $equity1Img,
        ]);

        $equityCard2Id = $this->upsertBms('culture-equity-families', 'culture-equity-driven-card', 3);
        $this->upsertBmsLang($equityCard2Id, [
            'title' => 'Supporting Families',
            'brief' => 'We support staff with family responsibilities through a family-sensitive approach. Our policy includes enhanced maternity, paternity, adoption, care leave for child and elderly care, and shared family leave.',
            'image_id' => $equity2Img,
        ]);

        $equityCard3Id = $this->upsertBms('culture-equity-recruitment', 'culture-equity-driven-card', 4);
        $this->upsertBmsLang($equityCard3Id, [
            'title' => 'Fair & Bias-Free Recruitment',
            'brief' => 'Our recruitment policy serves as a roadmap for attracting and selecting talent that not only meets the demands of our dynamic industry but also reflects diverse perspectives and backgrounds, ensuring uniformity and fairness towards all candidates.',
            'image_id' => $equity3Img,
        ]);

        $equityCard4Id = $this->upsertBms('culture-equity-women', 'culture-equity-driven-card', 5);
        $this->upsertBmsLang($equityCard4Id, [
            'title' => 'Supporting and Accelerating Women Inclusion',
            'brief' => 'We take pride in being part of the SAWI (Support and Accelerate Women Inclusion) initiative Phase 2 in partnership with LLWB, AUB, MEPI, and TELFER. Through inclusive human capital policies, we built an environment that values and accelerates women\'s inclusion, and we were recognized among the top three employers in the MENA region.',
            'image_id' => $equity4Img,
        ]);

        $this->command->info('CultureBmsSeeder completed successfully.');
    }
}
