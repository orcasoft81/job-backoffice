<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }} {{ request()->input('archived')=='true'?'(Archived)':''}}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
       <x-toast-notification/>
       <div class="flex justify-end items-center space-x-4">
        @if(request()->has('archived') && request()->input('archived')=='true' )
            <a href="{{ route('job-applications.index') }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Active Job Applications
            </a>
        @else
            <a href="{{ route('job-applications.index',['archived'=>'true']) }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Archived Job Applications
            </a>
        @endif
       </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-withe">
            <!-- head -->
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Applicant name</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Position (Job Vacancy)</th>
                    @if (auth()->user()->role=='admin')
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($jobApplications as $jobApplication)
                    <tr class="border-b">
                        <td  class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived')=='true' )
                                <span class="text-gray-500">{{ $jobApplication->user->name }}</span>
                            @else
                                <a class="text-blue-500 haover:text-blue-700 underline" href="{{ route('job-applications.show',$jobApplication->id) }}">{{ $jobApplication->user->name }}</a>
                            @endif
                        </td>
                        <td  class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy?->title ?? 'N/A' }}</td>
                        @if (auth()->user()->role=='admin')
                        <td  class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}</td>
                        @endif
                        <td  class="px-6 py-4 @if ($jobApplication->status=='accepted')
                                text-green-600
                            @elseif($jobApplication->status=='rejected')
                                text-red-600    
                            @else 
                                text-purple-800
                            @endif ">{{ $jobApplication->status }}
                        </td>
                        <td>
                            <div class="flex space-x-4">
                                 @if(request()->input('archived')=='true' )
                                 <!-- Restore -->
                                    <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to archive this job vacancy?')">
                                            🗃️Restore
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('job-applications.edit', $jobApplication->id) }}" 
                                    class="text-blue-500 hover:text-blue-700 mr-4">
                                    ✍️Edit
                                    </a>
                                    <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to archive this job vacancy?')">
                                            🗃️Archive
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                @empty  
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No job vacancies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $jobApplications->links() }}
    </div>
</x-app-layout>
