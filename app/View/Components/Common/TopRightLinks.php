<?php

namespace App\View\Components\Common;

use App\Filament\Resources\Button\Model\Button;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\View\Component;

class TopRightLinks extends Component
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
        $data["links"] =    Cache::rememberForever( "top_right_links". (new Button())->getTable(), function () {
                                return Button::ActiveWithCategory('top-right-links')->with("mainImage")->get();
                            });
        return view('components.common.top_right_links', $data);
    }
}
