@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Sidebar - made narrower -->
    <div class="w-full md:w-52 bg-gray-800 md:min-h-screen md:fixed md:left-0 md:top-0 pt-12 shadow-lg transition-all duration-300 z-10">
        <div class="px-4 py-3 border-b border-gray-700">
            <h1 class="text-lg font-bold text-white">Finance Tracker</h1>
        </div>
        <nav>
            <ul class="mt-4">
                <li class="mb-1">
                    <a href="/dashboard/{{$pid}}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
              
                <li class="mb-1">
                    <a href="/manage" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('profiles.*') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Manage Profiles
                    </a>
                </li>
                <li class="mb-1">
                    <a href="/stat" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('profiles.*') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        statics
                    </a>
                </li>

                <li class="mb-1">
                    <a href="/goals" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('profiles.*') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        goals
                    </a>
                </li>
            </ul>
        </nav>
    </div>

<div class="container mx-auto ml-40 p-4">
    <h1 class="text-2xl font-bold mb-6">Financial Goals</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <!-- Savings Amount -->
    <div class="bg-red-50 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow duration-200 mb-6">
        <h3 class="text-base font-medium text-gray-700">Savings Amount</h3>
        <p class="text-2xl font-bold text-black">${{ number_format($savings, 2) }}</p>
        <h3>
            @if ($errors->any())
<div class="text-red-500">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

        </h3>
    </div>
    
    <!-- Goal Creation Form -->
    <div class="bg-white text-black p-4 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Create New Goal</h2>
        <form action="/goals" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm text-black font-medium text-gray-700">Goal Title</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 text-black border border-gray-300 rounded-md" required>
                @error('title')
                    <div class="text-red-600 text-black text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="target_amount" class="block text-sm text-black font-medium text-gray-700">Target Amount ($)</label>
                <input type="number" id="target_amount" name="target_amount" class="w-full text-black px-3 py-2 border border-gray-300 rounded-md" required>
                @error('target_amount')
                    <div class="text-red-600 text-sm text-black mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Create Goal</button>
        </form>
    </div>

    <!-- Existing Goals List -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Your Goals</h2>
        
        @php
            $remainingSavings = $savings; // Track remaining savings
        @endphp
        
        @foreach($goals as $goal)
            @php
                // Calculate how much to allocate to this goal
                $allocatedSavings = min($remainingSavings, $goal->target_amount - $goal->current_amount);
                $remainingSavings -= $allocatedSavings;

                // Update the goal's current amount (for display purposes only)
                $goal->current_amount += $allocatedSavings;

                // Calculate progress percentage
                $progressPercentage = $goal->target_amount > 0 ? ($goal->current_amount / $goal->target_amount) * 100 : 0;
                $progressPercentage = min($progressPercentage, 100); // Cap at 100%
            @endphp
            
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold">{{ $goal->title }}</h3>
                    <span class="text-gray-600">${{ number_format($goal->current_amount, 2) }} of ${{ number_format($goal->target_amount, 2) }}</span>
                </div>
                
                <div class="w-full bg-gray-200 rounded-full h-4 mb-3">
                    <div class="h-4 rounded-full flex items-center justify-end px-2 text-xs font-semibold text-white" 
                         style="width: {{ $progressPercentage }}%; background-color: {{ $progressPercentage >= 100 ? 'green' : 'blue' }};">
                        {{ round($progressPercentage) }}%
                    </div>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">
                        @if($progressPercentage >= 100)
                            Goal achieved!
                        @else
                            ${{ number_format($goal->target_amount - $goal->current_amount, 2) }} more needed
                        @endif
                    </span>

                    <div class="flex justify-between w-1/4">

                    <a href="/deleteGoal/{{ $goal->id}}" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded" > Delete Goal </a>
                    
                    <form action="/submitGoal" method="POST">
                        @csrf
                              <input type="hidden" name="type_id" value="4">
                             <input type="hidden" name="categorie_id" value="7">
                             <input type="hidden" name="profile_id" value="{{ $pid }}">
                             <input type="hidden" name="title" value="{{ $goal->title }}">
                             <input type="hidden" name="amount" value="{{ $goal->target_amount, 2}}">

                             <input type="hidden" name="goal_id" value="{{ $goal->id}}">
                        {{-- <input type="hidden" name="contribution_amount" value="{{ $allocatedSavings }}">
                        <input type="hidden" name="contribution_amount" value="{{ $allocatedSavings }}"> --}}
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                            Allocate Funds
                        </button>
                    </form>
                      </div>

                </div>
            </div>
        @endforeach
        
        @if(count($goals) == 0)
            <div class="bg-gray-100 p-4 rounded-lg text-center">
                <p>You haven't created any goals yet.</p>
            </div>
        @endif
        
        @if($remainingSavings > 0 && count($goals) > 0)
            <div class="bg-yellow-50 p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold">Remaining Savings</h3>
                <p class="text-gray-600">You have ${{ number_format($remainingSavings, 2) }} in savings that is not allocated to any goal.</p>
            </div>
        @endif
    </div>
</div>
@endsection