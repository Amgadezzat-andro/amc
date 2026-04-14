<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Bms\Model\Bms;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class WebformsController extends Controller
{
    public function contactUs(): View
    {
        $lng = app()->getLocale();
        $locationTitle = setting("{$lng}.site.location");
        $locationCoordinate = setting('site.location_coordinate');
        $locationUrl = setting('site.location_url');

        $contactInfo = [
            'phone' => setting('site.phone'),
            'fax' => setting('site.fax'),
            'email' => setting('site.management_email'),
            'address' => $locationTitle,
            'business_hours' => setting('site.business_hours'),
            'linkedin_url' => setting('site.linkedin_url'),
            'instagram_url' => setting('site.instagram_url'),
            'facebook_url' => setting('site.facebook_url'),
            'youtube_url' => setting('site.youtube_url'),
            'location_url' => $locationUrl,
        ];

        $mapQuery = $locationCoordinate ?: $locationTitle;

        return view('webforms.contact-form', [
            'contactInfo' => $contactInfo,
            'mapQuery' => $mapQuery,
        ]);
    }

    public function contactUsPost(Request $request): RedirectResponse
    {
        return redirect()->route('contact-us', ['locale' => $request->route('locale')])
            ->with('info', __('The form is submitted via the page. If you see this, please use the Send button and ensure JavaScript is enabled.'));
    }

    public function careers(): View
    {
        $lng = app()->getLocale();
        $data['careersHeader'] = Cache::remember("careers_header_bms_{$lng}", now()->addMinutes(10), function () {
            $header = Bms::activeWithCategory('careers-header')->with(['mainImage', 'frontButtons'])->first();

            // Backward compatibility for existing content using the old category slug.
            return $header ?: Bms::activeWithCategory('home-page-careers')->with(['mainImage', 'frontButtons'])->first();
        });

        $data['jobs'] = Cache::remember('careers_jobs_active_list', now()->addMinutes(5), function () {
            return Job::query()->active()->ordered()->get();
        });

        return view('site.careers', $data);
    }

    public function internship(): View
    {
        $data['internshipHeader'] = Cache::rememberForever('internship_header_bms', function () {
            return Bms::activeWithCategory('internship-header')->with(['mainImage', 'frontButtons'])->first();
        });

        $data['internshipWhyJoin'] = Cache::rememberForever('internship_why_join_bms', function () {
            return Bms::activeWithCategory('internship-why-join-section')->with(['mainImage', 'frontButtons'])->first();
        });

        $data['internshipProgramCards'] = Cache::rememberForever('internship_program_cards_bms', function () {
            return Bms::activeWithCategory('internship-our-program-card')->with(['mainImage', 'frontButtons'])->get();
        });

        return view('site.internship', $data);
    }
}
