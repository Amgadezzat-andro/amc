<?php

namespace App\Traits;

trait AfterSaveFillFilamentForm
{

    protected function afterSave(): void
    {
        /** @var Model|Translatable $record */
        $record = $this->getRecord();

        $recordAttributes = $record->attributesToArray();

        $recordAttributes = $this->mutateTranslatableData($record, $recordAttributes);

        $recordAttributes = $this->mutateFormDataBeforeFill($recordAttributes);

        $this->form->fill($recordAttributes);
        
    }

}

