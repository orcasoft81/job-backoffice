<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Category') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <form action="{{ route('job-categories.store') }}" method="POST" >
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="{{ $errors->has('name')?'outline-red-500':'outline-gray-300' }} outiline outiline-1 mt-1 block w-full rounded-md
                     shadow-sm px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" >
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('job-categories.index') }}" 
                    class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                    Cancel
                </a>

                <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Add Category
                </button>
            </div>
        </form>
        </div>
    </div>
</x-app-layout>