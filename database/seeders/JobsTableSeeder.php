<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Senior Auditor',
                'location' => 'Beirut, Lebanon',
                'department' => 'Audit & Assurance',
                'experience_level' => 'Senior Level',
                'employment_type' => 'Full-time',
                'posted_at' => '2025-01-15',
                'sort_order' => 10,
            ],
            [
                'title' => 'Tax Advisor',
                'location' => 'Beirut, Lebanon',
                'department' => 'Tax Advisory',
                'experience_level' => 'Mid Level',
                'employment_type' => 'Full-time',
                'posted_at' => '2025-01-12',
                'sort_order' => 20,
            ],
            [
                'title' => 'Financial Consultant',
                'location' => 'Beirut, Lebanon',
                'department' => 'Financial Consultancy',
                'experience_level' => 'Senior Level',
                'employment_type' => 'Full-time',
                'posted_at' => '2025-01-10',
                'sort_order' => 30,
            ],
            [
                'title' => 'Accounting Manager',
                'location' => 'Beirut, Lebanon',
                'department' => 'Accounting & Bookkeeping',
                'experience_level' => 'Manager Level',
                'employment_type' => 'Full-time',
                'posted_at' => '2025-01-08',
                'sort_order' => 40,
            ],
            [
                'title' => 'Junior Accountant',
                'location' => 'Beirut, Lebanon',
                'department' => 'Accounting & Bookkeeping',
                'experience_level' => 'Entry Level',
                'employment_type' => 'Full-time',
                'posted_at' => '2025-01-05',
                'sort_order' => 50,
            ],
            [
                'title' => 'Internal Control Specialist',
                'location' => 'Beirut, Lebanon',
                'department' => 'Internal Control',
                'experience_level' => 'Mid Level',
                'employment_type' => 'Full-time',
                'posted_at' => '2025-01-03',
                'sort_order' => 60,
            ],
        ];

        foreach ($jobs as $job) {
            Job::query()->updateOrCreate(
                [
                    'title' => $job['title'],
                    'location' => $job['location'],
                ],
                array_merge($job, [
                    'status' => Job::STATUS_PUBLISHED,
                ])
            );
        }
    }
}
