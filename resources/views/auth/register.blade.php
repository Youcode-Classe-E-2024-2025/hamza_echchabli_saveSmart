<!-- resources/views/auth/register.blade.php -->
@include('partials.header')
<body class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">

    <!-- Register Form Container -->
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white text-gray-900 rounded-lg shadow-lg p-8 w-full max-w-sm">
            <h2 class="text-3xl font-extrabold text-center mb-6 text-blue-600">Sign Up</h2>

            <!-- Register Form -->
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold">Full Name</label>
                    <input type="text" name="name" id="name" class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full p-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Sign Up
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-4 text-center">
                <p class="text-sm">Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a></p>
            </div>
        </div>
    </div>

</body>
</html>
