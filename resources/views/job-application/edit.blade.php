<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant Status') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <form action="{{ route('job-applications.update',['job_application'=>$jobApplication->id,'redirectToList'=>request()->query('redirectToList')]) }}" method="POST" >
            @csrf
            @method('put')

            <!-- Company Details -->
            <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold">Job Application Details</h3>
                <p class="text-gray-600 mb-2 text-sm">Provide the basic information about the Job Application.</p>

                 <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Applicant Name</label>
                    <span>{{ $jobApplication->user->name }}</span>
                </div>

                 <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Job Vacancy</label>
                    <span>{{ $jobApplication->jobVacancy?->title ?? 'N/A' }}</span>
                </div>

                 <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Company</label>
                    <span>{{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}</span>
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">AI Generated Score</label>
                    <span>{{ $jobApplication->aiGeneratedScore ?? 'N/A' }}</span>
                </div>

                 <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">AI Generated Feedback</label>
                    <span>{{ $jobApplication->aiGeneratedFeedback ?? 'N/A' }}</span>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                    <select name="status" id="status" class="{{ $errors->has('status')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                        shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                        <option value="">-- Select Status --</option>
                        <option value="pending" {{ old('status',$jobApplication->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ old('status',$jobApplication->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="accepted" {{ old('status',$jobApplication->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

           </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('job-applications.index') }}" 
                    class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                    Cancel
                </a>

                <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Applicant Status
                </button>
            </div>
        </form>
        </div>
    </div>
</x-app-layout>