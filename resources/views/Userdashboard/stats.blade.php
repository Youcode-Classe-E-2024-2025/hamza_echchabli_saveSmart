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
                    <a href="/stat" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 {{ request()->routeIs('profiles.*') ? 'bg-gray-700 border-l-4 border-blue-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Statics
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main content area -->
    <div class="bg-white w-11/12 h-fit-content md:w-7/10 rounded-lg md:ml-52 p-6  mx-auto">
        <div class="bg-blue-100 flex-grow md:w-7/10 rounded-lg  ">
        <h1 class="my-4 text-black text-2xl font-bold">Expenses and Incomes by Profile</h1>
        <div class="flex justify-evenly">
            <div class="w-full md:w-1/3">
                <h3 class="text-center text-black">Expenses</h3>
                <canvas id="expensesChart"></canvas>
            </div>
            <div class="w-full md:w-1/3">
                <h3 class="text-center text-black">Incomes</h3>
                <canvas id="incomesChart"></canvas>
            </div> 
        </div>

    </div>

    </div>
    
    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const profiles = @json($profiles->pluck('name'));
    const expensesData = @json(array_values($expensesData));
    const incomesData = @json(array_values($incomesData));
  

    const generateColors = (count) => {
        const colors = [];
        for (let i = 0; i < count; i++) {
            colors.push(`rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`);
        }
        return colors;
    };

    const profileColors = generateColors(profiles.length);

    // Expenses Chart
    const expensesCtx = document.getElementById('expensesChart').getContext('2d');
    new Chart(expensesCtx, {
        type: 'doughnut',
        data: {
            labels: profiles,
            datasets: [{
                label: 'Expenses',
                data: expensesData,
                backgroundColor: profileColors,
                borderColor: profileColors.map(color => color.replace('0.6', '1')),
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.label}: $${context.raw}`;
                        }
                    }
                }
            }
        }
    });

    // Incomes Chart
    const incomesCtx = document.getElementById('incomesChart').getContext('2d');
    new Chart(incomesCtx, {
        type: 'doughnut',
        data: {
            labels: profiles,
            datasets: [{
                label: 'Incomes',
                data: incomesData,
                backgroundColor: profileColors,
                borderColor: profileColors.map(color => color.replace('0.6', '1')),
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.label}: $${context.raw}`;
                        }
                    }
                }
            }
        }
    });

    // Balance Chart (Monthly vs Normal Income)
   
});

</script>
@endsection
