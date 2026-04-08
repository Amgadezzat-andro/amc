<?php

namespace App\Http\Controllers;

use App\Classes\Utility;
use App\Filament\Resources\Accreditation\Model\Accreditation;
use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\Button\Model\Button;
use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Filament\Resources\News\Model\News;
use App\Filament\Resources\Page\Model\Page;
use App\Filament\Resources\Project\Model\Project;
use App\Filament\Resources\PatientReview\Model\PatientReview;
use App\Filament\Resources\Speciality\Model\Speciality;
use App\Filament\Resources\SpecializedCenter\Model\SpecializedCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    public function home($lng)
    {


        $data["HomePageSlider"] = Cache::rememberForever("home_page_slider" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::HOME_PAGE_SLIDER)
                ->with("bmses.mainImage")
                ->first();
        });
        $data["HomePageEnergyCards"] = Cache::rememberForever("home_page_energy_cards" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::HOME_PAGE_ENERGY_CARDS)
                ->with("bmses.mainImage")
                ->first();
        });


        $data["PoweringAfricaFuture"] = Cache::rememberForever("home_page_powering_africa_future" . (new Bms())->getTable(), function () {
            return Bms::activeWithCategory("powering-africa-future")->with(['mainImage', 'mainVideo'])->first();
        });
        $data["InvestingCleanEnergy"] = Cache::rememberForever("home_page_investing_clean_energy" . (new Bms())->getTable(), function () {
            return Bms::activeWithCategory("investing-clean-energy")->with('mainImage')->first();
        });

        $data["HomePageCounters"] = Cache::rememberForever("home_page_counters" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::HOME_PAGE_COUNTERS)
                ->with("bmses")
                ->first();
        });
        $data["HomePageWhyChooseUs"] = Cache::rememberForever("home_page_why_choose_us" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::WHY_CHOOSE_US_ABOUT_US_HOME_PAGE)
                ->with("bmses")
                ->first();
        });

        $data["latestNews"] = Cache::remember('home_latest_news_3', 300, function () {
            return News::active()->where('is_campaign', true)->with(['mainImage'])->orderByDesc('published_at')->limit(3)->get();
        });
        $data["latestProjects"] = Cache::remember('home_latest_projects_3', 300, function () {
            return Project::active()->with(['mainImage'])->orderBy('weight_order')->orderByDesc('published_at')->limit(3)->get();
        });

        $data["HomePageOurPartners"] = Cache::rememberForever("home_page_our_partners" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::HOME_PAGE_OUR_PARTNERS)
                ->with("bmses.mainImage")
                ->first();
        });

        $data["HomePageNewsLetterImage"] = Cache::rememberForever("home_page_news_letter" . (new Bms())->getTable(), function () {
            return Bms::activeWithCategory("home-page-news-letter")->with('mainImage')->first();
        });

        $data["lng"] = $lng;
        return view('site.home', $data);
    }

    public function aboutUs()
    {
        $data["who_we_are"] = Cache::rememberForever("who_we_are" . (new Bms())->getTable(), function () {
            return Bms::activeWithCategory("who-we-are")->with('mainImage')->first();
        });

        $data["why_choose_us"] = Cache::rememberForever("why_choose_us" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::WHY_CHOOSE_US_ABOUT_US)
                ->with("bmses")
                ->first();
        });
        $data["our_partners"] = Cache::rememberForever("our_partners" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::OUR_PARTNERS_ABOUT_US)
                ->with("bmses")
                ->first();
        });

        $data["ag_energies_team"] = Cache::rememberForever("ag_energies_team" . (new Bms())->getTable(), function () {
            return DropdownList::active()
                ->where("category", DropdownList::AG_ENERGIES_TEAM_ABOUT_US)
                ->with("bmses")
                ->first();
        });



        return view('site.about_us', $data);
    }




    public function changeLanguage(Request $request)
    {
        $currentLocale = app()->getLocale();
        $newLocale = $currentLocale === 'ar' ? 'en' : 'ar';

        $previousUrl = $request->headers->get('referer');

        if ($previousUrl) {
            $urlPath = parse_url($previousUrl, PHP_URL_PATH);
            $pathSegments = explode('/', trim($urlPath, '/'));
            if (isset($pathSegments[0]) && in_array($pathSegments[0], config('app.locales'))) {
                $pathSegments[0] = $newLocale;
            } else {
                return redirect()->route('home');
            }
            $newUrl = '/' . implode('/', $pathSegments);

            $query = parse_url($previousUrl, PHP_URL_QUERY);
            if ($query) {
                parse_str($query, $params);
                $params = Utility::sanitize($params);
                $queryString = http_build_query($params);
                $newUrl = $newUrl . '?' . $queryString;
            }




            return redirect($newUrl);
        }

        return redirect()->route('home', ['locale' => $newLocale]);
    }


    public function search(Request $request)
    {

        $data = [];
        if ($request->method() == "POST") {
            if ($request->ajax()) {
                $dataAjaxRequest = $request->all();
                foreach ($dataAjaxRequest as $key => $requestItem) {
                    if ($key == "query") {
                        $request['search_word'] = $requestItem;
                    } elseif ($key != "_token") {
                        $request['model'] = $key;
                        $request['page'] = $requestItem;
                    }
                }
            }
            $searchData = $request->validate([
                'search_word' => 'required|min:1',
                'model' => 'nullable',
            ]);
            $params = Utility::sanitize($searchData);

            $searchModels = Utility::getSearchModels();
            foreach ($searchModels as $key => $searchModel) {
                if (isset($params['model'])) {
                    if ($params['model'] != $searchModel["pagination_name"]) {
                        continue;
                    }
                }
                $data['searchSections'][$key]["title"] = $searchModel["title"];
                $data['searchSections'][$key]["items"] = $searchModel["model"]::search($params['search_word'])
                    ->query(function ($builder) use ($searchModel) {
                        $builder->active();
                        foreach ($searchModel["extra_search"] as $condation) {
                            if (is_array($condation) && count($condation) === 3) {
                                $builder->where($condation[0], $condation[1], $condation[2]);
                            }
                        }
                    })
                    ->paginate(setting("pagination.search") ?? setting("pagination.default"), $searchModel["pagination_name"]);

                $data['searchSections'][$key]["item_title"] = $searchModel["item_title"];
                $data['searchSections'][$key]["item_brief"] = $searchModel["item_brief"];
                $data['searchSections'][$key]["item_url"] = $searchModel["item_url"];
                $data['searchSections'][$key]["main_item_url"] = $searchModel["main_item_url"];
                $data['searchSections'][$key]["pagination_name"] = $searchModel["pagination_name"];
            }

            $data['searchWord'] = $params['search_word'];
        }

        if ($request->ajax()) {
            return view('site.search_ajax', $data);
        }


        return view('site.search', $data);
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
