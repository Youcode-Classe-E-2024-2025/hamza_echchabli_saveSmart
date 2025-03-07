@include('partials.header')
<body class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col md:flex-row justify-center items-center px-4">

        <!-- Left Section - Login/Register -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center md:items-start space-y-8 p-8">
            <h1 class="text-5xl font-extrabold leading-tight mb-4">Welcome to SaveSmart</h1>
            <p class="text-2xl mb-6 max-w-3xl">Your Ultimate Personal Finance Management Tool. Easily track, save, and grow your finances with a simple and intuitive platform.</p>
            <div class="flex space-x-6">
                <a href="/login" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">Login</a>
                <a href="/register" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">Sign Up</a>
            </div>
        </div>

        <!-- Right Section - Money Image -->
        <div class="w-full md:w-1/2 flex justify-center items-center p-8">
            <img src="https://images.unsplash.com/photo-1604594849809-dfedbc827105?ixlib=rb-1.2.1&auto=format&fit=crop&w=1280&h=720" alt="Money Illustration" class="w-full max-w-md">
        </div>

    </div>

    <!-- Features Section -->
    <section class="py-16 bg-gray-100 w-full">
        <div class="max-w-5xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-8 text-gray-800">Features</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Track Your Expenses</h3>
                    <p class="text-gray-700">Easily categorize and monitor your daily, monthly, and annual expenses to stay on top of your financial goals.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Budgeting Made Easy</h3>
                    <p class="text-gray-700">Set budgets, track your progress, and get notified when you're nearing your budget limits.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Multiple Accounts</h3>
                    <p class="text-gray-700">Manage multiple family or group accounts seamlessly, making it easier to organize finances for everyone in your household.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-16 bg-gradient-to-r from-green-400 to-blue-500 text-white">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-4xl font-bold mb-8">What Our Users Say</h2>
            <p class="text-lg italic">"SaveSmart has completely transformed the way I handle my finances. It’s intuitive, easy to use, and keeps me on track every day!"</p>
            <p class="mt-4 font-semibold">— John Doe, Satisfied User</p>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="text-center py-16 bg-blue-600">
        <h2 class="text-3xl font-extrabold text-white mb-4">Ready to Take Control of Your Finances?</h2>
        <p class="text-xl text-white mb-6">Sign up today and start your financial journey with SaveSmart.</p>
        <a href="/register" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">Get Started</a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-center py-4 text-white">
        <p>&copy; 2025 SaveSmart. All rights reserved.</p>
    </footer>

</body>
</html>
