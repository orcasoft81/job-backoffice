<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $analytics = $this->adminDashboard();
        } else {
            // Other roles' dashboard logic can be added here
            $analytics =$this->companyOwnerDashboard();
        }   
        return view('dashboard.index', compact(['analytics']));
    }

    private function adminDashboard(){
                //last 30 days active users (job seeker role)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->count();
        //total jobs posted (not Archived)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        //total applications received
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

       

        //Most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalcount')
            ->whereNull('deleted_at')
            ->orderBy('totalcount', 'desc')
            ->limit(5)
            ->get();

            //Convertion Rate calculation
            $conversionRates = JobVacancy::withCount('jobApplications as totalcount')
            ->having('totalcount', '>', 0)
            ->orderByDesc('totalcount')
            ->limit(5)
            ->get()            
            ->map( function  ($job) {
                if ($job->viewCount > 0) {
                    $job->conversionRate = round($job->totalcount/$job->viewCount*100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });

             $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
            ];

            return $analytics;
    }

    private function companyOwnerDashboard(){
        $company=auth()->user()->company;

        // filter active users by applying to jobs of the company in last 30 days
        
        $activeUsers=User::where('last_login_at','>=',now()->subDays(30))
                    ->where('role','job-seeker')
                    ->whereHas('jobApplications', function($query) use ($company){
                        $query->wherein('jobVacancyId',$company->jobVacancies->pluck('id'));
                    })
                    ->count();
        
        $totalJobs=$company->jobVacancies()->whereNull('deleted_at')->count();
        $totalApplications= JobApplication::
                            whereIn('jobVacancyId',$company->jobVacancies->pluck('id'))
                            ->whereNull('deleted_at')
                            ->count();

        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalcount')
                            ->whereIn('id',$company->jobVacancies->pluck('id'))
                            ->whereNull('deleted_at')
                            ->orderBy('totalcount', 'desc')
                            ->limit(5)
                            ->get();
        
        $conversionRates = JobVacancy::withCount('jobApplications as totalcount')
                            ->whereIn('id',$company->jobVacancies->pluck('id'))
                            ->having('totalcount', '>', 0)
                            ->orderByDesc('totalcount')
                            ->limit(5)
                            ->get()            
                            ->map( function  ($job) {
                                if ($job->viewCount > 0) {
                                    $job->conversionRate = round($job->totalcount/$job->viewCount*100, 2);
                                } else {
                                    $job->conversionRate = 0;
                                }
                                return $job;
                            }) ;
                           

       $analytics = [
           'activeUsers' => $activeUsers,
           'totalJobs' => $totalJobs,
           'totalApplications' => $totalApplications,
           'mostAppliedJobs' => $mostAppliedJobs,
           'conversionRates' => $conversionRates,
       ];
       return $analytics;
    }
}
