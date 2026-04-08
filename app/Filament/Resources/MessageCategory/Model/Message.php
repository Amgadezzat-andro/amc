<?php

namespace App\Filament\Resources\MessageCategory\Model;

use App\Models\Base\BaseTranslationModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class Message extends BaseTranslationModel
{
    use HasFactory;

    protected $table = 'message';
    protected $translationForeignKey = 'parent_id';
    public $translatedAttributes =
    [
        'translation_value'
    ];


    /** @var array */
    public $guarded = ['id'];



    public static function  getCategoryList()
	{
        $categories = MessageCategory::all()->mapWithKeys(function($i) {
            return [$i->id => $i->title];
        });
        return $categories;
	}

    public function category()
	{
		return $this->belongsTo(MessageCategory::class,'category_id','id');
	}



    public static function boot()
    {
        parent::boot();

        $flushGroupCache = function (self $languageLine) {
            $languageLine->flushGroupCache();
        };

        static::saved($flushGroupCache);
        static::deleted($flushGroupCache);
    }

    public static function getTranslationsForGroup(string $locale, string $group): array
    {
        $category_id = null;
        $category = Cache::rememberForever( $group. (new MessageCategory())->getTable(), function () use($group) {
                        return MessageCategory::where("title", $group)->first();
                    });
        if($category)
        {
            $category_id = $category->id;
        }

        if(!$category_id)
        {
            return [];
        }
        $translations = Cache::rememberForever(static::getCacheKey($group, $locale), function () use ($group, $category_id, $locale) {
            return static::query()
                            ->with('translations')
                            ->where('category_id', $category_id)
                            ->whereHas('translations', function ($query) use ($locale) {
                                $query->where('language', $locale);
                            })
                            ->get();

        });

        // Initialize an empty array for the translations
        $lines = [];

        foreach ($translations as $item) {
            $translation = $item->translation_value;

            if ($translation !== null) {
                if ($group === '*') {
                    // Flat array for group '*'
                    $lines[$item->message] = $translation;
                } else {
                    // Nested array for specific groups
                    Arr::set($lines, $item->message, $translation);
                }
            }
        }


        return $lines;


    }

    public static function getCacheKey(string $group, string $locale): string
    {
        return "spatie.translation-loader.{$group}.{$locale}";
    }




    public function flushGroupCache()
    {
        foreach ($this->getLocalesHelper() as $locale) {
            Cache::forget(static::getCacheKey($this->group, $locale));
        }

        Artisan::call('cache:clear');
    }

}
