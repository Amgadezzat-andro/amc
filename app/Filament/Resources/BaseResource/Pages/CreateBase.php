<?php

namespace App\Filament\Resources\BaseResource\Pages;
;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Resources\Pages\CreateRecord;

class CreateBase extends CreateRecord
{
    use CreateTranslatable;

    protected $listeners = ['refresh'=>'refreshForm'];

    public function refreshForm()
    {
        $this->fillForm();
    }

    public function afterSave()
    {
        $this->refreshForm();
    }
    
}
