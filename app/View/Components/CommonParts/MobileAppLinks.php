<?php

namespace App\View\Components\CommonParts;

use App\Filament\Resources\Button\Model\Button;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class MobileAppLinks extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $category = 'mobile-app-links',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $category = $this->category;
        $data["mobileAppButtons"] = Cache::rememberForever( $category."_mobile_app_link_". (new Button())->getTable(), function () use($category) {
                                        return Button::ActiveWithCategory($category)
                                                ->with("translations.mainImage")
                                                ->get();
                                    });

        return view('components.common-parts.mobile_app_links', $data);
    }
}
