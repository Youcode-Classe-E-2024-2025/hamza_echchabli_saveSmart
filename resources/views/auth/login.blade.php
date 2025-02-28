<!-- resources/views/auth/login.blade.php -->
@include('partials.header')
<body class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">

    <!-- Login Form Container -->
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white text-gray-900 rounded-lg shadow-lg p-8 w-full max-w-sm">
            <h2 class="text-3xl font-extrabold text-center mb-6 text-blue-600">Login</h2>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-sm font-semibold">Remember Me</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full p-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Login
                </button>
            </form>

            <!-- Forgot Password Link -->
            <div class="mt-4 text-center">
                <a href="" class="text-sm text-blue-500 hover:underline">Forgot your password?</a>
            </div>

            <!-- Register Link -->
            <div class="mt-4 text-center">
                <p class="text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign up</a></p>
            </div>
        </div>
    </div>

</body>
</html>
