<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeBmsSeeder extends Seeder
{
    // ----------------------------------------------------------------
    // Helpers
    // ----------------------------------------------------------------

    private function copyImage(string $src, string $ext): array
    {
        $uuid = (string) Str::uuid();
        $filename = "{$uuid}.{$ext}";
        $destDir  = storage_path('app/public/media');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }
        copy($src, "{$destDir}/{$filename}");
        [$w, $h] = @getimagesize($src) ?: [null, null];
        return [
            'uuid'     => $uuid,
            'filename' => $filename,
            'path'     => "media/{$filename}",
            'ext'      => $ext,
            'size'     => filesize($src),
            'width'    => $w,
            'height'   => $h,
            'type'     => $this->mimeFromExt($ext),
        ];
    }

    private function mimeFromExt(string $ext): string
    {
        return match (strtolower($ext)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            'webp'        => 'image/webp',
            'gif'         => 'image/gif',
            default       => 'image/png',
        };
    }

    private function insertMedia(array $img, string $title): int
    {
        return DB::table('media')->insertGetId([
            'disk'       => 'public',
            'directory'  => 'media',
            'visibility' => 'public',
            'name'       => $img['uuid'],
            'path'       => $img['path'],
            'width'      => $img['width'],
            'height'     => $img['height'],
            'size'       => $img['size'],
            'type'       => $img['type'],
            'ext'        => $img['ext'],
            'title'      => $title,
            'alt'        => $title,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }

    private function insertBms(string $slug, string $category, int $order): int
    {
        $existing = DB::table('bms')->where('slug', $slug)->value('id');
        if ($existing) {
            return $existing;
        }
        return DB::table('bms')->insertGetId([
            'slug'         => $slug,
            'category'     => $category,
        'status'       => 1, // STATUS_PUBLISHED
            'weight_order' => $order,
            'revision'     => 1,
            'changed'      => 0,
            'published_at' => now()->timestamp,
            'created_at'   => now()->timestamp,
            'updated_at'   => now()->timestamp,
        ]);
    }

    private function insertBmsLang(int $bmsId, string $lang, array $fields): void
    {
        DB::table('bms_lang')
            ->where('parent_id', $bmsId)
            ->where('language', $lang)
            ->delete();

        DB::table('bms_lang')->insert(array_merge([
            'parent_id' => $bmsId,
            'language'  => $lang,
        ], $fields));
    }

    private function insertButton(string $bmsSlug, string $url, string $label): void
    {
        $btnId = DB::table('button')->insertGetId([
            'category_slug' => $bmsSlug,
            'status'        => 1,
            'weight_order'  => 1,
            'published_at'  => now()->timestamp,
            'created_at'    => now()->timestamp,
            'updated_at'    => now()->timestamp,
            'created_by'    => 1,
            'updated_by'    => 1,
            'revision'      => 1,
            'changed'       => 0,
        ]);
        DB::table('button_lang')->insert([
            'parent_id' => $btnId,
            'language'  => 'en',
            'url'       => $url,
            'label'     => $label,
        ]);
    }

    // ----------------------------------------------------------------
    // Run
    // ----------------------------------------------------------------

    public function run(): void
    {
        $assets = base_path('Frontend/assets');
        $new    = "{$assets}/new";

        // ---- Upload images once ----
        $m = [];

        $m['bg']       = $this->insertMedia($this->copyImage("{$assets}/AMC Background.png", 'png'),          'AMC Background');
        $m['bg2']      = $this->insertMedia($this->copyImage("{$assets}/AMC Background no logo (1).jpg", 'jpg'), 'AMC Background 2');
        $m['pic1']     = $this->insertMedia($this->copyImage("{$new}/Picture1.png", 'png'),  'Our People');
        $m['pic2']     = $this->insertMedia($this->copyImage("{$new}/Picture2.png", 'png'),  'Gender Equity');
        $m['pic3']     = $this->insertMedia($this->copyImage("{$new}/Picture3.png", 'png'),  'History & Evolution');
        $m['pic4']     = $this->insertMedia($this->copyImage("{$new}/Picture4.png", 'png'),  'Purpose & Future');
        $m['pic5']     = $this->insertMedia($this->copyImage("{$new}/Picture5.png", 'png'),  'Joint Ventures');
        $m['pic6']     = $this->insertMedia($this->copyImage("{$new}/Picture6.png", 'png'),  'Core Competencies');
        $m['pic7']     = $this->insertMedia($this->copyImage("{$new}/Picture7.png", 'png'),  'Industries');
        $m['pic8']     = $this->insertMedia($this->copyImage("{$new}/Picture8.png", 'png'),  'How We Do');
        $m['pic9']     = $this->insertMedia($this->copyImage("{$new}/Picture9.png", 'png'),  'RISE Values');
        $m['pic10']    = $this->insertMedia($this->copyImage("{$new}/Picture10.png", 'png'), 'Careers');
        $m['pic11']    = $this->insertMedia($this->copyImage("{$new}/Picture11.png", 'png'), 'Internship');

        // ================================================================
        // HERO SLIDER  (5 slides)
        // ================================================================

        // Slide 1 – Who We Are
        $s1 = $this->insertBms('hp-slider-who-we-are', 'home-page-slider', 1);
        $this->insertBmsLang($s1, 'en', [
            'title'       => 'Who We Are',
            'brief'       => 'Accounting & Management Consultants (A.M.C.) is a Lebanese audit firm providing a range of Audit, Accounting, Financial, and Tax Consultancy services since 1993, powered by the expertise of our CPAs and professionals.',
            'image_id'    => $m['bg'],
            'button_text' => 'Book Your Consultation',
        ]);
        // CTA opens modal – no button record needed, uses button_text

        // Slide 2 – What We Do
        $s2 = $this->insertBms('hp-slider-what-we-do', 'home-page-slider', 2);
        $this->insertBmsLang($s2, 'en', [
            'title'    => 'What We Do',
            'brief'    => 'We deliver tailored Audit, Tax, and Financial Advisory services, tailored to the unique needs of every organization and industry.',
            'image_id' => $m['bg2'],
        ]);
        $this->insertButton('hp-slider-what-we-do', '/en/services', 'Discover Our Expertise');

        // Slide 3 – Our People
        $s3 = $this->insertBms('hp-slider-our-people', 'home-page-slider', 3);
        $this->insertBmsLang($s3, 'en', [
            'title'    => 'Our People: The Foundation of Possibility',
            'brief'    => 'For over 30 years, our team has turned expertise, collaboration, and integrity into results. By supporting well-being and ethical excellence, we create innovative solutions that drive lasting impact across every business we serve.',
            'image_id' => $m['pic1'],
        ]);
        $this->insertButton('hp-slider-our-people', '/en/culture#people', 'See What Drives Us');

        // Slide 4 – Gender Equity
        $s4 = $this->insertBms('hp-slider-gender-equity', 'home-page-slider', 4);
        $this->insertBmsLang($s4, 'en', [
            'title'    => 'Trailblazing Gender Equity in Lebanon',
            'brief'    => 'This recognition is fueled by the SAWI Support, Accelerate Women Inclusion Project (Phase 2) and robust Human Capital strategies and our partnerships with LLWB, AUB, USMEPI, and TELFER.',
            'image_id' => $m['pic2'],
        ]);
        $this->insertButton('hp-slider-gender-equity', '/en/culture#equity', 'See Our Impact');

        // Slide 5 – Careers
        $s5 = $this->insertBms('hp-slider-careers', 'home-page-slider', 5);
        $this->insertBmsLang($s5, 'en', [
            'title'    => 'Grow, Collaborate, and Belong Here',
            'brief'    => 'Join a workplace that values every diverse background and empowers high-performing careers. Review our open positions and start your journey with us.',
            'image_id' => $m['pic10'],
        ]);
        $this->insertButton('hp-slider-careers', '/en/careers', 'Apply Now');

        // ================================================================
        // ABOUT US  (4 cards)
        // ================================================================

        $a1 = $this->insertBms('hp-about-history', 'home-page-about-us', 1);
        $this->insertBmsLang($a1, 'en', [
            'title'    => 'History & Evolution',
            'brief'    => 'Established in 1993 by certified sworn auditors Mr. Nabil Abi Zeid & Mr. Tanios Karam. Today, we proudly serve as auditors and advisors for 250 companies.',
            'image_id' => $m['pic3'],
        ]);
        DB::table('bms')->where('id', $a1)->update(['code' => '/en/about-us#history']);

        $a2 = $this->insertBms('hp-about-purpose', 'home-page-about-us', 2);
        $this->insertBmsLang($a2, 'en', [
            'title'    => 'Purpose & Future',
            'brief'    => 'To be the leading audit firm in Lebanon, providing professional services with unwavering integrity, meticulous precision, and steadfast independence.',
            'image_id' => $m['pic4'],
        ]);
        DB::table('bms')->where('id', $a2)->update(['code' => '/en/about-us#purpose']);

        $a3 = $this->insertBms('hp-about-people', 'home-page-about-us', 3);
        $this->insertBmsLang($a3, 'en', [
            'title'    => 'Our People',
            'brief'    => 'At the heart of every possibility is our team. A diverse mix of talented CPAs, seasoned experts, and dedicated professionals with over 30 years of proven impact.',
            'image_id' => $m['pic1'],
        ]);
        DB::table('bms')->where('id', $a3)->update(['code' => '/en/about-us#people']);

        $a4 = $this->insertBms('hp-about-ventures', 'home-page-about-us', 4);
        $this->insertBmsLang($a4, 'en', [
            'title'    => 'Joint Ventures & Alliances',
            'brief'    => 'Strategic partnerships and sister company A.M.C., enhancing our collective capacity to address complex client requirements with integrated approach.',
            'image_id' => $m['pic5'],
        ]);
        DB::table('bms')->where('id', $a4)->update(['code' => '/en/about-us#ventures']);

        // ================================================================
        // SERVICES – OVERVIEW
        // ================================================================
        $sv1 = $this->insertBms('hp-services-overview', 'home-page-services-overview', 1);
        $this->insertBmsLang($sv1, 'en', [
            'title'        => 'Overview',
            'second_title' => 'Comprehensive solutions tailored to your business needs',
            'image_id'     => $m['pic4'],
            'content'      => '<p>We are specialized in a wide range of services, including External Audits, Tax Advisory, Tax Computation &amp; Declaration, Financial Consultancy, Accounting Services, Financial Reporting, Feasibility Study, Mergers &amp; Acquisitions, and Internal Control Review.</p><p>Whether you are a startup, a small and medium sized entity (MSME), a large corporation or a non-governmental organization (NGO) in need of comprehensive audit services and seeking guidance, A.M.C. is committed to provide the expertise and support necessary for your success.</p>',
        ]);
        $this->insertButton('hp-services-overview', '/en/services#overview', 'Learn more');

        // ================================================================
        // SERVICES – CORE COMPETENCIES
        // ================================================================
        $sv2 = $this->insertBms('hp-services-core', 'home-page-services-core', 1);
        $this->insertBmsLang($sv2, 'en', [
            'title'    => 'Core Competencies',
            'image_id' => $m['pic6'],
            'content'  => '<div class="competencies-grid">
  <div class="competency-item"><i class="fas fa-building"></i><span>Company Setup Lebanon &amp; UAE</span></div>
  <div class="competency-item"><i class="fas fa-clipboard-check"></i><span>Audit &amp; Assurance</span></div>
  <div class="competency-item"><i class="fas fa-calculator"></i><span>Accounting &amp; Bookkeeping</span></div>
  <div class="competency-item"><i class="fas fa-money-check-alt"></i><span>Payroll</span></div>
  <div class="competency-item"><i class="fas fa-file-invoice-dollar"></i><span>Tax Advisory &amp; Filing</span></div>
  <div class="competency-item"><i class="fas fa-shield-alt"></i><span>Internal Control Assessment</span></div>
  <div class="competency-item"><i class="fas fa-handshake"></i><span>Mergers &amp; Acquisitions</span></div>
  <div class="competency-item"><i class="fas fa-users-cog"></i><span>Human Capital</span></div>
</div>',
        ]);
        $this->insertButton('hp-services-core', '/en/services#what-we-do', 'Explore our services');

        // ================================================================
        // SERVICES – INDUSTRIES
        // ================================================================
        $sv3 = $this->insertBms('hp-services-industries', 'home-page-services-industries', 1);
        $this->insertBmsLang($sv3, 'en', [
            'title'    => 'Industries We Serve',
            'image_id' => $m['pic7'],
            'content'  => '<p>We recognize the unique complexities inherent in every business. Therefore, we meticulously customize our approach to align precisely with specific organizational needs and objectives.</p>
<div class="industries-list">
  <span class="industry-tag"><i class="fas fa-rocket"></i> Startups</span>
  <span class="industry-tag"><i class="fas fa-hands-helping"></i> NGOs</span>
  <span class="industry-tag"><i class="fas fa-plane"></i> Travel &amp; Hospitality</span>
  <span class="industry-tag"><i class="fas fa-shipping-fast"></i> Freight Forwarding</span>
  <span class="industry-tag"><i class="fas fa-shield-alt"></i> Insurance</span>
  <span class="industry-tag"><i class="fas fa-hard-hat"></i> Construction</span>
  <span class="industry-tag"><i class="fas fa-bullhorn"></i> Marketing &amp; Media</span>
  <span class="industry-tag"><i class="fas fa-laptop-code"></i> Information Technology</span>
  <span class="industry-tag"><i class="fas fa-shopping-bag"></i> Consumer &amp; Retail</span>
  <span class="industry-tag"><i class="fas fa-tshirt"></i> Fashion</span>
</div>',
        ]);
        $this->insertButton('hp-services-industries', '/en/services#industries', 'View all industries');

        // ================================================================
        // CULTURE – HOW WE DO
        // ================================================================
        $c1 = $this->insertBms('hp-culture-how-we-do', 'home-page-culture-how-we-do', 1);
        $this->insertBmsLang($c1, 'en', [
            'title'    => 'How We Do',
            'image_id' => $m['pic8'],
            'content'  => '<div class="culture-items">
  <div class="culture-item">
    <i class="fas fa-heart-pulse"></i>
    <div class="culture-item-content">
      <h4>Commitment to Thriving</h4>
      <p>We conduct annual thriving surveys to assess mental health and empower employees, ensuring well-being beyond engagement.</p>
    </div>
  </div>
  <div class="culture-item">
    <i class="fas fa-shield-halved"></i>
    <div class="culture-item-content">
      <h4>Zero Tolerance for Corruption</h4>
      <p>Committed to integrity and transparency with a zero-tolerance policy, promoting honesty and ethical conduct.</p>
    </div>
  </div>
  <div class="culture-item">
    <i class="fas fa-balance-scale"></i>
    <div class="culture-item-content">
      <h4>Work-Life Balance</h4>
      <p>Fostering an environment where employees excel professionally while maintaining healthy personal lives.</p>
    </div>
  </div>
</div>',
        ]);
        $this->insertButton('hp-culture-how-we-do', '/en/culture#how-we-do', 'Learn More');

        // ================================================================
        // CULTURE – RISE VALUES
        // ================================================================
        $c2 = $this->insertBms('hp-culture-rise-values', 'home-page-culture-rise-values', 1);
        $this->insertBmsLang($c2, 'en', [
            'title'    => 'RISE Values',
            'brief'    => 'Our culture forms the foundation of our success, promoting a dynamic, inclusive, and positive work environment.',
            'image_id' => $m['pic9'],
            'content'  => '<div class="rise-values-grid">
  <div class="rise-value-item">
    <div class="rise-icon"><i class="fas fa-handshake"></i></div>
    <h4>Respect</h4>
    <p>Fostering a positive workplace where everyone feels valued and empowered.</p>
  </div>
  <div class="rise-value-item">
    <div class="rise-icon"><i class="fas fa-certificate"></i></div>
    <h4>Integrity</h4>
    <p>Transparency, accountability, and ethical standards in all interactions.</p>
  </div>
  <div class="rise-value-item">
    <div class="rise-icon"><i class="fas fa-graduation-cap"></i></div>
    <h4>Skills</h4>
    <p>Continuous learning through workshops and training for exceptional service.</p>
  </div>
  <div class="rise-value-item">
    <div class="rise-icon"><i class="fas fa-equals"></i></div>
    <h4>Equality</h4>
    <p>Merit-based recruitment, promotion, and retention with fairness for all.</p>
  </div>
</div>',
        ]);
        $this->insertButton('hp-culture-rise-values', '/en/culture#rise-values', 'Explore Our Values');

        // ================================================================
        // CULTURE – EQUITY DRIVEN
        // ================================================================
        $c3 = $this->insertBms('hp-culture-equity-driven', 'home-page-culture-equity-drivin', 1);
        $this->insertBmsLang($c3, 'en', [
            'title'    => 'Equity-Driven Culture',
            'brief'    => 'Our equity-driven culture is built on fairness, respect, and equal opportunity for all.',
            'image_id' => $m['pic2'],
            'content'  => '<div class="equity-highlights">
  <div class="equity-item">
    <i class="fas fa-users"></i>
    <div class="equity-content">
      <h4>Diversity &amp; Inclusion</h4>
      <p>Advancing gender diversity, intersectional justice, and inclusive workplace for all abilities.</p>
    </div>
  </div>
  <div class="equity-item">
    <i class="fas fa-heart"></i>
    <div class="equity-content">
      <h4>Supporting Families</h4>
      <p>Enhanced maternity, paternity, adoption, and care leave for family responsibilities.</p>
    </div>
  </div>
  <div class="equity-item">
    <i class="fas fa-user-check"></i>
    <div class="equity-content">
      <h4>Fair Recruitment</h4>
      <p>Bias-free recruitment reflecting diverse perspectives and backgrounds.</p>
    </div>
  </div>
  <div class="equity-item">
    <i class="fas fa-trophy"></i>
    <div class="equity-content">
      <h4>Women Inclusion (SAWI)</h4>
      <p>Top 3 employer in MENA region for implementing inclusive human capital policies.</p>
    </div>
  </div>
</div>',
        ]);
        $this->insertButton('hp-culture-equity-driven', '/en/culture#equity', 'Discover More');

        // ================================================================
        // CAREERS
        // ================================================================
        $ca1 = $this->insertBms('hp-careers-why-amc', 'home-page-careers', 1);
        $this->insertBmsLang($ca1, 'en', [
            'title'    => 'Why AMC?',
            'brief'    => 'We recognize our people as our most valuable asset and are reimagining the employee experience to reflect that.',
            'image_id' => $m['pic10'],
            'content'  => '<p>We recognize our people as our most valuable asset and are reimagining the employee experience to reflect that. Over the past year, we personalized careers, prioritized well-being, and offered the flexibility our people need as their lives evolve.</p><p>Our inclusive culture values every voice and empowers individuals to grow, collaborate, and thrive. By embracing diverse backgrounds and experiences, we fuel innovation and create a workplace where everyone can build a meaningful, high-performing career.</p>',
        ]);
        $this->insertButton('hp-careers-why-amc', '/en/careers#jobs', 'Explore Opportunities');

        // ================================================================
        // INTERNSHIP
        // ================================================================
        $in1 = $this->insertBms('hp-internship-welcome', 'home-page-our-internship-program', 1);
        $this->insertBmsLang($in1, 'en', [
            'title'    => 'Welcome to Our Internship Program!',
            'brief'    => 'We are excited to announce the launching of A.M.C.\'s Internship Program for students and graduates who are eager to gain practical experience and jumpstart their careers.',
            'image_id' => $m['pic11'],
            'content'  => '<div class="career-subsection">
  <h4 class="career-subtitle">Why Join?</h4>
  <p class="career-intro-text">Our program offers a unique opportunity to:</p>
  <ul class="career-benefits-list">
    <li><i class="fas fa-check-circle"></i><span>Gain Hands-On Experience</span></li>
    <li><i class="fas fa-check-circle"></i><span>Learn from Experts</span></li>
    <li><i class="fas fa-check-circle"></i><span>Build Skills and Networks</span></li>
    <li><i class="fas fa-check-circle"></i><span>Bridge Education with Practice</span></li>
  </ul>
</div>
<div class="career-subsection">
  <h4 class="career-subtitle">Program Highlights</h4>
  <div class="career-highlights-grid">
    <div class="highlight-item">
      <i class="fas fa-calendar-alt"></i>
      <div class="highlight-content">
        <strong>Duration</strong>
        <p>Our 8-week internship program offers flexible schedules to help interns balance work and study.</p>
      </div>
    </div>
    <div class="highlight-item">
      <i class="fas fa-user-friends"></i>
      <div class="highlight-content">
        <strong>Mentorship</strong>
        <p>Each intern is paired with a mentor who will provide guidance, support and feedback throughout the program.</p>
      </div>
    </div>
    <div class="highlight-item">
      <i class="fas fa-chart-line"></i>
      <div class="highlight-content">
        <strong>Professional Development</strong>
        <p>Interns have the opportunity to attend workshops, training sessions, and networking events to enhance their career prospects.</p>
      </div>
    </div>
  </div>
</div>',
        ]);
        $this->insertButton('hp-internship-welcome', '/en/internships', 'Apply for Internship');

        $this->command->info('HomeBmsSeeder completed — 13 media, 15 BMS records, buttons created.');
    }
}
