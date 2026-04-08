<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\Button\Model\Button;
use App\Filament\Resources\Page\Model\Page;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    public function home($lng)
    {
        $data["slider"] = Cache::rememberForever("home_slider_bms", function () {
            return Bms::activeWithCategory("home-page-slider")->with(['mainImage', 'frontButtons'])->get();
        });

        $data["aboutUs"] = Cache::rememberForever("home_about_us_bms", function () {
            return Bms::activeWithCategory("home-page-about-us")->with(['mainImage', 'frontButtons'])->get();
        });

        $data["servicesOverview"] = Cache::rememberForever("home_services_overview_bms", function () {
            return Bms::activeWithCategory("home-page-services-overview")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["servicesCore"] = Cache::rememberForever("home_services_core_bms", function () {
            return Bms::activeWithCategory("home-page-services-core")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["servicesIndustries"] = Cache::rememberForever("home_services_industries_bms", function () {
            return Bms::activeWithCategory("home-page-services-industries")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["cultureHowWeDo"] = Cache::rememberForever("home_culture_how_we_do_bms", function () {
            return Bms::activeWithCategory("home-page-culture-how-we-do")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["cultureRiseValues"] = Cache::rememberForever("home_culture_rise_values_bms", function () {
            return Bms::activeWithCategory("home-page-culture-rise-values")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["cultureEquityDriven"] = Cache::rememberForever("home_culture_equity_driven_bms", function () {
            return Bms::activeWithCategory("home-page-culture-equity-drivin")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["careers"] = Cache::rememberForever("home_careers_bms", function () {
            return Bms::activeWithCategory("home-page-careers")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["internship"] = Cache::rememberForever("home_internship_bms", function () {
            return Bms::activeWithCategory("home-page-our-internship-program")->with(['mainImage', 'frontButtons'])->first();
        });

        $data["lng"] = $lng;
        return view('site.home', $data);
    }

    public function aboutUs()
    {
        $data["aboutHeader"] = Cache::rememberForever("about_us_header_section_bms", function () {
            return Bms::activeWithCategory("about-us-header-section")
                ->with(['mainImage', 'frontButtons'])
                ->first();
        });

        $data["aboutHistory"] = Cache::rememberForever("about_us_history_and_evolution_bms", function () {
            return Bms::activeWithCategory("about-us-history-and-evolution")
                ->with(['mainImage', 'frontButtons'])
                ->first();
        });

        $data["aboutPurpose"] = Cache::rememberForever("about_us_propose_and_future_bms", function () {
            return Bms::activeWithCategory("about-us-propose-and-future")
                ->with(['mainImage', 'frontButtons'])
                ->first();
        });

        $data["aboutPeopleItems"] = Cache::rememberForever("about_us_our_people_bms", function () {
            return Bms::activeWithCategory("about-us-our-people")
                ->with(['mainImage', 'frontButtons'])
                ->get();
        });

        $data["aboutPartners"] = Cache::rememberForever("about_us_partner_bms", function () {
            return Bms::activeWithCategory("about-use-partner")
                ->with(['mainImage', 'frontButtons'])
                ->first();
        });

        $data["aboutJointVentures"] = Cache::rememberForever("about_us_joint_ventures_bms_v2", function () {
            return Bms::activeWithCategory("about-use-joint-ventures")
                ->with(['mainImage', 'frontButtons'])
            ->get();
        });


        return view('site.about_us', $data);
    }

    public function services()
    {
        $data['servicesHeader'] = Cache::rememberForever('services_header_bms', function () {
            return Bms::activeWithCategory('services-overview')->with(['mainImage', 'frontButtons'])->first();
        });

        $data['servicesIndustries'] = Cache::rememberForever('services_industries_bms', function () {
            return Bms::activeWithCategory('services-industries')->with(['mainImage', 'frontButtons'])->first();
        });

        $data['serviceTabs'] = [
            'company-setup' => Cache::rememberForever('services_tab_company_setup_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-company-setup')->with(['mainImage', 'frontButtons'])->first();
            }),
            'audit' => Cache::rememberForever('services_tab_audit_assurance_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-audit-and-assurance')->with(['mainImage', 'frontButtons'])->first();
            }),
            'accounting' => Cache::rememberForever('services_tab_accounting_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-accounting-and-bookkeeping')->with(['mainImage', 'frontButtons'])->first();
            }),
            'payroll' => Cache::rememberForever('services_tab_payroll_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-payroll')->with(['mainImage', 'frontButtons'])->first();
            }),
            'tax' => Cache::rememberForever('services_tab_tax_advisory_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-tax-advisory')->with(['mainImage', 'frontButtons'])->first();
            }),
            'internal-control' => Cache::rememberForever('services_tab_internal_control_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-internal-control-assessment')->with(['mainImage', 'frontButtons'])->first();
            }),
            'ma' => Cache::rememberForever('services_tab_mergers_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-mergers')->with(['mainImage', 'frontButtons'])->first();
            }),
            'human-capital' => Cache::rememberForever('services_tab_human_capital_bms', function () {
                return Bms::activeWithCategory('services-what-we-do-human-capital')->with(['mainImage', 'frontButtons'])->first();
            }),
        ];

        $data['servicesConnectBanner'] = Cache::rememberForever('services_connect_banner_bms', function () {
            return Bms::activeWithCategory('services-connect-us-banner')->with(['mainImage', 'frontButtons'])->first();
        });

        return view('site.services', $data);
    }

    public function culture()
    {
        $data['cultureHeader'] = Cache::rememberForever('culture_header_bms', function () {
            return Bms::activeWithCategory('culture-header')->with(['mainImage', 'frontButtons'])->first();
        });

        $data['cultureFeatureCards'] = Cache::rememberForever('culture_feature_card_bms', function () {
            return Bms::activeWithCategory('culture-feature-card')->with(['mainImage', 'frontButtons'])->get();
        });

        $data['cultureRiseValues'] = [
            'respect' => Cache::rememberForever('culture_core_value_respect_bms', function () {
                return Bms::activeWithCategory('culture-core-value-respect')->with(['mainImage', 'frontButtons'])->first();
            }),
            'integrity' => Cache::rememberForever('culture_core_value_integrity_bms', function () {
                return Bms::activeWithCategory('culture-core-value-integrity')->with(['mainImage', 'frontButtons'])->first();
            }),
            'skills' => Cache::rememberForever('culture_core_value_skills_bms', function () {
                return Bms::activeWithCategory('culture-core-value-skills')->with(['mainImage', 'frontButtons'])->first();
            }),
            'equality' => Cache::rememberForever('culture_core_value_equality_bms', function () {
                return Bms::activeWithCategory('culture-core-value-Equaility')->with(['mainImage', 'frontButtons'])->first();
            }),
        ];

        $equityItems = Cache::rememberForever('culture_equity_driven_card_bms', function () {
            return Bms::activeWithCategory('culture-equity-driven-card')->with(['mainImage', 'frontButtons'])->get();
        });

        $data['cultureEquityIntro'] = $equityItems->first();
        $data['cultureEquityCards'] = $equityItems->skip(1)->values();

        return view('site.culture', $data);
    }






    public function index($locale, $slug)
    {

        $data['taregtPage'] = Cache::rememberForever($slug . "_page_" . (new Page())->getTable(), function () use ($slug) {
            return Page::onlyActive()
                ->where('slug', $slug)
                ->with("firstSections")
                ->first();
        });

        if (isset($data['taregtPage'])) {
            $targetPageSlug = $data['taregtPage']->slug;
            $data["buttons"] = Cache::rememberForever("pages_button" . $targetPageSlug . (new Button())->getTable(), function () use ($targetPageSlug) {
                return Button::ActiveWithCategory($targetPageSlug)->get();
            });
            return view('site.' . $data['taregtPage']->view, $data);
        }

        abort(404);
    }
}
