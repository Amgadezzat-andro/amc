<?php

namespace App\View\Components\Common;

use App\Filament\Resources\Button\Model\Button;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\View\Component;

class SocialMediaLinks extends Component
{
    /**
     * Create a new component instance.
     */
    public $view;

    public function __construct($view = null)
    {
        $this->view = $view;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data['view'] = $this->view;
        $data["socialMediaLinks"] = Cache::rememberForever("social_media_links" . (new Button())->getTable(), function () {
            return Button::ActiveWithCategory('social-media-links')->reorder("published_at", "ASC")->get();
        });
        return view('components.common.social-media-links', $data);
    }
}
