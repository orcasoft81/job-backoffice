<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        //Seed the root admin
        User::firstOrCreate ([
            'email' => 'admin@admin.com'
        ],[
            'name' => 'Admin',
            // 'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        //Seed data to test with
        $jobData=json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications=json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // Create Job Categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        // Create Job Companies
        foreach ($jobData['companies'] as $company) {
            //create company owner
            $companyOwner= User::firstOrCreate([
                'email' => $faker->unique()->safeEmail(),
            ],[
                'name' => $faker->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

            Company::firstOrCreate([
                'name' => $company['name'],
            ],[
                'address' => $company['address'] ,
                'industry' => $company['industry'] ,
                'website' => $company['website'] ,
                'ownerId' => $companyOwner->id,
            ]);
        }

        //Create job Vacancies
        foreach ($jobData['jobVacancies'] as $job) {
            //Get the created company by name
            $company= Company::where('name', $job['company'])->firstOrFail();

            $jobCategory= JobCategory::where('name', $job['category'])->firstOrFail();

            JobVacancy::firstOrCreate([
                'title' => $job['title'],
                'companyId' => $company->id,

            ],[
                'description' => $job['description'] ,
                'location' => $job['location'],
                'type' => $job['type'],
                'salary' => $job['salary'] ,
                'jobCategoryId' => $jobCategory->id,
                
            ]);
        }

        // create data to test with
        foreach ($jobApplications['jobApplications'] as $application) {
            // Get ramdom job vacancy
            $jobVacancy= JobVacancy::inRandomOrder()->first();

            // Create applicant user
            $applicant= User::firstOrCreate([
                'email' => $faker->unique()->safeEmail(),
            ],[
                'name' => $faker->name(),
                'password' => Hash::make('12345678'),
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);

            // Create Resume
            $resume=Resume::create([
                'userId' => $applicant->id,
                'fileName' => $application['resume']['filename'],
                'fileUrl' => $application['resume']['fileUri'],
                'contactDetails' => $application['resume']['contactDetails'],
                'summary' => $application['resume']['summary'],
                'skills' => $application['resume']['skills'],
                'experience' => $application['resume']['experience'],
                'education' => $application['resume']['education'],
            ]);


            JobApplication::create([
                'jobVacancyId' => $jobVacancy->id,
                'userId' => $applicant->id,
                'resumeId' => $resume->id,
                'status' => $application['status'] ,
                'aiGeneratedScore' => $application['aiGeneratedScore'] ,
                'aiGeneratedFeedback' => $application['aiGeneratedFeedback'] ,
            ]);
        }
        

    }
}
