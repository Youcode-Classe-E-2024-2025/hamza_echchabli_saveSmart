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
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="w-full md:ml-64 flex-1 p-4 md:p-6 transition-all duration-300">
            <!-- Balance Summary Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold mb-4 text-gray-800">Financial Dashboard</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4 text-center shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h3 class="text-lg font-medium text-gray-700">Total Balance</h3>
                        <p class="text-3xl font-bold {{ $totalBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format(abs($totalBalance), 2) }}
                            <span class="text-sm font-normal">{{ $totalBalance >= 0 ? 'positive' : 'negative' }}</span>
                        </p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h3 class="text-lg font-medium text-gray-700">Total Income</h3>
                        <p class="text-3xl font-bold text-green-600">${{ number_format($totalIncome, 2) }}</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 text-center shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h3 class="text-lg font-medium text-gray-700">Total Expenses</h3>
                        <p class="text-3xl font-bold text-red-600">${{ number_format($totalExpenses, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Forms and Lists Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <!-- Category Form -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Create New Category
                        </h2>
                        <div class="expense_form_container">
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Category Title</label>
                                    <input type="text" name="title" id="title" class="w-full px-3 py-2 text-black border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200" required>
                                </div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create Category
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories List -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Your Categories
                        </h2>
                        @if(isset($categories) && count($categories) > 0)
                            <div class="overflow-hidden overflow-y-auto max-h-64 rounded-md border border-gray-200">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($categories as $category)
                                        <li class="py-3 px-4 flex text-black justify-between items-center hover:bg-gray-50">
                                            <span class="font-medium">{{ $category->title }}</span>
                                            <div class="flex space-x-2">
                                                {{-- <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a> --}}
                                                {{-- Uncomment to enable delete functionality
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                --}}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-md p-4 text-center">
                                <p class="text-gray-500">No categories found. Create your first category above.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Transaction Form -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Transaction
                        </h2>
                        <div class="expense_form_container">
                            <form action="/dashboard/Transaction" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="expense_title" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                                    <input type="text" name="title" id="expense_title" class="w-full px-3 text-black py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-200">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount" class="w-full px-3 py-2 border text-black border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-200" required>
                                </div>
                    
                                <div class="mb-4">
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Transaction Type</label>
                                    <select name="type" id="type" class="w-full px-3 py-2 border text-black border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-200" required>
                                        <option value="expense">Expense</option>
                                        <option value="revenue">Revenue</option>
                                    </select>
                                </div>
                    
                                <div class="mb-4">
                                    <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="categorie_id" id="categorie_id" class="w-full px-3 py-2 border text-black border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300 transition duration-200" required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Transaction
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Transactions List -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Recent Transactions
                        </h2>
                        @if(isset($transactions) && count($transactions) > 0)
                            <div class="overflow-hidden overflow-y-auto max-h-96 rounded-md border border-gray-200">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($transactions as $transaction)
                                        <li class="py-3 px-4 flex justify-between items-center hover:bg-gray-50">
                                            <div>
                                                <p class="font-medium text-black">{{ $transaction->title ?: 'Untitled Transaction' }}</p>
                                                <div class="flex flex-wrap gap-2 mt-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $transaction->categorie->title }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                        {{ $transaction->profile->name }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <span class="font-bold {{ $transaction->type === 'expense' ? 'text-red-500' : 'text-green-500' }}">
                                                    {{ $transaction->type === 'expense' ? '-' : '+' }} ${{ number_format($transaction->amount, 2) }}
                                                </span>
                                                <div class="flex space-x-1">
                                                   
                                                    {{-- Uncomment to enable delete functionality
                                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    --}}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-md p-4 text-center">
                                <p class="text-gray-500">No transactions found. Add your first transaction above.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

