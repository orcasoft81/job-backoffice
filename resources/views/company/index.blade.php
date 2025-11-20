<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }} {{ request()->input('archived')=='true'?'(Archived)':''}}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
       <x-toast-notification/>
       <div class="flex justify-end items-center space-x-4">
        @if(request()->has('archived') && request()->input('archived')=='true' )
            <a href="{{ route('companies.index') }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Active Companies
            </a>
        @else
            <a href="{{ route('companies.index',['archived'=>'true']) }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Archived Companies
            </a>
        @endif
            
            
            <a href="{{ route('companies.create') }}" 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Add New Company
            </a>
       </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-withe">
            <!-- head -->
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Address</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Industry</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Website</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($companies as $company)
                    <tr class="border-b">
                        <td  class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived')=='true' )
                                <span class="text-gray-500">{{ $company->name }}</span>
                            @else
                                <a class="text-blue-500 haover:text-blue-700 underline" href="{{ route('companies.show',$company->id) }}">{{ $company->name }}</a>
                            @endif
                        </td>
                        <td  class="px-6 py-4 text-gray-800">{{ $company->address }}</td>
                        <td  class="px-6 py-4 text-gray-800">{{ $company->industry }}</td>
                        <td  class="px-6 py-4 text-gray-800">
                            <a href="{{ $company->website }}" target="_blank" class="text-blue-500 hover:underline">
                                {{ $company->website }}
                            </a>
                        </td>
                        <td>
                            <div class="flex space-x-4">
                                 @if(request()->input('archived')=='true' )
                                 <!-- Restore -->
                                    <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to archive this company?')">
                                            🗃️Restore
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('companies.edit', $company->id) }}" 
                                    class="text-blue-500 hover:text-blue-700 mr-4">
                                    ✍️Edit
                                    </a>
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to archive this company?')">
                                            🗃️Archive
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                @empty  
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $companies->links() }}
    </div>
</x-app-layout>
