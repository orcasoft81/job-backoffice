<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Vacancy') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <form action="{{ route('job-vacancies.update',['job_vacancy'=>$jobVacancy->id,'redirectToList'=>request()->query('redirectToList')]) }}" method="POST" >
            @csrf
            @method('put')

            <!-- Company Details -->
            <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold">Job Vacancy Details</h3>
                <p class="text-gray-600 mb-2 text-sm">Provide the basic information about the Job Vacancy.</p>

                 <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title',$jobVacancy->title) }}"
                        class="{{ $errors->has('title')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                    @error('title')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="location" class="block text-gray-700 font-semibold mb-2">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location',$jobVacancy->location) }}"
                        class="{{ $errors->has('location')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                    @error('location')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="salary" class="block text-gray-700 font-semibold mb-2">Expected Salary (USD)</label>
                    <input type="number" name="salary" id="salary" value="{{ old('salary',$jobVacancy->salary) }}" required
                        class="{{ $errors->has('salary')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                    @error('salary')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-gray-700 font-semibold mb-2">Type {{ $jobVacancy->type }}</label>
                    <select name="type" id="type" class="{{ $errors->has('type')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                        <option value="">-- Select Type --</option>
                        <option value="Full-Time" {{ old('type',$jobVacancy->type) == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                        <option value="Contract" {{ old('type',$jobVacancy->type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                        <option value="Remote" {{ old('type',$jobVacancy->type) == 'Remote' ? 'selected' : '' }}>Remote</option>
                        <option value="Hybrid" {{ old('type',$jobVacancy->type) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('industry')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

    
                <!-- Company select dropdown -->
                <div class="mb-4">
                    <label for="companyId" class="block text-gray-700 font-semibold mb-2">Company</label>
                    <select name="companyId" id="companyId" 
                        class="{{ $errors->has('company_id')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                        <option value="">-- Select Company --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('companyId',$jobVacancy->companyId) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('companyId')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror   
                </div>

                <!-- job category select dropdown -->
                <div class="mb-4">
                    <label for="jobCategoryId" class="block text-gray-700 font-semibold mb-2">Job Category</label>
                    <select name="jobCategoryId" id="jobCategoryId" 
                        class="{{ $errors->has('job_categoryId')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                        <option value="">-- Select Job Category --</option>
                        @foreach($jobCategories as $jobCategory)
                            <option value="{{ $jobCategory->id }}" {{ old('job_categoryId',$jobVacancy->jobCategoryId) == $jobCategory->id ? 'selected' : '' }}>
                                {{ $jobCategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('job_categoryId')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror      
                </div>
                
                <!-- Job Description -->
                 <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-semibold mb-2">Job Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="{{ $errors->has('description')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description',$jobVacancy->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror   
                </div>
            </div>
           
            <div class="flex justify-end space-x-4">
                <a href="{{ route('job-vacancies.index') }}" 
                    class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                    Cancel
                </a>

                <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Job Vacancy
                </button>
            </div>
        </form>
        </div>
    </div>
</x-app-layout>