<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('users') }} {{ request()->input('archived')=='true'?'(Archived)':''}}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
       <x-toast-notification/>
       <div class="flex justify-end items-center space-x-4">
        @if(request()->has('archived') && request()->input('archived')=='true' )
            <a href="{{ route('users.index') }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Active Users
            </a>
        @else
            <a href="{{ route('users.index',['archived'=>'true']) }}" 
                class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Archived Users
            </a>
        @endif
       </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-withe">
            <!-- head -->
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Role</th>
                    <th class="px-6 py-3 text-left text-sm fonr-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td  class="px-6 py-4 text-gray-800">
                            <span class="text-gray-500">{{ $user->name }}</span>
                        </td>
                        <td  class="px-6 py-4 text-gray-800">{{ $user->email }}</td>
                        <td  class="px-6 py-4 text-gray-800">{{ $user->role }}</td>
                        <td>
                            <div class="flex space-x-4">
                                 @if(request()->input('archived')=='true' )
                                 <!-- Restore -->
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to restore this User?')">
                                            🗃️Restore
                                        </button>
                                    </form>
                                @else
                                <!-- if admin don't allow edit or delete-->
                                 @if ( $user->role != 'admin')
                                     
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                    class="text-blue-500 hover:text-blue-700 mr-4">
                                    ✍️Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900" 
                                            onclick="return confirm('Are you sure you want to archive this user?')">
                                            🗃️Archive
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                @empty  
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->links() }}
    </div>
</x-app-layout>
