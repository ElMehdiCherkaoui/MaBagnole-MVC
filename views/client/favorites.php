<?php
require_once __DIR__ . '/../../autoload.php';
session_start();
$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites | MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600 flex items-center">
                <i class="fas fa-car mr-2"></i> MaBagnole
            </h1>

            <div class="hidden md:flex space-x-4 items-center">
                <div class="text-gray-700 font-medium">Welcome, <?= $user->userName;  ?></div>
                <a href="dashboard.php"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">Dashboard</a>
                <a href="../logout.php"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Logout</a>
            </div>

        </div>

    </nav>

    <div class="max-w-7xl mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <h2 class="text-3xl font-semibold text-gray-800">Your Favorites</h2>
            <p class="mt-2 text-gray-600">Here are all the vehicles or articles you've marked as favorites.</p>

            <div class="mt-6 space-y-6">
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-blue-600 hover:text-blue-800 cursor-pointer">Luxury Sedan
                        </h3>
                        <button class="text-red-600 hover:text-red-700 font-medium">Remove</button>
                    </div>
                    <p class="mt-2 text-gray-600">This is a brief description of the vehicle or article that the user
                        has marked as a favorite. You can replace this text with dynamic content from your database.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="vehicle_details.php?id=1" class="text-blue-600 hover:text-blue-800">View Details</a>
                    </div>
                </div>

            </div>

            <div id="no-favorites" class="mt-6 text-center text-gray-500 hidden">
                <p>You have no favorite items yet. Start adding some!</p>
            </div>

        </div>
    </div>

</body>

</html>