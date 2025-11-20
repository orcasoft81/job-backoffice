<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$company->name }}
        </h2>
    </x-slot>

        <div class="overflow-x-auto p-6">
        <x-toast-notification/>
        @if (auth()->user()->role == 'admin')
        <div class="mb-6">
            <a href="{{ route('companies.index') }}" 
                class="text-blue-500 hover:text-blue-700 underline">
                ↑Back to Companies   
            </a>
        </div>
        @endif

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
             <!-- CompanyDetails -->
            <div>
                <h3 class="text-lg font-bold">Company Information</h3>
                <p><strong>Owner:</strong> {{ $company->owner->name }}</p>
                <p><strong>Email:</strong> {{ $company->owner->email }}</p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                <p><strong>Website:</strong> <a class="text-blue-500 hover:text-blue-700 underline" href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>
            </div>
            
            <div class="flex justify-end space-x-4 mb-6">
                 @if (auth()->user()->role == 'company-owner')
                <a href="{{ route('my-company.edit')}}" 
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Edit Company
                </a>
                @else
                <a href="{{ route('companies.edit', [$company->id,'redirectToList'=>'false']) }}" 
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Edit Company
                </a>
                @endif
                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete Company</button>
                    </form>
                @endif      
            </div>

           @if (auth()->user()->role == 'admin')
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('companies.show',['company'=>$company->id,'tab'=>'jobs']) }}" 
                            class="px-4 py-2 text-gray-800 text-semibold {{ request('tab')=='jobs' || request('tab')=='' ?'border-b-2 border-blue-500':''}}">Jobs</a>
                    </li>
                    <li>
                        <a href="{{ route('companies.show',['company'=>$company->id,'tab'=>'applicants']) }}" 
                            class="px-4 py-2 text-gray-800 text-semibold {{ request('tab')=='applicants' ?'border-b-2 border-blue-500':''}}">Applicants</a>
                    </li>

                </ul>
            </div>
            <div>
                <div id="jobs" class="{{ request('tab')=='jobs' || request('tab')=='' ?'block':'hidden' }}">
                    <h3 class="text-lg font-bold">Jobs Content</h3>
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Title</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Location</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Type</th>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company->jobVacancies as $job)
                                <tr>
                                    <td class="border px-4 py-2">{{ $job->title }}</td>
                                    <td class="border px-4 py-2">{{ $job->location }}</td>
                                    <td class="border px-4 py-2">{{ $job->type }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-500 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="applicants" class="{{ request('tab')=='applicants'?'block':'hidden' }}">
                    <h3 class="text-lg font-bold">Applicants Content</h3>
                    <!-- ApplicantsList Component -->
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Name</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Job Title</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Status</th>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company->jobApplications as $applicant)
                                <tr>
                                    <td class="border px-4 py-2">{{ $applicant->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $applicant->JobVacancy->title }}</td>
                                    <td class="border px-4 py-2">{{ $applicant->status }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('job-applications.show', $applicant->id) }}" class="text-blue-500 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>        

                    </table>
            </div>
         </div>
         @endif
        </div>
</x-app-layout>