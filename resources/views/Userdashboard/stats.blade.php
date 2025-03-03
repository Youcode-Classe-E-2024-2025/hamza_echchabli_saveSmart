@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Expenses and Incomes by Profile</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Expenses</h3>
            <canvas id="expensesChart"></canvas>
        </div>
        <div class="col-md-6">
            <h3>Incomes</h3>
            <canvas id="incomesChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profiles = @json($profiles->pluck('name'));
        const expensesData = @json(array_values($expensesData));
        const incomesData = @json(array_values($incomesData));

        // Generate random colors for each profile
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
    });
</script>
@endsection