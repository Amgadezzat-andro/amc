<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServicesBmsSeeder extends Seeder
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

    private function upsertButton(string $bmsSlug, string $url, string $label): void
    {
        $buttonId = DB::table('button')->where('category_slug', $bmsSlug)->value('id');

        if (!$buttonId) {
            $buttonId = DB::table('button')->insertGetId([
                'category_slug' => $bmsSlug,
                'status' => 1,
                'weight_order' => 1,
                'published_at' => now()->timestamp,
                'created_at' => now()->timestamp,
                'updated_at' => now()->timestamp,
                'created_by' => 1,
                'updated_by' => 1,
                'revision' => 1,
                'changed' => 0,
            ]);
        }

        DB::table('button_lang')
            ->where('parent_id', $buttonId)
            ->where('language', 'en')
            ->delete();

        DB::table('button_lang')->insert([
            'parent_id' => $buttonId,
            'language' => 'en',
            'url' => $url,
            'label' => $label,
        ]);
    }

    public function run(): void
    {
        $assets = base_path('Frontend/assets');
        $new = "{$assets}/new";

        $imgHero = $this->ensureMedia("{$assets}/AMC Background no logo (1).jpg", 'Services Hero');
        $imgIndustries = $this->ensureMedia("{$new}/Picture7.png", 'Services Industries');
        $img12 = $this->ensureMedia("{$new}/Picture12.png", 'Services Audit Assurance');
        $img13 = $this->ensureMedia("{$new}/Picture13.png", 'Services Accounting Bookkeeping');
        $img14 = $this->ensureMedia("{$new}/Picture14.png", 'Services Payroll');
        $img15 = $this->ensureMedia("{$new}/Picture15.png", 'Services Tax Advisory');
        $img16 = $this->ensureMedia("{$new}/Picture16.png", 'Services Internal Control');
        $img17 = $this->ensureMedia("{$new}/Picture17.png", 'Services Mergers Acquisitions');
        $img18 = $this->ensureMedia("{$new}/Picture18.png", 'Services Human Capital');

        // Overview
        $overviewId = $this->upsertBms('services-overview-main', 'services-overview', 1);
        $this->upsertBmsLang($overviewId, [
            'title' => 'Our Services',
            'second_title' => 'Overview',
            'brief' => 'Comprehensive Audit, Tax, and Financial Advisory Solutions',
            'image_id' => $imgHero,
            'content' => '<p><strong>Lebanon, UAE, Iraq, Germany, UK, France, Monaco, Congo, Tunisia</strong></p><p>Comprehensive Audit &amp; Consultancy Services</p><p>We are specialized in a wide range of services, including External Audits, Tax Advisory, Tax Computation &amp; Declaration, Financial Consultancy, Accounting Services, Financial Reporting, Feasibility Study, Mergers &amp; Acquisitions and Internal Control Review.</p><p>Whether you are a startup, a small and medium sized entity (MSME), a large corporation or a non-governmental organization (NGO) in need of comprehensive audit services and seeking guidance, A.M.C. is committed to provide the expertise and support necessary for your success.</p>',
        ]);

        // Industries
        $industriesId = $this->upsertBms('services-industries-main', 'services-industries', 1);
        $this->upsertBmsLang($industriesId, [
            'title' => 'Industries',
            'second_title' => 'Tailored Solutions for Every Sector',
            'image_id' => $imgIndustries,
            'content' => '<p>We recognize the unique complexities inherent in every business. Therefore, we meticulously customize our approach to align precisely with specific organizational needs and objectives.</p><div class="grid grid-cols-1 sm:grid-cols-2 gap-3"><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Startups</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>NGOs</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Travel &amp; Hospitality</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Freight Forwarding</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Insurance &amp; Brokerage</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Construction</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Marketing &amp; Media</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Legal Cabinets</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Information Technology</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Consumer &amp; Retail</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Fashion &amp; Haute Couture</span></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><span>Various Industries</span></div></div>',
        ]);

        // What we do tabs
        $companySetupId = $this->upsertBms('services-what-we-do-company-setup-main', 'services-what-we-do-company-setup', 1);
        $this->upsertBmsLang($companySetupId, [
            'title' => 'Company Setup - Lebanon & UAE',
            'image_id' => $imgHero,
            'content' => '<p>For businesses seeking to establish a presence in Lebanon or the UAE, our audit firm provides comprehensive company setup services. We possess a deep understanding of the intricate regulatory landscapes in both jurisdictions, offering expert guidance on legal structures, registration procedures, licensing requirements, and compliance frameworks. Our commitment is to deliver a streamlined and efficient process, empowering a confident enterprise launch and the prioritization of core business objectives.</p>',
        ]);

        $auditId = $this->upsertBms('services-what-we-do-audit-and-assurance-main', 'services-what-we-do-audit-and-assurance', 2);
        $this->upsertBmsLang($auditId, [
            'title' => 'Audit & Assurance',
            'image_id' => $img12,
            'content' => '<p>Our external audit engagements adhere strictly to International Standards on Auditing (ISAs), following a precise, five-stage process:</p><ul><li>Understanding the business, its controls and information flows</li><li>Assessing financial reporting risk</li><li>Designing an integrated audit plan</li><li>Executing the Audit Plan</li><li>Issuing the Audit Report</li></ul><p>We also offer Agreed-Upon Procedures (AUP) services (ISRE 4400) by conducting specific, agreed-upon procedures for entities and third parties (e.g., NGOs and donors) and providing factual findings on financial or operational processes. Our flexible services, covering areas like accounts payable, receivables, purchases, and sales, deliver transparency without an audit opinion or assurance.</p>',
        ]);

        $accountingId = $this->upsertBms('services-what-we-do-accounting-and-bookkeeping-main', 'services-what-we-do-accounting-and-bookkeeping', 3);
        $this->upsertBmsLang($accountingId, [
            'title' => 'Accounting & Bookkeeping',
            'image_id' => $img13,
            'content' => '<p>Sustainable and profitable growth is a key challenge, especially for startups mindful of accountant costs. It hinges on good planning and accurate financial data.</p><p>A.M.C.\'s accounting department offers comprehensive services for financial clarity without overhead. We manage journal entries, reconciliations (bank, intercompany), payroll, NSSF, tax computations, and income statements.</p><p>Clients benefit from:</p><ul><li>Complete &amp; Accurate financial overview</li><li>Timely information</li><li>Full compliance with tax and accounting standards</li><li>Enhanced access to funds</li></ul>',
        ]);

        $payrollId = $this->upsertBms('services-what-we-do-payroll-main', 'services-what-we-do-payroll', 4);
        $this->upsertBmsLang($payrollId, [
            'title' => 'Payroll',
            'image_id' => $img14,
            'content' => '<p>Our team brings extensive expertise to every client relationship. We meticulously handle all facets of payroll operations, ensuring not only strict regulatory compliance but also effortless integration with your existing business processes. We understand the complexities of employment laws and tax regulations in Lebanon, and we\'re committed to precise record-keeping, accurate compensation, and timely disbursements.</p>',
        ]);

        $taxId = $this->upsertBms('services-what-we-do-tax-advisory-main', 'services-what-we-do-tax-advisory', 5);
        $this->upsertBmsLang($taxId, [
            'title' => 'Tax Advisory & Filing',
            'image_id' => $img15,
            'content' => '<p>This is what we do best. With more than 20 years of experience in the tax advisory field, we are currently the advisors to over 200 companies. Our tax professionals draw on their vast experience to provide companies with a seamless consultancy through all the challenges of tax compliance and maintaining an effective relationship with tax authorities.</p>',
        ]);

        $internalId = $this->upsertBms('services-what-we-do-internal-control-assessment-main', 'services-what-we-do-internal-control-assessment', 6);
        $this->upsertBmsLang($internalId, [
            'title' => 'Internal Control Assessment',
            'image_id' => $img16,
            'content' => '<p>We provide a systematic and objective evaluation of your organization\'s processes. We meticulously examine the design and effectiveness of your internal controls across all critical functions - from financial reporting and IT systems to operational efficiency and adherence to Lebanese regulations. Our objective? To pinpoint vulnerabilities, mitigate risks, and enhance the reliability of your information.</p>',
        ]);

        $maId = $this->upsertBms('services-what-we-do-mergers-main', 'services-what-we-do-mergers', 7);
        $this->upsertBmsLang($maId, [
            'title' => 'Mergers & Acquisitions',
            'image_id' => $img17,
            'content' => '<p>We are experts in offering comprehensive support, starting with identifying potential targets and accurate valuations, all the way through due diligence, negotiation, and structuring the final deal. We navigate the complexities of the market and Lebanese regulations to ensure a smooth, successful, and strategically beneficial outcome for you.</p>',
        ]);

        $humanId = $this->upsertBms('services-what-we-do-human-capital-main', 'services-what-we-do-human-capital', 8);
        $this->upsertBmsLang($humanId, [
            'title' => 'Human Capital',
            'image_id' => $img18,
            'content' => '<p>Partnering with A.M.C. for Human Capital services means more than just managing personnel; it means strategically aligning your workforce with your business objectives. We empower you to attract, retain, and develop top talent, mitigate HR-related risks, and foster a culture of excellence, positioning your organization for sustainable growth and success. We provide comprehensive support across a wide spectrum of critical areas, including organizational development, talent management, performance optimization, and HR policy development. We ensure not only strict regulatory compliance with Lebanese labor laws but also the cultivation of a thriving and productive work environment.</p>',
        ]);

        // Connect banner
        $connectId = $this->upsertBms('services-connect-us-banner-main', 'services-connect-us-banner', 1);
        $this->upsertBmsLang($connectId, [
            'title' => 'Joint Ventures & Alliances',
            'brief' => 'Through our strategic collaboration with different partners, we are combining expertise to tackle complex audit challenges, conduct thorough spot-checks, and deliver innovative solutions. This partnership enables us to help clients manage risk, drive innovation, and gain a competitive edge.',
            'image_id' => $img17,
        ]);

        $this->upsertButton('services-connect-us-banner-main', '/en/contact-us', 'Connect with us');

        $this->command->info('ServicesBmsSeeder completed successfully.');
    }
}
