<?php

namespace App\Models\Base;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class BaseTranslationModel extends BaseModel
{
    use Translatable;


    
    public function getAttribute($key)
    {
        if($key){

            [$attribute, $locale] = $this->getAttributeAndLocale($key);

            if ($this->isTranslationAttribute($attribute)) {
                if ($this->getTranslation($locale) === null) {
                    return $this->getAttributeValue($attribute);
                }
    
                // If the given $attribute has a mutator, we push it to $attributes and then call getAttributeValue
                // on it. This way, we can use Eloquent's checking for Mutation, type casting, and
                // Date fields.
                if ($this->hasGetMutator($attribute)) {
                    $this->attributes[$attribute] = $this->getAttributeOrFallback($locale, $attribute);
    
                    return $this->getAttributeValue($attribute);
                }
    
                return $this->getAttributeOrFallback($locale, $attribute);
            }
    
            return parent::getAttribute($key);
        }
        
    }
    
}
