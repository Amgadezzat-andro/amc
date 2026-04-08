<?php

namespace App\View\Components\Common;

use App\Filament\Resources\Menu\Model\Menu;
use App\Filament\Resources\MenuLink\Model\MenuLink;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;

class FooterMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $categorySlug,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data = [];

        $category_slug = $this->categorySlug;



        $menu = Cache::remember( $category_slug."_footer_". (new Menu())->getTable(), now()->addMinutes(10), function () use($category_slug) {
            return Menu::active()
                        ->with("translation")
                        ->where("category_slug",$category_slug)
                        ->first();
        });

        if(isset($menu) && $menu)
        {
            $data['menu'] = $menu;
            $data['menuParents'] =  Cache::remember( $category_slug."_footer_". (new MenuLink())->getTable(), now()->addMinutes(10), function () use($menu) {
                                        return MenuLink::active()
                                                    ->where("menu_id",$menu->id)
                                                    ->where("self_parent_id", -1)
                                                    ->with("translation")
                                                    ->with("childs")
                                                    ->get();
                                    });


            return view('components.common.footer-menu', $data);
        }

        return "";


    }
}
