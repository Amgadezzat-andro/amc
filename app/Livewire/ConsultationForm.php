<?php

namespace App\Livewire;

use App\Filament\Resources\ConsultationWebform\Model\ConsultationWebform;

class ConsultationForm extends BaseForm
{
    public $mainModel = ConsultationWebform::class;

    public $subject = 'Consultation Request Form';
    public $emailList = '';

    public $first_name;
    public $last_name;
    public $company;
    public $position;
    public $email;
    public $phone;
    public $location;
    public $message;
    public $captcha;

    public $mailData = [];

    public $exclude = ['id'];
    public $time = ['created_at'];

    public function setEmailList(): void
    {
        $this->emailList = setting('site.contact_us_email_list') ?: setting('site.management_email');
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:2', 'max:255', 'regex:/^(?:[a-zA-Z ]+|[\p{Arabic} ]+)$/u', 'not_regex:/<[^b][^r][^>]*>/'],
            'last_name' => ['required', 'min:2', 'max:255', 'regex:/^(?:[a-zA-Z ]+|[\p{Arabic} ]+)$/u', 'not_regex:/<[^b][^r][^>]*>/'],
            'company' => ['nullable', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
            'position' => ['required', 'string', 'min:2', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
            'email' => ['required', 'max:255', 'email:filter', 'not_regex:/<[^b][^r][^>]*>/'],
            'phone' => ['required', 'regex:/^\+961(?:\s?\d){7,8}$/', 'not_regex:/<[^b][^r][^>]*>/'],
            'location' => ['required', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
            'message' => ['required', 'min:3', 'max:65535', 'not_regex:/<[^b][^r][^>]*>/'],
            'captcha' => ['nullable'],
        ];
    }

    public function submit()
    {
        parent::submit();
        $this->dispatch('consultation-submitted');
    }

    public function render()
    {
        return view('livewire.consultation-form');
    }
}
