<?php

namespace App\Console\Commands;

use App\Filament\Resources\News\Model\News;
use App\Filament\Resources\Page\Model\Page;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml';

    public function handle()
    {
        //$locales = config('app.locales');
        $locales = ['en'];

        $sitemap = Sitemap::create();

        foreach ($locales as $locale) {

            // Home
            $sitemap->add(
                Url::create(url("/$locale"))
                    ->setPriority(1.0)
            );

            // news
            News::active()
                ->chunk(1000, function ($items) use ($sitemap, $locale) {
                    foreach ($items as $item) {
                        $sitemap->add(
                            Url::create(url("/$locale/news/{$item->slug}"))
                                ->setLastModificationDate($item->updated_at)
                                ->setPriority(0.8)
                        );
                    }
                });

            // Pages
            Page::active()
                ->chunk(1000, function ($items) use ($sitemap, $locale) {
                    foreach ($items as $item) {
                        $sitemap->add(
                            Url::create(url("/$locale/{$item->slug}"))
                        );
                    }
                });



            // Static pages
            $staticRoutes = [
                'news',
                'the-firm',
                'careers',
                'internship',
                'contact-us',
            ];

            foreach ($staticRoutes as $route) {
                $sitemap->add(
                    Url::create(url("/$locale/$route"))
                        ->setPriority(0.7)
                );
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}