<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Interview;
use App\Models\JobPost;
use App\Models\Result;
use App\Models\Review;
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
            ['name' => 'TechNova Solutions', 'email' => 'technova@hireverse.test', 'industry' => 'Software Development', 'city' => 'Bengaluru', 'verified' => true],
            ['name' => 'BrightPath Consulting', 'email' => 'brightpath@hireverse.test', 'industry' => 'IT Consulting', 'city' => 'Pune', 'verified' => true],
            ['name' => 'Orbit Digital', 'email' => 'orbitdigital@hireverse.test', 'industry' => 'Digital Marketing & Tech', 'city' => 'Gurugram', 'verified' => true],
            ['name' => 'Northwind Softwares', 'email' => 'northwind@hireverse.test', 'industry' => 'Software & IT Services', 'city' => 'Hyderabad', 'verified' => true],
            ['name' => 'Bluecrest Technologies', 'email' => 'bluecrest@hireverse.test', 'industry' => 'IT Consulting', 'city' => 'Chennai', 'verified' => true],
            ['name' => 'Vantage Creative Studio', 'email' => 'vantage@hireverse.test', 'industry' => 'Design & Branding', 'city' => 'Mumbai', 'verified' => false],
            ['name' => 'PeakSales Group', 'email' => 'peaksales@hireverse.test', 'industry' => 'Sales & Business Development', 'city' => 'Delhi', 'verified' => false],
            ['name' => 'Meridian Finance Partners', 'email' => 'meridian@hireverse.test', 'industry' => 'Finance & Accounting', 'city' => 'Bengaluru', 'verified' => false],
        ];

        $jobTitles = [
            ['title' => 'Laravel Developer', 'category' => 'Engineering', 'type' => 'full_time', 'salary' => 600000, 'exp' => '1-3 Years'],
            ['title' => 'Frontend Developer', 'category' => 'Engineering', 'type' => 'full_time', 'salary' => 550000, 'exp' => '1-2 Years'],
            ['title' => 'Backend Developer', 'category' => 'Engineering', 'type' => 'full_time', 'salary' => 700000, 'exp' => '2-4 Years'],
            ['title' => 'Angular Developer', 'category' => 'Engineering', 'type' => 'part_time', 'salary' => 300000, 'exp' => '1-2 Years'],
            ['title' => 'QA Engineer', 'category' => 'Engineering', 'type' => 'contract', 'salary' => 450000, 'exp' => '0-1 Years'],
            ['title' => 'DevOps Engineer', 'category' => 'Engineering', 'type' => 'full_time', 'salary' => 900000, 'exp' => '3-5 Years'],
            ['title' => 'UI/UX Designer', 'category' => 'Design', 'type' => 'full_time', 'salary' => 500000, 'exp' => '1-3 Years'],
            ['title' => 'Graphic Designer', 'category' => 'Design', 'type' => 'part_time', 'salary' => 350000, 'exp' => 'Fresher'],
            ['title' => 'Sales Force Developer', 'category' => 'Sales', 'type' => 'full_time', 'salary' => 650000, 'exp' => '2-3 Years'],
            ['title' => 'Business Development Executive', 'category' => 'Sales', 'type' => 'full_time', 'salary' => 400000, 'exp' => '0-1 Years'],
            ['title' => 'Digital Marketing Specialist', 'category' => 'Marketing', 'type' => 'full_time', 'salary' => 480000, 'exp' => '1-2 Years'],
            ['title' => 'Content Marketing Executive', 'category' => 'Marketing', 'type' => 'internship', 'salary' => 180000, 'exp' => 'Fresher'],
            ['title' => 'Financial Analyst', 'category' => 'Finance', 'type' => 'full_time', 'salary' => 600000, 'exp' => '1-3 Years'],
            ['title' => 'Accounts Executive', 'category' => 'Finance', 'type' => 'full_time', 'salary' => 350000, 'exp' => '0-1 Years'],
            ['title' => 'HR Executive', 'category' => 'HR', 'type' => 'full_time', 'salary' => 400000, 'exp' => '1-2 Years'],
            ['title' => 'Customer Support Associate', 'category' => 'Customer Support', 'type' => 'full_time', 'salary' => 300000, 'exp' => 'Fresher'],
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
                    'is_verified' => $data['verified'],
                ]
            );

            $companies->push($company);

            // Each company posts 2-3 jobs relevant to its industry, falling back to a random mix
            $relevantJobs = collect($jobTitles)
                ->filter(fn ($job) => str_contains(strtolower($data['industry']), strtolower($job['category'])))
                ->values();

            $jobsForThisCompany = $relevantJobs->count() >= 2
                ? $relevantJobs->take(3)
                : collect($jobTitles)->shuffle()->take(3);

            foreach ($jobsForThisCompany as $job) {
                JobPost::firstOrCreate(
                    ['company_id' => $company->id, 'job_title' => $job['title']],
                    [
                        'category' => $job['category'],
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
        }

        // ---- Candidates ----
        $candidatesData = [
            ['name' => 'Priya Sharma', 'email' => 'priya.sharma@hireverse.test', 'city' => 'Bengaluru', 'skills' => 'Laravel, MySQL, Vue.js'],
            ['name' => 'Rohan Gupta', 'email' => 'rohan.gupta@hireverse.test', 'city' => 'Pune', 'skills' => 'React, JavaScript, CSS'],
            ['name' => 'Ananya Iyer', 'email' => 'ananya.iyer@hireverse.test', 'city' => 'Gurugram', 'skills' => 'Manual Testing, Selenium'],
            ['name' => 'Karan Malhotra', 'email' => 'karan.malhotra@hireverse.test', 'city' => 'Delhi', 'skills' => 'Docker, AWS, CI/CD'],
            ['name' => 'Sneha Reddy', 'email' => 'sneha.reddy@hireverse.test', 'city' => 'Hyderabad', 'skills' => 'Figma, Adobe XD, UI Design'],
            ['name' => 'Arjun Nair', 'email' => 'arjun.nair@hireverse.test', 'city' => 'Chennai', 'skills' => 'Sales, Negotiation, CRM'],
            ['name' => 'Meera Joshi', 'email' => 'meera.joshi@hireverse.test', 'city' => 'Mumbai', 'skills' => 'SEO, Content Writing, Social Media'],
            ['name' => 'Vikram Singh', 'email' => 'vikram.singh@hireverse.test', 'city' => 'Delhi', 'skills' => 'Financial Modelling, Excel, Tally'],
            ['name' => 'Divya Menon', 'email' => 'divya.menon@hireverse.test', 'city' => 'Bengaluru', 'skills' => 'Recruitment, HR Policies, Onboarding'],
            ['name' => 'Aditya Kumar', 'email' => 'aditya.kumar@hireverse.test', 'city' => 'Pune', 'skills' => 'Customer Support, Communication'],
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

        // ---- Applications, Interviews, Results, Reviews ----
        $allJobs = JobPost::all();
        $statuses = ['pending', 'shortlisted', 'selected', 'rejected'];

        foreach ($candidates as $candidate) {
            $jobsToApply = $allJobs->random(min(3, $allJobs->count()));

            foreach ($jobsToApply as $job) {
                $status = $statuses[array_rand($statuses)];

                $application = Application::firstOrCreate(
                    ['candidate_id' => $candidate->id, 'job_post_id' => $job->id],
                    ['applied_date' => now()->subDays(rand(1, 15)), 'status' => $status]
                );

                if (in_array($status, ['shortlisted', 'selected', 'rejected'])) {
                    $interview = Interview::firstOrCreate(
                        ['application_id' => $application->id],
                        [
                            'interview_date' => now()->addDays(rand(-5, 7)),
                            'interview_time' => '11:00:00',
                            'mode' => collect(['online', 'offline'])->random(),
                            'meeting_link' => 'https://meet.google.com/demo-link',
                        ]
                    );

                    if ($status === 'selected') {
                        Result::firstOrCreate(
                            ['interview_id' => $interview->id],
                            ['score' => rand(70, 95), 'remarks' => 'Strong technical fundamentals and good communication.', 'status' => 'pass']
                        );
                    } elseif ($status === 'rejected') {
                        Result::firstOrCreate(
                            ['interview_id' => $interview->id],
                            ['score' => rand(30, 55), 'remarks' => 'Needs more experience for this role.', 'status' => 'fail']
                        );
                    }

                    // Candidate who had an interview can leave a review for that company
                    Review::firstOrCreate(
                        ['candidate_id' => $candidate->id, 'company_id' => $job->company_id],
                        [
                            'rating' => rand(3, 5),
                            'review' => collect([
                                'Smooth interview process and quick feedback.',
                                'Interviewers were professional and clear about expectations.',
                                'Good experience overall, would apply again.',
                                'Decent process, communication could be a bit faster.',
                            ])->random(),
                        ]
                    );
                }
            }
        }

        $this->command->info('Demo data seeded: 1 admin, ' . $companies->count() . ' companies, ' . $candidates->count() . ' candidates, jobs, applications, interviews, results, reviews.');
    }
}