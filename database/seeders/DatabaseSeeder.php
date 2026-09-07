<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Interview;
use App\Models\JobPost;
use App\Models\Result;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Admin ----
        $admin = User::firstOrCreate(
            ['email' => 'admin@hireverse.test'],
            ['name' => 'Admin User', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // ---- Companies ----
        $companiesData = [
            ['name' => 'TechNova Solutions', 'email' => 'technova@hireverse.test', 'industry' => 'Software Development', 'city' => 'Bengaluru'],
            ['name' => 'BrightPath Consulting', 'email' => 'brightpath@hireverse.test', 'industry' => 'IT Consulting', 'city' => 'Pune'],
            ['name' => 'Orbit Digital', 'email' => 'orbitdigital@hireverse.test', 'industry' => 'Digital Marketing & Tech', 'city' => 'Gurugram'],
        ];

        $jobTitles = [
            ['title' => 'Laravel Developer', 'type' => 'full_time', 'salary' => 600000, 'exp' => '1-3 Years'],
            ['title' => 'Frontend Developer', 'type' => 'full_time', 'salary' => 550000, 'exp' => '1-2 Years'],
            ['title' => 'QA Engineer', 'type' => 'contract', 'salary' => 450000, 'exp' => '0-1 Years'],
            ['title' => 'DevOps Engineer', 'type' => 'full_time', 'salary' => 900000, 'exp' => '3-5 Years'],
        ];

        $companies = collect();

        foreach ($companiesData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password'), 'role' => 'company']
            );

            $company = Company::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $data['name'],
                    'industry' => $data['industry'],
                    'phone' => '+91 98' . rand(10000000, 99999999),
                    'website' => 'https://' . strtolower(str_replace(' ', '', $data['name'])) . '.com',
                    'address' => $data['city'] . ', India',
                    'about' => "{$data['name']} is a growing company in {$data['industry']}, focused on building great products and a great team culture.",
                ]
            );

            $companies->push($company);

            // Each company posts 2 random jobs
            foreach (array_slice($jobTitles, 0, 2) as $job) {
                JobPost::firstOrCreate(
                    ['company_id' => $company->id, 'job_title' => $job['title']],
                    [
                        'job_description' => "We are looking for a {$job['title']} to join our team at {$data['name']}. You'll work on real products, collaborate closely with the team, and grow your skills.",
                        'job_type' => $job['type'],
                        'experience' => $job['exp'],
                        'salary' => $job['salary'],
                        'location' => $data['city'],
                        'vacancies' => rand(1, 3),
                        'last_date' => now()->addDays(30),
                        'status' => 'open',
                    ]
                );
            }

            shuffle($jobTitles);
        }

        // ---- Candidates ----
        $candidatesData = [
            ['name' => 'Priya Sharma', 'email' => 'priya.sharma@hireverse.test', 'city' => 'Bengaluru', 'skills' => 'Laravel, MySQL, Vue.js'],
            ['name' => 'Rohan Gupta', 'email' => 'rohan.gupta@hireverse.test', 'city' => 'Pune', 'skills' => 'React, JavaScript, CSS'],
            ['name' => 'Ananya Iyer', 'email' => 'ananya.iyer@hireverse.test', 'city' => 'Gurugram', 'skills' => 'Manual Testing, Selenium'],
            ['name' => 'Karan Malhotra', 'email' => 'karan.malhotra@hireverse.test', 'city' => 'Delhi', 'skills' => 'Docker, AWS, CI/CD'],
        ];

        $candidates = collect();

        foreach ($candidatesData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password'), 'role' => 'candidate']
            );

            $candidate = Candidate::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'mobile' => '9' . rand(100000000, 999999999),
                    'city' => $data['city'],
                    'gender' => collect(['male', 'female'])->random(),
                    'qualification' => 'B.Tech in Computer Science',
                    'experience' => rand(1, 4) . ' years',
                    'skills' => $data['skills'],
                ]
            );

            $candidates->push($candidate);
        }

        // ---- Applications, Interviews, Results ----
        $allJobs = JobPost::all();
        $statuses = ['pending', 'shortlisted', 'selected', 'rejected'];

        foreach ($candidates as $candidate) {
            $jobsToApply = $allJobs->random(min(2, $allJobs->count()));

            foreach ($jobsToApply as $job) {
                $status = $statuses[array_rand($statuses)];

                $application = Application::firstOrCreate(
                    ['candidate_id' => $candidate->id, 'job_post_id' => $job->id],
                    ['applied_date' => now()->subDays(rand(1, 10)), 'status' => $status]
                );

                if (in_array($status, ['shortlisted', 'selected'])) {
                    $interview = Interview::firstOrCreate(
                        ['application_id' => $application->id],
                        [
                            'interview_date' => now()->addDays(rand(1, 7)),
                            'interview_time' => '11:00:00',
                            'mode' => 'online',
                            'meeting_link' => 'https://meet.google.com/demo-link',
                        ]
                    );

                    if ($status === 'selected') {
                        Result::firstOrCreate(
                            ['interview_id' => $interview->id],
                            ['score' => rand(70, 95), 'remarks' => 'Strong technical fundamentals and good communication.', 'status' => 'pass']
                        );
                    }
                }
            }
        }

        $this->command->info('Demo data seeded: 1 admin, 3 companies, 4 candidates, jobs, applications, interviews, results.');
    }
}