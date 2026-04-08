<?php

namespace App\View\Components\Common;

use App\Filament\Resources\HeaderImage\Model\HeaderImage as ModelHeaderImage;
use App\Models\Media\Media;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class HeaderImage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(

        public $innerItem = null,
        public $getFromSpacificLink = null,
        public $spacificTitle = null,
        public $spacificBrief = null,
        public $mainTitle = null,
        public $mainImage =null,
        public $view = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data = null;
        $data['view'] = $this->view ?? null;
        $data['mainTitle'] = $this->mainTitle ?? null;
        $data['mainImage'] = $this->mainImage ?? null;

        $lng = Lang::locale();
        if ($this->innerItem) {
            $data['image'] = $this->innerItem->headerImage->translation?->image ?? $this->mainImage;
            $data['brief'] = $this->innerItem->headerImage->header_image_brief ?? $this->spacificBrief ?? '';
            $data['title'] = $this->innerItem->headerImage->title ?? $this->spacificTitle;
            $data['color'] = $this->innerItem->headerImage->header_image_title_color ?? null ;
        }
        $data['image'] = $data['image'] ?? null;
        $data['title'] = $data['title'] ?? null;
        $data['brief'] = $data['brief'] ?? null;


        if (!$data || !$data['image']) {
            $path = $this->getFromSpacificLink ?? strstr(Request::path(), "/");


            $headerImage = ModelHeaderImage::active()->withTranslation('image')->where("path", $path)->first();

            if ($headerImage) {
                $data['image'] = $headerImage->translation?->image;
                $data['title'] = $this->spacificTitle ?? $headerImage->title;
                $data['brief'] = $headerImage->translation?->header_image_brief;
                $data['color'] = $headerImage->header_image_title_color ;

            } else {
                $data['image'] = $this->mainImage ?? Media::where("id", setting("{$lng}.site.default_header_image"))->first();
                if(!$data['title']){
                    $data['title'] = $this->spacificTitle ?? setting("{$lng}.site.default_header_image_title") ?? '';
                }
                if(!$data['brief']){
                    $data['brief'] = setting("{$lng}.site.default_header_image_brief") ?? '';
                }
                $data['color'] = $data['color'] ?? setting("{$lng}.site.default_header_image_title_color");

            }
        }



        return view('components.common.header-image', $data);
    }
}
