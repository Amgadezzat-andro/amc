<?php

namespace App\View\Components\Common;

use App\Filament\Resources\Menu\Model\Menu;
use App\Filament\Resources\MenuLink\Model\MenuLink;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;

class GeneralMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(

    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data = [];


        $menu = Cache::remember( "general_". (new Menu())->getTable(), now()->addMinutes(10), function () {
            return Menu::active()
                        ->with("translation")
                        ->where("category_slug","mega-menu")
                        ->first();
        });

        // var_dump($menu);
        // die;
        if(isset($menu) && $menu)
        {
            $data['menuParents'] =  Cache::remember( "general_". (new MenuLink())->getTable(), now()->addMinutes(10), function () use($menu) {
                                        return MenuLink::active()
                                                    ->where("menu_id",$menu->id)
                                                    ->where("self_parent_id", -1)
                                                    ->with("translation")
                                                    ->with("childs")
                                                    ->get();
                                    });


            return view('components.common.general-menu', $data);
        }

        return "";


    }
}
