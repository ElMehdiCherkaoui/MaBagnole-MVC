<?php 
require_once __DIR__ . '/../../autoload.php';
session_start();


if (!isset($_SESSION['userEmailLogin'])) {
    header("Location: login.php"); 
    exit();
}

$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600 flex items-center">
                <i class="fas fa-car mr-2"></i> MaBagnole
            </h1>
            <div class="hidden md:flex space-x-4 items-center">
                <div class="text-gray-700 font-medium">Welcome, <?= htmlspecialchars($user->userName); ?></div>
                <a href="dashboard.php"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">Dashboard</a>
                <a href="../logout.php"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Logout</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 flex items-center">
            <i class="fas fa-tachometer-alt mr-3 text-blue-600"></i> Your Dashboard
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <a href="vehicles.php"
                class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition transform hover:-translate-y-1 border-l-4 border-blue-500 group">
                <div class="flex items-center mb-4">
                    <i class="fas fa-car text-2xl text-blue-500 mr-3 group-hover:scale-110 transition"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Browse Vehicles</h2>
                </div>
                <p class="text-gray-600">Explore all available cars & bikes</p>
                <div class="mt-4 flex items-center text-blue-600 font-medium">
                    <span>View Now</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <a href="themes.php"
                class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition transform hover:-translate-y-1 border-l-4 border-indigo-500 group">
                <div class="flex items-center mb-4">
                    <i class="fas fa-layer-group text-2xl text-indigo-500 mr-3 group-hover:scale-110 transition"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Explore Themes</h2>
                </div>
                <p class="text-gray-600">Browse through various themes and topics</p>
                <div class="mt-4 flex items-center text-indigo-600 font-medium">
                    <span>Explore</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <a href="my_reservations.php"
                class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition transform hover:-translate-y-1 border-l-4 border-green-500 group">
                <div class="flex items-center mb-4">
                    <i class="fas fa-calendar-check text-2xl text-green-500 mr-3 group-hover:scale-110 transition"></i>
                    <h2 class="text-xl font-semibold text-gray-800">My Reservations</h2>
                </div>
                <p class="text-gray-600">Manage your bookings easily</p>
                <div class="mt-4 flex items-center text-green-600 font-medium">
                    <span>Manage</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <a href="my_reviews.php"
                class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition transform hover:-translate-y-1 border-l-4 border-yellow-500 group">
                <div class="flex items-center mb-4">
                    <i class="fas fa-star text-2xl text-yellow-500 mr-3 group-hover:scale-110 transition"></i>
                    <h2 class="text-xl font-semibold text-gray-800">My Reviews</h2>
                </div>
                <p class="text-gray-600">Edit or remove your feedback</p>
                <div class="mt-4 flex items-center text-yellow-600 font-medium">
                    <span>View Reviews</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <a href="reserve.php"
                class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition transform hover:-translate-y-1 border-l-4 border-red-500 group">
                <div class="flex items-center mb-4">
                    <i class="fas fa-plus-circle text-2xl text-red-500 mr-3 group-hover:scale-110 transition"></i>
                    <h2 class="text-xl font-semibold text-gray-800">Reserve</h2>
                </div>
                <p class="text-gray-600">Reserve your car</p>
                <div class="mt-4 flex items-center text-red-600 font-medium">
                    <span>Book Now</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition"></i>
                </div>
            </a>

        </div>
    </div>

    <footer class="bg-white border-t shadow-inner mt-16">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 flex items-center justify-center">
            <i class="fas fa-copyright mr-2"></i> 2025 MaBagnole — All rights reserved.
        </div>
    </footer>

</body>

</html>