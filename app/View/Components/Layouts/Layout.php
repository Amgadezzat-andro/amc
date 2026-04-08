<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(

        public $seoTitle = null,
        public $seoDescription = null,
        public $seoKeywords = null,
        public $seoAuther = null,
        public $seoImage = null,
        public $seoOGType = null,
        public $seoTwitterType = null,
        public $seoSchema = [],

        public $layoutView="main-inner",
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data["data"]["seoTitle"] = html_entity_decode($this->seoTitle);
        $data["data"]["seoDescription"] = html_entity_decode($this->seoDescription);
        $data["data"]["seoKeywords"] = html_entity_decode($this->seoKeywords);
        $data["data"]["seoAuther"] = html_entity_decode($this->seoAuther);
        $data["data"]["seoImage"] = $this->seoImage;
        $data["data"]["seoOGType"] = $this->seoOGType;
        $data["data"]["seoTwitterType"] = $this->seoTwitterType;
        $data["data"]["seoSchema"] = $this->seoSchema;

        return view('components.layouts.'.$this->layoutView, $data);
    }
}
