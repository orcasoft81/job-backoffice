<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$jobVacancy->title }}
        </h2>
    </x-slot>

        <div class="overflow-x-auto p-6">
        <x-toast-notification/>

        <div class="mb-6">
            <a href="{{ route('job-vacancies.index') }}" 
                class="text-blue-500 hover:text-blue-700 underline">
                ↑Back to Job Vacancies  
            </a>
        </div>
       
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
             <!-- CompanyDetails -->
            <div>
                <h3 class="text-lg font-bold">Job Vacancy Information</h3>
                <p><strong>Owner:</strong> {{ $jobVacancy->company->name }}</p>
                <p><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>Salary:</strong> {{ number_format($jobVacancy->salary,2,'.',',') }}</p>
                <p><strong>Description:</strong> {{ $jobVacancy->description }}</p>
            </div>

            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-vacancies.edit', ['job_vacancy'=>$jobVacancy->id,'redirectToList'=>'false']) }}" 
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Edit Job Vacancy
                </a>
                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" 
                    method="POST" onsubmit="return confirm('Are you sure you want to delete this job Vacancy?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Delete Job Vacancy
                    </button>
                </form>
            </div>

            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-vacancies.show',['job_vacancy'=>$jobVacancy->id,'tab'=>'applicants']) }}" 
                            class="px-4 py-2 text-gray-800 text-semibold {{ request('tab')=='applicants' || request('tab')=='' ?'border-b-2 border-blue-500':''}}">Applicants</a>
                    </li>

                </ul>
            </div>
            <div>
                <div id="applicants" class="{{ request('tab')=='applicants'?'block':'hidden' }}">
                    <h3 class="text-lg font-bold">Applicants Content</h3>
                    <!-- ApplicantsList Component -->
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Applicant Name</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Job Title</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Status</th>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobVacancy->jobApplications as $applicant)
                                <tr>
                                    <td class="border px-4 py-2">{{ $applicant->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $applicant->JobVacancy->title }}</td>
                                    <td class="border px-4 py-2">{{ $applicant->status }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('job-applications.show', $applicant->id) }}" class="text-blue-500 hover:underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-2 px-4 text-center">No applications yet.</td>                                    
                                </tr>
                            @endforelse
                        </tbody>        

                    </table>
            </div>
         </div>
        </div>
</x-app-layout>