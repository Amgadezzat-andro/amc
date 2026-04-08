<?php

namespace App\Classes;

use App\Filament\Resources\Accreditation\AccreditationResource;
use App\Filament\Resources\Accreditation\Model\Accreditation;
use App\Filament\Resources\PatientReview\Model\PatientReview;
use App\Filament\Resources\PatientReview\PatientReviewResource;
use App\Filament\Resources\VideoGallery\Model\VideoGallery;
use App\Filament\Resources\VideoGallery\VideoGalleryResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;

class CurrentSiteUtility
{
    // !! VIDEO GALLERY COMMON
    public static function microSiteSelect($modelClass)
    {
        return
            Select::make('microSites')
                ->label(__("Videos"))
                // ->required()
                ->multiple()
                ->relationship('microSites', 'title')
                ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->title}")
                ->native(false)
                ->createOptionModalHeading('Create')
                ->createOptionForm(fn(Form $form) => VideoGalleryResource::form($form))
                ->createOptionUsing(function (array $data) {

                    $optionRecord = VideoGallery::create($data);

                    return $optionRecord->id;

                })
                ->pivotData([
                    'module_class' => $modelClass,
                ])
                ->preload();
    }

    // !! PATIENT REVIEW COMMON
    public static function microSitePatientSelect($modelClass)
    {
        return
            Select::make('microSitesPatient')
                ->label(__("PATIENT REVIEWS"))
                // ->required()
                ->multiple()
                ->relationship('microSitesPatient', 'title')
                ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->title}")
                ->native(false)
                ->createOptionModalHeading('Create')
                ->createOptionForm(fn(Form $form) => PatientReviewResource::form($form))
                ->createOptionUsing(function (array $data) {

                    $optionRecord = PatientReview::create($data);

                    return $optionRecord->id;

                })
                ->pivotData([
                    'module_class' => $modelClass,
                ])
                ->preload();
    }

    // !! Accreditation COMMON
    public static function microSiteAccreditationSelect($modelClass)
    {
        return
            Select::make('microSitesAccreditation')
                ->label(__("Accreditation"))
                // ->required()
                ->multiple()
                ->relationship('microSitesAccreditation', 'title')
                ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->title}")
                ->native(false)
                ->createOptionModalHeading('Create')
                ->createOptionForm(fn(Form $form) => AccreditationResource::form($form))
                ->createOptionUsing(function (array $data) {

                    $optionRecord = Accreditation::create($data);

                    return $optionRecord->id;

                })
                ->pivotData([
                    'module_class' => $modelClass,
                ])
                ->preload();
    }



}
