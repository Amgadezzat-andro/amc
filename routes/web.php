<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('{locale}')
    ->middleware([
        \App\Http\Middleware\SetLocale::class,
    ])
    ->group(function () {
        Route::controller(\App\Http\Controllers\NewsController::class)
            ->prefix('/news')
            ->group(function () {
                Route::get('/', 'index')->name('news-index');
                Route::get('/{slug}', 'view')->name('news-view');
            });
        Route::controller(\App\Http\Controllers\ProductController::class)
            ->prefix('/products')
            ->group(function () {
                Route::get('/', 'index')->name('products-index');
                Route::get('/{slug}', 'view')->name('products-view');
            });
        Route::controller(\App\Http\Controllers\ProjectController::class)
            ->prefix('/projects')
            ->group(function () {
                Route::get('/', 'index')->name('projects-index');
                Route::get('/{slug}', 'view')->name('projects-view');
            });
        Route::controller(\App\Http\Controllers\EmobilityController::class)
            ->prefix('/emobility')
            ->group(function () {
                Route::get('/', 'index')->name('emobility-index');
                Route::get('/{slug}', 'view')->name('emobility-view');
            });
        Route::get('/swapping-stations', [\App\Http\Controllers\SwappingStationController::class, 'index'])->name('swapping-stations-index');
        Route::controller(\App\Http\Controllers\WebformsController::class)
            ->group(function () {
                Route::get('/contact-us', 'contactUs')->name('contact-us');
                Route::post('/contact-us', 'contactUsPost')->name('contact-us.post');
                Route::get('/get-a-quote', 'getAQuote')->name('get-a-quote');
                Route::post('/get-a-quote', 'getAQuotePost')->name('get-a-quote.post');
                Route::get('/careers', 'careers')->name('careers');
                Route::get('/internship', 'internship')->name('internship');
                Route::post('/newsletter-subscribe', 'newsletterSubscribe')->name('newsletter-subscribe');
            });


        Route::controller(\App\Http\Controllers\SiteController::class)
            ->group(function () {
                Route::get('/', 'home')->name('home');
                Route::get('/change-language', 'changeLanguage')->name('change-language');
                Route::get('/about-us', 'aboutUs')->name('about-us');
                Route::get('/services', 'services')->name('services');
                Route::get('/culture', 'culture')->name('culture');
                Route::get('/{slug}', 'index')->name('page-view');

            });



    });

Route::get('/', function () {
    return redirect()->route('home', ['locale' => 'en']);
});
