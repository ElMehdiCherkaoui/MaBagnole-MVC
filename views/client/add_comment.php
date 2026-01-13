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
    <title>Add Comment | MaBagnole</title>
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

    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <h2 class="text-2xl font-semibold text-gray-800">Add Your Comment</h2>
            <p class="mt-2 text-gray-600">Please share your thoughts about this vehicle.</p>

            <div id="error-message" class="mt-4 text-red-500 hidden">
                <p>Please enter a valid comment.</p>
            </div>

            <form action="#" method="POST" class="mt-6">
                <input type="hidden" name="vehicle_id" value="123">

                <div class="mb-4">
                    <label for="comment" class="block text-gray-700 font-medium">Your Comment</label>
                    <textarea id="comment" name="comment" rows="4"
                        class="w-full mt-2 p-3 border border-gray-300 rounded-lg"
                        placeholder="Write your comment here..." required></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    Post Comment
                </button>
            </form>

            <div class="mt-6">
                <a href="vehicle_details.php?id=123" class="text-blue-500 hover:text-blue-700">Back to Vehicle
                    Details</a>
            </div>
        </div>
    </div>

</body>

</html>