<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-4">
        <!-- overview cards -->
         <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-500">Active Users</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['activeUsers'] }}</p>
                <p class="text-sm text-gray-500">last 30 days</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-500">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalJobs'] }}</p>
                <p class="text-sm text-gray-500">All time</p> 
            </div>
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-500">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalApplications'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>
        </div>

        <!-- Most applied jobs -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-500">Most Applied Jobs</h3>
           <table class="w-full divide-y divide-gray-200 text-left">
                <thead>
                    <tr>
                        <th class="pb-2 border-b py-2 uppercase text-gray-500">Job Title</th>
                        @if (auth()->user()->role === 'admin')
                        <th class="pb-2 border-b py-2 uppercase text-gray-500">Company</th>
                        @endif
                        <th class="pb-2 border-b py-2 uppercase text-gray-500">Total Applications</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($analytics['mostAppliedJobs'] as $job)
                        <tr>
                            <td class="py-4 border-b">{{ $job->title }}</td>
                            @if (auth()->user()->role === 'admin')
                            <td class="py-4 border-b font-bold text-indigo-600">{{ $job->company->name }}</td>
                            @endif
                            <td class="py-4 border-b font-bold text-indigo-600">{{ $job->totalcount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Conversion Rates -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-500">Conversion Rates</h3>
            <table class="w-full divide-y divide-gray-200 text-left">
                <thead>
                    <tr>
                        <th class="pb-2 border-b py-2 uppercase text-gray-500">Job Title</th>
                        <th class="pb-2 border-b py-2 uppercase text-gray-500">Views</th>
                        <th class="pb-2 border-b py-2 uppercase text-gray-500">Applications</th>
                        <th class="pb-2 border-b py-2 uppercase text-gray-500">Conversion Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($analytics['conversionRates']  as $conversionRate)
                    <tr>
                        <td class="py-4 border-b">{{ $conversionRate->title }}</td>
                        <td class="py-4 border-b font-bold text-indigo-600">{{ $conversionRate->viewCount }}</td>
                        <td class="py-4 border-b font-bold text-indigo-600">{{ $conversionRate->totalcount }}</td>
                        <td class="py-4 border-b font-bold text-indigo-600">{{ $conversionRate->conversionRate }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
