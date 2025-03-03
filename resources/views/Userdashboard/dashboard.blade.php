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
                        <a href="/dashboard/{{$proId}}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
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
                        <a href="/statics" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('profiles.*') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            statics
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content - adjusted margin to match narrower sidebar -->
        <div class="w-full md:ml-52 flex-1 p-3 transition-all duration-300">
            <!-- Balance Summary Section - made more compact -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <h1 class="text-xl font-bold mb-3 text-gray-800">Financial Dashboard</h1>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="bg-blue-50 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h3 class="text-base font-medium text-gray-700">Total Balance</h3>
                        <p class="text-2xl font-bold {{ $totalBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            ${{ number_format(abs($totalBalance), 2) }}
                            <span class="text-xs font-normal">{{ $totalBalance >= 0 ? 'positive' : 'negative' }}</span>
                        </p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h3 class="text-base font-medium text-gray-700">Total Income</h3>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($totalIncome, 2) }}</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h3 class="text-base font-medium text-gray-700">Total Expenses</h3>
                        <p class="text-2xl font-bold text-red-600">${{ number_format($totalExpenses, 2) }}</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow duration-200">
                        <h3 class="text-base font-medium text-gray-700">Monthly Income</h3>
                        <p class="text-2xl font-bold text-black">${{ number_format($bala, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Forms and Lists Section - reduced gap and padding -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="space-y-4">
                    <!-- Category Form -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h2 class="text-lg font-bold mb-3 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Create New Category
                        </h2>
                        <div class="expense_form_container">
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Category Title</label>
                                    <input type="text" name="title" id="title" class="w-full px-3 py-1.5 text-black border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300 transition duration-200" required>
                                </div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-1.5 px-4 rounded-md transition duration-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create Category
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories List -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h2 class="text-lg font-bold mb-3 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Your Categories
                        </h2>
                        @if(isset($categories) && count($categories) > 0)
                            <div class="overflow-hidden overflow-y-auto max-h-48 rounded-md border border-gray-200">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($categories as $category)
                                        <li class="py-2 px-3 flex text-black justify-between items-center hover:bg-gray-50">
                                            <span class="font-medium">{{ $category->title }}</span>
                                            <div class="flex space-x-2">
                                                {{-- Edit/Delete buttons commented out in original --}}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-md p-3 text-center">
                                <p class="text-gray-500">No categories found. Create your first category above.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Transaction Form -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h2 class="text-lg font-bold mb-3 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Transaction
                        </h2>
                        <div class="expense_form_container">
                            <form action="/dashboard/Transaction" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="expense_title" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                                    <input type="text" name="title" id="expense_title" class="w-full px-3 py-1.5 text-black border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-300 transition duration-200">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount" class="w-full px-3 py-1.5 border text-black border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-300 transition duration-200" required>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Transaction Type</label>
                                    <select name="type" id="type" class="w-full px-3 py-1.5 border text-black border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-300 transition duration-200" required>
                                        <option value="expense">Expense</option>
                                        <option value="revenue">Revenue</option>
                                    </select>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="categorie_id" id="categorie_id" class="w-full px-3 py-1.5 border text-black border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-300 transition duration-200" required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                    
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-1.5 px-4 rounded-md transition duration-200 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Transaction
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Transactions List -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h2 class="text-lg font-bold mb-3 text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Recent Transactions
                        </h2>
                        @if(isset($transactions) && count($transactions) > 0)
                            <div class="overflow-hidden overflow-y-auto max-h-64 rounded-md border border-gray-200">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($transactions as $transaction)
                                    <li class="py-2 px-3 flex justify-between items-center hover:bg-gray-50">
                                        <div>
                                            <p class="font-medium text-black text-sm">{{ $transaction->title ?: 'Untitled Transaction' }}</p>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $transaction->categorie->title }}
                                                </span>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ $transaction->profile->name }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="font-bold text-sm {{ $transaction->type === 'expense' ? 'text-red-500' : 'text-green-500' }}">
                                                {{ $transaction->type === 'expense' ? '-' : '+' }} ${{ number_format($transaction->amount, 2) }}
                                            </span>
                                            <div class="flex space-x-1">
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0)" onclick="openEditModal({{ $transaction->id }})" 
                                                   class="text-blue-600 hover:text-blue-900" title="Edit Transaction">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4h5v5m-5-5L5 14l4 4 10-10M5 14l-4 4" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                                
                        <!-- Modal for Editing Transaction - made more compact -->
                        <div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-800 text-black bg-opacity-50 flex justify-center items-center">
                            <div class="bg-white p-4 rounded-lg w-80">
                                <h2 class="text-lg text-black font-bold mb-3">Edit Transaction</h2>
                                <form id="editForm" action="{{ route('dashboard.update') }}" method="POST">
                                    @csrf
                           
                                    <!-- Hidden input for transaction ID -->
                                    <input type="number" name="id" id="transaction_id" value="" hidden>
                        
                                    <div class="mb-3">
                                        <label for="title" class="block text-black text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" name="title" id="title" class="mt-1 text-black block w-full py-1.5 border border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                        
                                    <div class="mb-3">
                                        <label for="amount" class="block text-black text-sm font-medium text-gray-700">Amount</label>
                                        <input type="number" name="amount" id="amount" class="mt-1 text-black block w-full py-1.5 border border-gray-300 rounded-md shadow-sm" required step="0.01">
                                    </div>
                        
                                    <div class="mb-3">
                                        <label for="type" class="block text-black text-sm font-medium text-gray-700">Type</label>
                                        <select name="type" id="type" class="mt-1 block text-black w-full py-1.5 border border-gray-300 rounded-md shadow-sm" required>
                                            <option value="revenue">Income</option>
                                            <option value="expense">Expense</option>
                                        </select>
                                    </div>
                        
                                    <div class="mb-3">
                                        <label for="categorie_id" class="block text-sm text-black font-medium text-gray-700">Category</label>
                                        <select name="categorie_id" id="categorie_id" class="mt-1 block text-black w-full py-1.5 border border-gray-300 rounded-md shadow-sm" required>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                        
                                    <div class="flex space-x-2">
                                        <button type="submit" class="bg-blue-600 text-white py-1.5 px-3 rounded-md text-sm">Update</button>
                                        <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white py-1.5 px-3 rounded-md text-sm">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <script>
                            // Open the Edit Modal
                            function openEditModal(transactionId) {
                                // Set the hidden input value to the selected transaction ID
                                document.getElementById('transaction_id').value = transactionId;
                        
                                // Show the modal
                                document.getElementById('editModal').classList.remove('hidden');
                            }
                        
                            // Close the Edit Modal
                            function closeEditModal() {
                                document.getElementById('editModal').classList.add('hidden');
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection