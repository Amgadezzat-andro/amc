<?php

namespace App\Livewire;

use App\Models\InternshipApplication;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class InternshipApplicationForm extends BaseForm
{
    use WithFileUploads;

    public $mainModel = InternshipApplication::class;

    public $subject = 'Internship Application Form';
    public $emailList = '';

    public $name;
    public $surname;
    public $email;
    public $phone;
    public $date_of_birth;
    public $address;
    public $university;
    public $major;
    public $level_of_studies;
    public $date_of_availability;
    public $cv;
    public $cover_letter;
    public $message;
    public $captcha;

    public array $levelOptions = ['BA', 'Masters', 'MBA'];

    public $exclude = ['id'];
    public $time = ['created_at'];
    public $fileAttributs = ['cv', 'cover_letter'];
    public $directoryName = 'internship-applications';

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
            'phone' => ['required', 'regex:/^\+961(?:\s?\d){7,8}$/'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:255'],
            'university' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'level_of_studies' => ['required', 'in:BA,Masters,MBA'],
            'date_of_availability' => ['nullable', 'date'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'cover_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'message' => ['nullable', 'max:65535'],
            'captcha' => ['nullable'],
        ];
    }

    public function uploadFilesIfExists($item): void
    {
        foreach (['cv', 'cover_letter'] as $attributeName) {
            if (!empty($this->$attributeName)) {
                $filename = Str::random(6) . '_' . time() . '_' . $this->$attributeName->getClientOriginalName();
                $path = $this->$attributeName->storeAs($this->directoryName, $filename, 'public');
                $this->$attributeName = $path;
            } else {
                $this->$attributeName = null;
            }
        }
    }

    public function render()
    {
        return view('livewire.internship-application-form');
    }
}
