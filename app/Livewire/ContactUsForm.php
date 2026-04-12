<?php

namespace App\Livewire;

use App\Filament\Resources\ContactUsWebform\Model\ContactUsWebform;

class ContactUsForm extends BaseForm
{
    public $mainModel = ContactUsWebform::class;


    public $subject = "Contact Us Form";
    public $emailList = "";

    public $first_name, $last_name, $company, $position, $location, $email, $phone, $internation_phone_country, $message, $captcha;

    public $mailData = [];

    public $exclude = ["id"];

    public $time = ["created_at"];

    // public $relation =
    // [
    //     'reason_to_contact_id ' =>
    //     [
    //         "key" => "Resoan To Contact",
    //         "relation" => "reasonToContact",
    //         "relationTitle" => "title"
    //     ]

    // ];


    public function mount()
    {
        if (empty($this->internation_phone_country)) {
            $this->internation_phone_country = 'LB';
        }
    }


    public function setEmailList()
    {
        $this->emailList = setting("site.contact_us_email_list");
    }



    public function rules()
    {
        return
            [
                'first_name' => ['required', 'min:3', 'max:255', 'regex:/^(?:[a-zA-Z ]+|[\p{Arabic} ]+)$/u', 'not_regex:/<[^b][^r][^>]*>/'],
                'last_name' => ['required', 'min:3', 'max:255', 'regex:/^(?:[a-zA-Z ]+|[\p{Arabic} ]+)$/u', 'not_regex:/<[^b][^r][^>]*>/'],
                'email' => ['required', 'max:255', 'email:filter', 'not_regex:/<[^b][^r][^>]*>/'],
                'internation_phone_country' => ['nullable', 'string', 'size:2'],
                'phone' => ['required', 'regex:/^\+961(?:\s?\d){7,8}$/', 'not_regex:/<[^b][^r][^>]*>/'],
                'company' => ['nullable', 'string', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
                'position' => ['required', 'string', 'min:2', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
                'location' => ['required', 'string', 'min:2', 'max:255', 'not_regex:/<[^b][^r][^>]*>/'],
                'message' => ['nullable', 'min:3', 'max:65535', 'not_regex:/<[^b][^r][^>]*>/'],
                'captcha' => ['nullable'],
            ];
    }

    public function render()
    {
        return view('livewire.contact-us-form');
    }
}
