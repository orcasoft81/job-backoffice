<?php

namespace App\Http\Controllers;

use App\Http\Requests\jobCategoryCreateRequest;
use App\Http\Requests\jobCategoryUpdateRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=JobCategory::latest();

        if ($request->input('archived')=='true'){
            $query->onlyTrashed() ;
        }   
        
        $categories=$query->paginate(10)->onEachSide(1);
        return view('job-category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(jobCategoryCreateRequest $request)
    {
        $validated=$request->validated();
        JobCategory::create($validated);
        return redirect()->route('job-categories.index')->with('success','Job category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category=JobCategory::findOrFail($id);
        return view('job-category.edit',compact('category'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(jobCategoryUpdateRequest $request, string $id)
    {
        $category=JobCategory::findOrFail($id);
        $validated=$request->validated();
        $category->update($validated);
        return redirect()->route('job-categories.index')->with('success','Job category updated successfully');      
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('job-categories.index')->with('success','Job category deleted successfully');
    }
    public function restore(string $id)
    {
        $category=JobCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('job-categories.index',['archived'=>'true'])->with('success','Job category restored successfully');
    }
}
