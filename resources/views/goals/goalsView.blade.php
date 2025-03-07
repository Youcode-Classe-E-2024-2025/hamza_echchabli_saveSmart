@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Financial Goals</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <!-- Goal Creation Form -->
    <div class="bg-white text-balck p-4 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Create New Goal</h2>
        <form action="{{ route('goals.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm text-balck font-medium text-gray-700">Goal Title</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 text-balck border border-gray-300 rounded-md" required>
                @error('title')
                    <div class="text-red-600 text-balck text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="target_amount" class="block text-sm  text-balckfont-medium text-gray-700">Target Amount ($)</label>
                <input type="number" id="target_amount" name="target_amount" class="w-full text-balck px-3 py-2 border border-gray-300 rounded-md" required>
                @error('target_amount')
                    <div class="text-red-600 text-sm text-balck mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="w-full text-balck bg-blue-500 text-white py-2 rounded-md">Create Goal</button>
        </form>
    </div>

    <!-- Existing Goals List -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Your Goals</h2>
        {{-- @foreach($goals as $goal)
            <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-lg font-semibold">{{ $goal->title }}</h3>
                <p class="text-gray-600">Target: ${{ number_format($goal->target_amount, 2) }}</p>
                <p class="text-gray-600">Current: ${{ number_format($goal->current_amount, 2) }}</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="h-2 rounded-full" style="width: {{ $goal->current_amount / $goal->target_amount * 100 }}%; background-color: {{ $goal->current_amount >= $goal->target_amount ? 'green' : 'blue' }};"></div>
                </div>
                @if($goal->current_amount >= $goal->target_amount)
                    <p class="text-green-600 font-semibold">Goal Achieved!</p>
                @endif
            </div>
        @endforeach --}}
    </div>
</div>
@endsection
