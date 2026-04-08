<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AboutUsBmsSeeder extends Seeder
{
    private function mimeFromExt(string $ext): string
    {
        return match (strtolower($ext)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
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
        $assets = base_path('Frontend/assets');

        $heroImageId = $this->ensureMedia("{$assets}/AMC Background.png", 'About Us Hero');
        $nabilImageId = $this->ensureMedia("{$assets}/Nabil Abi Zeid.jpg", 'Nabil Y. Abi Zeid');
        $jadImageId = $this->ensureMedia("{$assets}/Jad Abi Zeid.JPG", 'Jad N. Abi Zeid');
        $elieImageId = $this->ensureMedia("{$assets}/Elie N. Abi Zeid.jpg", 'Elie N. Abi Zeid');

        // Header section
        $headerId = $this->upsertBms('about-us-header-main', 'about-us-header-section', 1);
        $this->upsertBmsLang($headerId, [
            'title' => 'About A.M.C.',
            'brief' => '33 Years of Excellence in Audit, Accounting, and Consultancy Services',
            'image_id' => $heroImageId,
        ]);

        // History & Evolution
        $historyId = $this->upsertBms('about-us-history-main', 'about-us-history-and-evolution', 1);
        $this->upsertBmsLang($historyId, [
            'title' => 'History & Evolution',
            'content' => '<p>Accounting and Management Consultants is a Lebanese audit firm established in 1993 by two certified and experienced sworn auditors: Mr. Nabil Abi Zeid &amp; Mr. Tanios Karam, and registered under license no 47926 - Baabda - Lebanon on August 03, 1993. Our team of Auditors and Accountants provide a large range of Accounting, Audit and Assurance, Financial and Tax Consultancy services.</p><p>In response to evolving client needs and a commitment to optimized service delivery, we are pleased to announce the establishment of our sister company, Audit &amp; Management Consultants - A.M.C.</p><p>Founded on May 31, 2024, and licensed under number 1028 in Beirut, Lebanon, Audit &amp; Management Consultants - A.M.C. specializes in audit, tax, financial consultancy, and related professional services, mirroring the established expertise of Accounting &amp; Management Consultants.</p><p>This strategic formation allows for an internal segregation of services between the two entities, thereby enhancing our collective capacity to address the increasingly complex requirements of our clientele. Both firms will operate under the unified umbrella of "A.M.C.," ensuring a cohesive and integrated approach.</p><p>As a testament to the strong partnerships we\'ve built, today, we proudly serve as the auditors and advisors for 250 companies, both in Lebanon and across borders.</p>',
        ]);

        // Purpose & Future
        $purposeId = $this->upsertBms('about-us-purpose-main', 'about-us-propose-and-future', 1);
        $this->upsertBmsLang($purposeId, [
            'title' => 'Purpose & Future',
            'content' => '<p>Our mission is to provide professional audit, accounting, and financial services, delivered with unwavering integrity, meticulous precision, and steadfast independence. We empower businesses to not only achieve financial transparency but also to cultivate enduring growth, all while fostering a culture of continuous improvement that propels them forward. We believe in building more than just client relationships; we forge bonds of trust with those we serve, our valued partners, and our dedicated staff. Within our walls, we cultivate a diverse, inclusive, and dynamic environment - a vibrant ecosystem where innovation flourishes and every professional can thrive.</p>',
            'content2' => '<p>Our vision? To be the leading audit firm in Lebanon, recognized for our unwavering integrity and exceptional standards. We aim to empower businesses with financial clarity and the confidence to achieve sustainable growth. We\'re building a future where our expert insights directly contribute to our clientele\'s success, making their achievements our shared victory. We\'re on track to set the benchmark for excellence and ethical practices, ensuring a landscape of lasting prosperity for our ecosystem.</p>',
        ]);

        // Our People cards (same content as about.html card reveal)
        $people1 = $this->upsertBms('about-us-people-nabil', 'about-us-our-people', 1);
        $this->upsertBmsLang($people1, [
            'title' => 'Nabil Y. Abi Zeid',
            'second_title' => 'At the heart of every possibility is our team',
            'brief' => 'Co-founder & Managing Partner - Sworn auditor, member of the Lebanese Association of Certified Public Accountants under the number 261, and member of the Arab Certified Public Accountants.',
            'image_id' => $nabilImageId,
            'content' => '<p>It\'s straightforward: our people drive success. Whether we\'re advancing towards a sustainable future or developing forward-thinking strategies, it\'s the teamwork and collaboration among our diverse team - a mix of talented men and women, many of whom are also parents, including CPAs, seasoned experts, and dedicated professionals, that make the difference.</p><p><strong>And we have more than 30 years worth of impact to prove it.</strong></p>',
        ]);

        $people2 = $this->upsertBms('about-us-people-jad', 'about-us-our-people', 2);
        $this->upsertBmsLang($people2, [
            'title' => 'Jad N. Abi Zeid',
            'brief' => 'Senior Manager - American CPA - New Hampshire Board of Accountancy, member of the Lebanese Association of Certified Public Accountants under number 2249. Holder of an MBA, Certificate in IFRS from ACCA, and Certificate in Startups Valuation from Duke University.',
            'image_id' => $jadImageId,
        ]);

        $people3 = $this->upsertBms('about-us-people-elie', 'about-us-our-people', 3);
        $this->upsertBmsLang($people3, [
            'title' => 'Elie N. Abi Zeid',
            'brief' => 'Audit Manager and Financial & Tax Advisor - Certified Public Accountant, member of the Lebanese Association under number 2745. Holder of a Master\'s in Accounting, Audit & Control; Certificate in IFRS from ACCA; Certificate in Private Equity and Venture Capital from Bocconi University; Certificate in Startups Valuation from Duke University. Head of NGO department.',
            'image_id' => $elieImageId,
        ]);

        // Partners
        $partnersId = $this->upsertBms('about-us-partners-main', 'about-use-partner', 1);
        $this->upsertBmsLang($partnersId, [
            'title' => 'Ecosystems and Trusted Relationships',
            'second_title' => 'Strategic International Partnerships',
            'content' => '<p>Through our strategic collaboration with international key partners, we combine expertise to tackle complex audit challenges, conduct thorough spot-checks and forensic audit missions, and deliver forward-thinking strategies. These partnerships empower our clients to manage risk effectively, foster innovation, reduce fraud risks, and achieve a distinct competitive advantage.</p>',
        ]);

        // Joint ventures
        $venturesId = $this->upsertBms('about-us-joint-ventures-main', 'about-use-joint-ventures', 1);
        $this->upsertBmsLang($venturesId, [
            'title' => 'Joint Ventures & Alliances',
            'second_title' => 'Legal & Regulatory Collaboration',
            'content' => '<p>Our commitment extends beyond financial expertise. We have established a strong partnership with leading legal consultants to ensure clients receive comprehensive support - addressing financial and audit needs while navigating legal and regulatory requirements with assurance and clarity. Together we provide a holistic approach that safeguards clients\' interests and enables them to operate with greater security and strategic foresight.</p>',
        ]);

        $venturesId2 = $this->upsertBms('about-us-joint-ventures-risk-main', 'about-use-joint-ventures', 2);
        $this->upsertBmsLang($venturesId2, [
            'title' => 'Joint Ventures & Alliances',
            'second_title' => 'Risk, Compliance & Strategic Support',
            'content' => '<p>Our alliances also extend to specialized professionals in risk advisory, compliance, and corporate structuring, enabling us to support clients with multidisciplinary solutions. This collaborative ecosystem helps clients strengthen governance, respond to regulatory complexity, and make confident strategic decisions with the benefit of coordinated expert guidance.</p>',
        ]);

        $this->command->info('AboutUsBmsSeeder completed successfully.');
    }
}
