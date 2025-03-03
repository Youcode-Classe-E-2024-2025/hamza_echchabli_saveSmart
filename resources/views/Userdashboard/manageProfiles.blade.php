@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen ">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-gray-800 md:min-h-screen md:fixed md:left-0 md:top-0 pt-16 shadow-lg transition-all duration-300 z-10">
            <div class="px-6 py-4 border-b border-gray-700">
                <h1 class="text-xl font-bold text-white">Finance Tracker</h1>
            </div>
            <nav>
                <ul class="mt-6">
                    <li class="mb-2">
                        <a href="/dashboard/{{$proId}}" class="flex items-center px-6 py-3 text-white hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                  
                    <li class="mb-2">
                        <a href="" class="flex items-center px-6 py-3 text-white hover:bg-gray-700 {{ request()->routeIs('profiles.*') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Manage Profiles
                        </a>
                    </li>
                    <li class="mb-1">
                        <a href="/dashboard/stat" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('profiles.*') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            statics
                        </a>
                    </li>
        
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="w-full md:ml-64 flex-1 p-4 md:p-6 transition-all duration-300">
            <!-- Profiles Management Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold mb-4 text-gray-800">Manage Profiles</h1>
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                <!-- Create New Profile Form -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6 shadow-sm">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Create New Profile
                    </h2>
                    <form action="/profiles" method="POST" enctype="multipart/form-data">

                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Profile Name</label>
                                <input type="text" name="name" id="name" class="w-full px-3 py-2 text-black border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200" required>
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Profile avatar</label>
                               
                            <input type="file" name="avatar" accept="image/*" class="w-full p-2 mb-4 bg-gray-800 rounded">
    
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Profile
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Profiles List -->
                <div class="bg-white rounded-lg shadow-md p-0 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            User Profiles
                        </h2>
                    </div>
                    
                    @if(isset($profiles) && count($profiles) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>

                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transactions</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($profiles as $profile)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-blue-600 font-bold">{{ substr($profile->name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $profile->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $profile->description ?? 'No description' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                           
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $profile->active ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $profile->active ? 'Inactive' : 'Active' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $profile->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $profile->transactions_count ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    
                                                    
                                                    @if($profile->active)
                                                    <a href="{{ route('profiles.activate', ['id' => $profile->id]) }}" 
                                                       class="text-yellow-600 hover:text-yellow-900" 
                                                       title="Deactivate Profile" 
                                                       onclick="return confirm('Are you sure you want to deactivate this profile?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="{{ route('profiles.deactivate', ['id' => $profile->id]) }}" 
                                                       class="text-green-600 hover:text-green-900" 
                                                       title="Activate Profile" 
                                                       onclick="return confirm('Are you sure you want to activate this profile?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('profiles.archive', ['id' => $profile->id]) }}" 
                                                   class="text-red-600 hover:text-red-900" 
                                                   title="Archive Profile" 
                                                   onclick="return confirm('Are you sure you want to archive this profile? This will also delete all associated transactions and cannot be undone.')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </a>
                                                
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        
                    @else
                        <div class="bg-gray-50 p-6 text-center">
                            <p class="text-gray-500">No profiles found. Create your first profile above.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection