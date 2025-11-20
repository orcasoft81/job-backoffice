<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$jobApplication->user->name }} | Applied to {{ $jobApplication->jobVacancy?->title?? 'N/A' }}
        </h2>
    </x-slot>

        <div class="overflow-x-auto p-6">
        <x-toast-notification/>

        <div class="mb-6">
            <a href="{{ route('job-applications.index') }}" 
                class="text-blue-500 hover:text-blue-700 underline">
                ↑Back to Job Applications
            </a>
        </div>
       
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
             <!-- Application Details -->
            <div>
                <h3 class="text-lg font-bold">Application Details</h3>
                <p><strong>Applicant:</strong> {{ $jobApplication->user->name }}</p>
                <p><strong>Job Vacancy:</strong> {{ $jobApplication->jobVacancy?->title ?? 'N/A' }}</p>
                <p><strong>Company:</strong> {{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}</p>
                <p><strong>Status:</strong> <span class="@if ($jobApplication->status=='accepted')
                                text-green-600
                            @elseif($jobApplication->status=='rejected')
                                text-red-600    
                            @else 
                                text-purple-800
                            @endif">{{ $jobApplication->status }}</span></p>
                <p><strong>Resume:</strong> <a href="{{ $jobApplication->resume->fileUrl }}" target="_blank"
                        class="text-blue-500 hover:text-blue-700 underline">{{ $jobApplication->resume->fileUrl }}</a>
                </p>

            </div>

            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-applications.edit', ['job_application'=>$jobApplication->id,'redirectToList'=>'false']) }}" 
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Edit Job Application
                </a>
                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job application?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete Job Application</button>
                </form>
            </div>

            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-applications.show',['job_application'=>$jobApplication->id,'tab'=>'resume']) }}" 
                            class="px-4 py-2 text-gray-800 text-semibold {{ request('tab')=='resume' || request('tab')=='' ?'border-b-2 border-blue-500':''}}">Resume</a>
                    </li>
                    <li>
                        <a href="{{ route('job-applications.show',['job_application'=>$jobApplication->id,'tab'=>'AIfeedback']) }}" 
                            class="px-4 py-2 text-gray-800 text-semibold {{ request('tab')=='AIfeedback' ?'border-b-2 border-blue-500':''}}">AI Feedback</a>
                    </li>

                </ul>
            </div>
            <div>
                <div id="resume" class="{{ request('tab')=='resume' || request('tab')=='' ?'block':'hidden' }}">
                    <h3 class="text-lg font-bold">Resume Content</h3>
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Summary</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Skills</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Experience</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Education</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td class="border px-4 py-2">{{ $jobApplication->resume->summary }}</td>
                                    <td class="border px-4 py-2">{{ $jobApplication->resume->skills }}</td>
                                    <td class="border px-4 py-2">{{ $jobApplication->resume->experience }}</td>
                                    <td class="border px-4 py-2">{{ $jobApplication->resume->education }}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <div id="AIfeedback" class="{{ request('tab')=='AIfeedback'?'block':'hidden' }}">
                    <h3 class="text-lg font-bold">AI Feedback Content</h3>
                    <!-- AIFeedback Component -->
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">AI Score</th>
                                <th class="px-4 py-2 text-left bg-gray-100 ">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td class="border px-4 py-2">{{ $jobApplication->aiGeneratedScore }}</td>
                                    <td class="border px-4 py-2">{{ $jobApplication->aiGeneratedFeedback }}</td>
                                </tr>
                        </tbody>
                    </table>
            </div>
         </div>
        </div>
</x-app-layout>
                             