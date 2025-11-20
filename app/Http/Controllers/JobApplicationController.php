<?php

namespace App\Http\Controllers;

use App\Http\Requests\jobApplicationUpdateRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=JobApplication::latest();

        if (auth()->user()->role=='company-owner') {
            $query->whereHas('jobVacancy', function ($q) {
                $q->where('companyId', auth()->user()->company->id);
            });
        }   

        if ($request->input('archived')=='true'){
            $query->onlyTrashed() ;
        }   

        $jobApplications=$query->paginate(10)->onEachSide(1);
        return view('job-application.index',compact('jobApplications'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication=JobApplication::findOrFail($id);
        return view('job-application.show',compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication=JobApplication::findOrFail($id);
        return view('job-application.edit',compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(jobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication=JobApplication::findOrFail($id);
        $jobApplication->update(['status'=>$request->input('status')]);

         if ($request->query('redirectToList')=='false'){
            return redirect()->route('job-applications.show',$id)->with('success','Job application updated successfully');           
        }
        
        return redirect()->route('job-applications.index')
            ->with('success','Job application status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication=JobApplication::findOrFail($id);
        $jobApplication->delete();

        return redirect()->route('job-applications.index')
            ->with('success','Job application deleted successfully.');  
    }

    public function restore(string $id)
    {
        $jobApplication=JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();

        return redirect()->route('job-applications.index',['archived'=>'true'])
            ->with('success','Job application restored successfully.');  
    }       
}
