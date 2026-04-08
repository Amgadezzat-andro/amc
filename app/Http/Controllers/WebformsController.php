<?php

namespace App\Http\Controllers;

use App\Filament\Resources\Bms\Model\Bms;
use App\Filament\Resources\ContactUsWebform\Model\ContactUsWebform;
use App\Models\NewsletterSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class WebformsController extends Controller
{
    public function contactUs(): View
    {
        $lng = app()->getLocale();
        $locationTitle = setting("{$lng}.site.location") ?: setting('site.location_title');
        $locationCoordinate = setting('site.location_coordinate');
        $locationUrl = setting('site.location_url');

        $contactInfo = [
            'phone' => setting('site.phone'),
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
            'subjectList' => ContactUsWebform::getSubjectList(),
            'contactInfo' => $contactInfo,
            'mapQuery' => $mapQuery,
        ]);
    }

    public function contactUsPost(Request $request): RedirectResponse
    {
        return redirect()->route('contact-us', ['locale' => $request->route('locale')])
            ->with('info', __('The form is submitted via the page. If you see this, please use the Send button and ensure JavaScript is enabled.'));
    }

    public function getAQuote(): View
    {
        return view('webforms.quote-form');
    }

    public function getAQuotePost(Request $request): RedirectResponse
    {
        return redirect()->route('get-a-quote', ['locale' => $request->route('locale')])
            ->with('info', __('The form is submitted via the page. If you see this, please use the Submit button and ensure JavaScript is enabled.'));
    }

    public function newsletterSubscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email:filter', 'max:255'],
        ]);
        $email = $validated['email'];
        $exists = NewsletterSubscription::where('email', $email)->exists();
        if ($exists) {
            return response()->json(['success' => true, 'message' => __('Thank you! You are already subscribed.')]);
        }
        NewsletterSubscription::create([
            'email' => $email,
            'locale' => $request->route('locale'),
        ]);
        return response()->json(['success' => true, 'message' => __('Thank you for subscribing! We\'ll keep you updated.')]);
    }

    public function careers(): View
    {
        $data['careersHeader'] = Cache::rememberForever('careers_header_bms', function () {
            return Bms::activeWithCategory('home-page-careers')->with(['mainImage', 'frontButtons'])->first();
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
