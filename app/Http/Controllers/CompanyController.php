<?php

namespace App\Http\Controllers;

use App\Http\Requests\companyCreateRequest;
use App\Http\Requests\companyUpdateRequest;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;




class CompanyController extends Controller
{
    public $industries=[
            'Technology',
            'Finance',
            'Healthcare',
            'Education',
            'Retail',
            'Manufacturing',
            'Hospitality',
            'Transportation',
            'Real Estate',
            'Entertainment'
        ];
    /**
     
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query=Company::latest();

        if ($request->input('archived')=='true'){
            $query->onlyTrashed() ;
        }   
        
        $companies=$query->paginate(10)->onEachSide(1);
        return view('company.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries=$this->industries;
        return view('company.create',compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(companyCreateRequest $request)
    {
        $validated=$request->validated();
        //create owner
        $owner=User::create([
            'name'=>$validated['owner_name'],
            'email'=>$validated['owner_email'],
            'password'=>Hash::make($validated['owner_password']),
            'role'=>'company-owner',
        ]); 

        //return error if owner creation fails
        if (!$owner){
            return redirect()->route('companies.create')->with('error','Failed to create company owner');
        }

        //create company
        Company::create([
            'name'=>$validated['name'],
            'address'=>$validated['address'],
            'industry'=>$validated['industry'],
            'website'=>$validated['website'] ?? null,
            'ownerId'=>$owner->id,
        ]);
        
        return redirect()->route('companies.index')->with('success','Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        if ($id){
            $company=company::findOrFail($id);
        } else {
            $company= company::where('ownerId',auth()->user()->id)->first();
        }
      
      return view('company.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        if ($id){
            $companies=company::findOrFail($id);

        }else{
            $companies=company::where('ownerId',auth()->user()->id)->first();
        }
        $industries=$this->industries;
        return view('company.edit',compact('companies','industries'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(companyUpdateRequest $request, string $id = null)
    {
         $validated=$request->validated();
        if ($id){
            $company=company::findOrFail($id);
        } else {
            $company=company::where('ownerId',auth()->user()->id)->first();
        }
        
       
        $company->update([
            'name'=>$validated['name'],
            'address'=>$validated['address'],
            'industry'=>$validated['industry'],
            'website'=>$validated['website'] ,
        ]); 

        //update owner
        $ownerData=[];
        $ownerData['name']=$validated['owner_name'];
        if (!empty($validated['owner_password'])){
            $ownerData['password']=Hash::make($validated['owner_password']);
        }
        $company->owner->update($ownerData);


        if (auth()->user()->role=='company-owner'){
            return redirect()->route('my-company.show')->with('success','Company updated successfully');
        }
        
        if ($request->query('redirectToList')=='false'){
            return redirect()->route('companies.show',$id)->with('success','Company updated successfully');           
        }

        return redirect()->route('companies.index')->with('success','Company updated successfully');  
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company=company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success','Company deleted successfully');
    }
    public function restore(string $id)
    {
        $company=company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index',['archived'=>'true'])->with('success','Company restored successfully');
    }
}
