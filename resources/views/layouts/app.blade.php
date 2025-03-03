<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navbar or header section, if any -->
    <nav class="bg-gray-800 p-4 flex justify-end">
        <a href="/logout" id="logoutButton" class="px-6 py-2 bg-yellow-900 hover:bg-[#2d3748] text-lg font-semibold rounded-md h-12">
            Logout
        </a>
    </nav>
    
    

    <!-- Main content goes here -->
    <div class="container mx-auto p-4 ">
        @yield('content')  <!-- Content from child views will be injected here -->
    </div>

    <!-- Footer or any additional sections, if any -->
    <footer class="bg-gray-800 p-4 text-center">
        <p class="text-white">© 2025 My Application</p>
    </footer>
</body>
</html>
