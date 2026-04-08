<?php

namespace App\Livewire;

use App\Filament\Resources\DropdownList\Model\DropdownList;
use App\Models\CareerApplication;
use Livewire\WithFileUploads;

class CareerApplicationForm extends BaseForm
{
    use WithFileUploads;

    public $mainModel = CareerApplication::class;

    public $subject = 'Career Application Form';
    public $emailList = '';

    public $name;
    public $surname;
    public $email;
    public $phone;
    public $cv;
    public $cover_letter;
    public $position_id;
    public $message;
    public $captcha;

    public $positionList = [];

    public $exclude = ['id'];
    public $time = ['created_at'];
    public $fileAttributs = ['cv', 'cover_letter'];
    public $directoryName = 'career-applications';

    public $relation = [
        'position_id' => [
            'key' => 'Position',
            'relation' => 'position',
            'relationTitle' => 'title',
        ],
    ];

    public function mount(): void
    {
        $careerPositionCategories = [
            DropdownList::Career_Position,
        ];

        $this->positionList = DropdownList::query()
            ->where('status', DropdownList::STATUS_PUBLISHED)
            ->whereIn('category', $careerPositionCategories)
            ->with('translations')
            ->orderBy('weight_order', 'ASC')
            ->orderBy('published_at', 'DESC')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->id => $item->title])
            ->all();
    }

    public function setEmailList(): void
    {
        $this->emailList = setting('site.contact_us_email_list') ?: setting('site.management_email');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:255'],
            'surname' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email:filter', 'max:255'],
            'phone' => ['required', 'regex:/^[\d\s\-\+\(\)]{8,20}$/'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'cover_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'position_id' => ['required', 'exists:dropdown_list,id'],
            'message' => ['nullable', 'max:65535'],
            'captcha' => ['nullable'],
        ];
    }

    public function render()
    {
        return view('livewire.career-application-form');
    }
}
