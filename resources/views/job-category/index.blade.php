<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }} {{ request()->input('archived')=='true'?'(Archived)':''}}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
       <x-toast-notification/>
       <div class="flex justify-end items-center space-x-4">
        @if(request()->has('archived') && request()->input('archived')=='true' )
            <a href="{{ route('job-categories.index') }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Active Categories
            </a>
        @else
            <a href="{{ route('job-categories.index',['archived'=>'true']) }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Archived Categories
            </a>
        @endif
            
            
            <a href="{{ route('job-categories.create') }}" 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Add New Category
            </a>
       </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-withe">
            <!-- head -->
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td  class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                 @if(request()->input('archived')=='true' )
                                 <!-- Restore -->
                                    <form action="{{ route('job-categories.restore', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to archive this category?')">
                                            🗃️Restore
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('job-categories.edit', $category->id) }}" 
                                    class="text-blue-500 hover:text-blue-700 mr-4">
                                    ✍️Edit
                                    </a>
                                    <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to archive this category?')">
                                            🗃️Archive
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                @empty  
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No job categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $categories->links() }}
    </div>
</x-app-layout>
