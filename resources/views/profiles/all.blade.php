@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-900 text-white">
   
    <h1 class="text-4xl font-bold mb-8">Who's Watching?</h1>

    <!-- Profiles List -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8">
        @if($profiles) 
            @foreach($profiles as $profile)
                <div class="text-center">
                    <a href="/dashboard/{{$profile->id}}" class="block">
                        <img src="{{ $profile->avatar ? asset('storage/' . $profile->avatar) : 'https://www.w3schools.com/w3images/avatar2.png' }}" 
                             alt="{{ $profile->name }}" 
                             class="w-32 h-32 rounded-full border-4 border-gray-600 hover:border-white">
                        <p class="mt-2 text-lg font-semibold">{{ $profile->name }}</p>
                    </a>
                </div>
            @endforeach
        @else
            <div class="text-center col-span-2 md:col-span-4">
                <p class="text-lg text-gray-400">No profiles found. Create a new profile to continue.</p>
                <button onclick="document.getElementById('profileModal').classList.remove('hidden')" class="mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-lg font-semibold rounded-md">
                    Create Profile
                </button>
            </div>
        @endif
    </div>

    <!-- Add Profile Button -->
    <button onclick="document.getElementById('profileModal').classList.remove('hidden')" class="mt-40 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-lg font-semibold rounded-md">
        Add Profile
    </button>

    <!-- Profile Creation Modal -->
    <div id="profileModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-gray-900 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">Create Profile</h2>
            <form action="{{ route('profiles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="name" placeholder="Profile Name" class="w-full p-2 mb-4 bg-gray-800 rounded">
                
                <!-- Avatar Upload -->
                <input type="file" name="avatar" accept="image/*" class="w-full p-2 mb-4 bg-gray-800 rounded">
    
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('profileModal').classList.add('hidden')" class="px-4 py-2 bg-gray-600 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection