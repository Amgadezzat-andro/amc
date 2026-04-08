<?php

namespace App\View\Components\Common;

use App\Filament\Resources\Media\Model\Media;
use App\Jobs\ConvertToWebPJob;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class WebpImage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(

        public $id = null,
        public $mediaObject = null,
        public $imagePath = null,
        public $alternativeImage = null,
        public $pictureClass = "",
        public $imgClass = "",
        public $alt = null,
        public $url = null,
        public $withAnchor = false,
        public $allowWebp= true,
        public $allowWebpTablet = true,
        public $allowWebpMobile = true,
        public $width = null,
        public $height = null,

        public $withIcon=false,
        public $cameraIcon=false,
        public $counter=null,
        public $imageID=null,
        public $overlay=false,
        public $loading="lazy",
        public $fetchpriority="auto", 

    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $data["originalUrl"]=null;
        $data["webpUrl"]=null;
        $data["tabletWebpUrl"]=null;
        $data["mobileWebpUrl"]=null;
        

        $data["withAnchor"] = $this->withAnchor;
        $data["url"] = $this->url;
        $data["pictureClass"] = $this->pictureClass;
        $data["imgClass"] = $this->imgClass;
        $data["alt"] = $this->alt;
        $data["withIcon"] = $this->withIcon;
        $data["cameraIcon"] = $this->cameraIcon;
        $data["counter"] = $this->counter;
        $data["imageID"] = $this->imageID;
        $data["overlay"] = $this->overlay;

        $data["loading"] = $this->loading;
        $data["fetchpriority"] = $this->fetchpriority;

        $media = $this->mediaObject;
        if(!$media && $this->alternativeImage )
        {
            $this->imagePath = $this->alternativeImage;
        }

        if($this->imagePath){

            $data["originalUrl"] = $this->imagePath;
            $data["originalWidht"] = $this->width;
            $data["originalHeight"] = $this->height;

            $extension = pathinfo($this->imagePath, PATHINFO_EXTENSION);
            if($extension != "svg"){
                if(!$this->width && !$this->height){
                    
                    if(file_exists(public_path($this->imagePath)))
                    {
                        list($width, $height) = getimagesize($this->imagePath);
                        $data["originalWidht"] = $width;
                        $data["originalHeight"] = $height;
                    }

                }
                
                $parsedUrl = parse_url($this->imagePath);
                $relativePath = ltrim($parsedUrl['path'], '/');
                $relativePath = preg_replace('#^storage/#', '', $relativePath);
                
                $this->converToWebp($relativePath, "public", $data);
            }

            $data["alt"] = $this->alt;



    
            return view('components.common.webp-image', $data);
        }


    
        if($this->id){
            $media = Media::where("id",$this->id)->first();
        }



        if (!$media) {
            return view('components.common.webp-image', $data);
        }

        $data["originalUrl"] = $media->url;
        $data["originalWidht"] = $media->width;
        $data["originalHeight"] = $media->height;
        
        $data["alt"] = $media->alt?? $this->alt;


        $this->converToWebp($media->path, $media->disk, $data);

        return view('components.common.webp-image', $data);
    }




    private function converToWebp($imagePath, $disk, &$data){


        if($this->allowWebp){

            $fullPath = Storage::disk($disk)->path($imagePath);
            
            if (! file_exists($fullPath)) 
            {
                Log::error("❌ File not found: " . $fullPath);
                return;
            } 
            elseif (! is_readable($fullPath)) 
            {
                Log::error("❌ File not readable: " . $fullPath );
                return;
            } 

            $dirname   = pathinfo($imagePath, PATHINFO_DIRNAME);
            $filename  = pathinfo($imagePath, PATHINFO_FILENAME);

            $dirname = preg_replace('#^storage/#', '', $dirname);

            $pathWithoutExt = $dirname . '/' . $filename;

            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            if($extension == "gif"){
                $convertToExtension = "avif";
            }
            else
            {
                $convertToExtension = "webp";   
            }

            $webpExists= Storage::disk($disk)->exists($pathWithoutExt.".".$convertToExtension);
            if(!$webpExists){
                if($extension == "svg" || $extension == "webp"){ //convert svg not working yet
                    return;
                }
                Log::alert( $disk. ' after disk storage/'.$pathWithoutExt. " not found webp of this image");
                ConvertToWebPJob::dispatch($imagePath,$pathWithoutExt,$disk);
            }

            if($webpExists){

                $desktopWebp= Storage::disk($disk)->exists($pathWithoutExt."-final-final-desktop.".$convertToExtension);
                if($desktopWebp)
                {

                    list($width, $height) = getimagesize(Storage::disk($disk)->path($pathWithoutExt."-final-final-desktop.".$convertToExtension));
                    $data["webpUrl"] = Storage::disk($disk)->url($pathWithoutExt."-final-final-desktop.".$convertToExtension);
                    $data["webpWidht"] = $width;
                    $data["webpHeight"] = $height;
                }
                else
                {

                    list($width, $height) = getimagesize(Storage::disk($disk)->path($pathWithoutExt.".".$convertToExtension));
                    $data["webpUrl"] = Storage::disk($disk)->url($pathWithoutExt.".".$convertToExtension);
                    $data["webpWidht"] = $width;
                    $data["webpHeight"] = $height;
                }

                if($this->allowWebpTablet)
                {
                    if(Storage::disk($disk)->exists($pathWithoutExt."-final-final-991.".$convertToExtension))
                    {
                        list($width, $height) = getimagesize(Storage::disk($disk)->path($pathWithoutExt."-final-final-991.".$convertToExtension));
                        $data["tabletWebpUrl"] = Storage::disk($disk)->url($pathWithoutExt."-final-final-991.".$convertToExtension);
                        $data["tabletWebpWidht"] = $width;
                        $data["tabletWebpHeight"] = $height;
                    }
                }
                

                if($this->allowWebpMobile)
                {
                    if(Storage::disk($disk)->exists($pathWithoutExt."-final-final-767.".$convertToExtension))
                    {

                        list($width, $height) = getimagesize(Storage::disk($disk)->path($pathWithoutExt."-final-final-767.".$convertToExtension));
                        $data["mobileWebpUrl"] = Storage::disk($disk)->url($pathWithoutExt."-final-final-767.".$convertToExtension);
                        $data["mobileWebpWidht"] = $width;
                        $data["mobileWebpHeight"] = $height;
                    }
                }
    
                
            }

        }

    }


    
}
