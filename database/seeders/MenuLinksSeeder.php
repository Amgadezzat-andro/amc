<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuLinksSeeder extends Seeder
{
    private const LANGUAGE = 'en';

    public function run(): void
    {
        $this->ensureMenuCategories();
        $this->rebuildMenus(['main-menu', 'footer-menu']);

        $mainMenu = [
            [
                'title' => 'Home',
                'link' => '/',
                'children' => [],
            ],
            [
                'title' => 'About Us',
                'link' => '/about-us',
                'children' => [
                    ['title' => 'History & Evolution', 'link' => '/about-us#history'],
                    ['title' => 'Purpose & Future', 'link' => '/about-us#purpose'],
                    ['title' => 'Our People', 'link' => '/about-us#people'],
                    ['title' => 'Joint Ventures & Alliances', 'link' => '/about-us#ventures'],
                ],
            ],
            [
                'title' => 'Services',
                'link' => '/services',
                'children' => [
                    ['title' => 'Overview', 'link' => '/services#overview'],
                    ['title' => 'What We Do', 'link' => '/services#what-we-do'],
                    ['title' => 'Industries', 'link' => '/services#overview2'],
                ],
            ],
            [
                'title' => 'Culture',
                'link' => '/culture',
                'children' => [
                    ['title' => 'How We Do', 'link' => '/culture#how-we-do'],
                    ['title' => 'RISE Values', 'link' => '/culture#rise-values'],
                    ['title' => 'Equity Driven Workspace', 'link' => '/culture#equity'],
                ],
            ],
            [
                'title' => 'Careers',
                'link' => '/careers',
                'children' => [
                    ['title' => 'Jobs', 'link' => '/careers#jobs'],
                    ['title' => 'Internships', 'link' => '/internship'],
                ],
            ],
            [
                'title' => 'Contact Us',
                'link' => '/contact-us',
                'children' => [],
            ],
        ];

        $footerMenu = [
            [
                'title' => 'About us',
                'link' => '/about-us',
                'children' => [
                    ['title' => 'Our History & Evolution', 'link' => '/about-us#history'],
                    ['title' => 'Our Purpose & Future', 'link' => '/about-us#purpose'],
                    ['title' => 'Our People', 'link' => '/about-us#people'],
                    ['title' => 'Joint Ventures & Alliances', 'link' => '/about-us#ventures'],
                ],
            ],
            [
                'title' => 'Services',
                'link' => '/services',
                'children' => [
                    ['title' => 'Overview', 'link' => '/services#overview'],
                    ['title' => 'What We Do', 'link' => '/services#what-we-do'],
                    ['title' => 'Industries', 'link' => '/services#overview2'],
                ],
            ],
            [
                'title' => 'Culture',
                'link' => '/culture',
                'children' => [
                    ['title' => 'How We Do', 'link' => '/culture#how-we-do'],
                    ['title' => 'RISE Values', 'link' => '/culture#rise-values'],
                    ['title' => 'Equity Driven Workspace', 'link' => '/culture#equity'],
                ],
            ],
            [
                'title' => 'Careers',
                'link' => '/careers',
                'children' => [
                    ['title' => 'Jobs', 'link' => '/careers#jobs'],
                    ['title' => 'Internships', 'link' => '/internship'],
                ],
            ],
        ];

        $this->seedMenu('main-menu', 'Main Menu', $mainMenu);
        $this->seedMenu('footer-menu', 'Footer Menu', $footerMenu);
    }

    private function ensureMenuCategories(): void
    {
        $items = [
            'main-menu' => 'Main Menu',
            'footer-menu' => 'Footer Menu',
        ];

        foreach ($items as $slug => $title) {
            $existingId = DB::table('dropdown_list')->where('slug', $slug)->value('id');

            if (!$existingId) {
                $existingId = DB::table('dropdown_list')->insertGetId([
                    'slug' => $slug,
                    'status' => 1,
                    'category' => 'Menu Category',
                    'weight_order' => 10,
                    'published_at' => now()->timestamp,
                    'revision' => 1,
                    'changed' => 0,
                    'created_at' => now()->timestamp,
                    'updated_at' => now()->timestamp,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }

            DB::table('dropdown_list_lang')
                ->updateOrInsert(
                    ['parent_id' => $existingId, 'language' => self::LANGUAGE],
                    ['title' => $title]
                );
        }
    }

    private function rebuildMenus(array $categorySlugs): void
    {
        $menuIds = DB::table('menu')
            ->whereIn('category_slug', $categorySlugs)
            ->pluck('id')
            ->all();

        if (empty($menuIds)) {
            return;
        }

        $linkIds = DB::table('menu_link')
            ->whereIn('menu_id', $menuIds)
            ->pluck('id')
            ->all();

        if (!empty($linkIds)) {
            DB::table('menu_link_lang')->whereIn('parent_id', $linkIds)->delete();
            DB::table('menu_link')->whereIn('id', $linkIds)->delete();
        }

        DB::table('menu_lang')->whereIn('parent_id', $menuIds)->delete();
        DB::table('menu')->whereIn('id', $menuIds)->delete();
    }

    private function seedMenu(string $categorySlug, string $title, array $links): void
    {
        $now = now()->timestamp;

        $menuId = DB::table('menu')->insertGetId([
            'category_slug' => $categorySlug,
            'status' => 1,
            'weight_order' => 10,
            'published_at' => $now,
            'revision' => 1,
            'changed' => 0,
            'created_at' => $now,
            'updated_at' => $now,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        DB::table('menu_lang')->insert([
            'parent_id' => $menuId,
            'language' => self::LANGUAGE,
            'title' => $title,
        ]);

        $orderCounter = 1;
        foreach ($links as $index => $item) {
            $parentId = $this->insertMenuLink(
                menuId: $menuId,
                parentId: -1,
                title: $item['title'],
                link: $item['link'],
                order: $orderCounter++,
                weightOrder: $index + 1,
            );

            foreach ($item['children'] as $childIndex => $child) {
                $this->insertMenuLink(
                    menuId: $menuId,
                    parentId: $parentId,
                    title: $child['title'],
                    link: $child['link'],
                    order: $orderCounter++,
                    weightOrder: $childIndex + 1,
                );
            }
        }
    }

    private function insertMenuLink(
        int $menuId,
        int $parentId,
        string $title,
        string $link,
        int $order,
        int $weightOrder
    ): int {
        $now = now()->timestamp;

        $menuLinkId = DB::table('menu_link')->insertGetId([
            'menu_id' => $menuId,
            'self_parent_id' => $parentId,
            'custom_color_class' => '',
            'alwaysVisible' => 0,
            'order' => $order,
            'status' => 1,
            'weight_order' => $weightOrder,
            'published_at' => $now,
            'revision' => 1,
            'changed' => 0,
            'created_at' => $now,
            'updated_at' => $now,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        DB::table('menu_link_lang')->insert([
            'parent_id' => $menuLinkId,
            'language' => self::LANGUAGE,
            'title' => $title,
            'link' => $link,
        ]);

        return $menuLinkId;
    }
}
