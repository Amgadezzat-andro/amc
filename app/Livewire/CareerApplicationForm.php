<?php

namespace App\Livewire;

use App\Models\CareerApplication;
use App\Models\Job;
use Livewire\Attributes\On;
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
    public $job_id;
    public $message;
    public $captcha;

    public $jobList = [];
    public $selectedJobTitle;

    public $exclude = ['id'];
    public $time = ['created_at'];
    public $fileAttributs = ['cv', 'cover_letter'];
    public $directoryName = 'career-applications';

    public $relation = [];

    public function mount(): void
    {
        $this->jobList = Job::query()
            ->active()
            ->ordered()
            ->get(['id', 'title'])
            ->mapWithKeys(fn ($item) => [$item->id => $item->title])
            ->all();

        if (!empty($this->jobList)) {
            $this->relation = [
                'job_id' => [
                    'key' => 'Position',
                    'relation' => 'job',
                    'relationTitle' => 'title',
                ],
            ];
        }
    }

    #[On('career-job-selected')]
    public function setSelectedJob($jobId = null, $jobTitle = null): void
    {
        if (!$jobId) {
            return;
        }

        $jobId = (int) $jobId;

        if (!array_key_exists($jobId, $this->jobList)) {
            return;
        }

        $this->job_id = $jobId;
        $this->selectedJobTitle = $jobTitle ?: $this->jobList[$jobId];
        $this->resetErrorBag('job_id');
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
            'phone' => ['required', 'regex:/^\+961(?:\s?\d){7,8}$/'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'cover_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'job_id' => [empty($this->jobList) ? 'nullable' : 'required', 'exists:career_jobs,id'],
            'message' => ['nullable', 'max:65535'],
            'captcha' => ['nullable'],
        ];
    }

    public function render()
    {
        return view('livewire.career-application-form');
    }
}
