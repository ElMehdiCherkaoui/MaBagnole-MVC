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
    <title>Delete Comment | MaBagnole</title>
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

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <h2 class="text-3xl font-semibold text-gray-800">Delete Comment</h2>
            <p class="mt-2 text-gray-600">Are you sure you want to delete this comment? This action cannot be undone.
            </p>

            <div class="mt-6 bg-gray-50 p-6 rounded-lg shadow-md">
                <p class="text-lg font-semibold text-gray-800">Comment by: Jane Doe</p>
                <p class="mt-2 text-gray-600">"This is a sample comment that will be deleted. The user can see the
                    comment text before confirming deletion."</p>
                <p class="mt-2 text-sm text-gray-500">Posted on: 2026-01-05</p>
            </div>

            <div class="mt-8 flex justify-between">
                <a href="article_detail.php?id=1"
                    class="bg-gray-300 text-gray-800 hover:bg-gray-400 px-6 py-2 rounded-lg transition duration-200">
                    Cancel
                </a>

                <form action="#" method="POST" class="inline-block">
                    <button type="submit"
                        class="bg-red-600 text-white hover:bg-red-700 px-6 py-2 rounded-lg transition duration-200">
                        Confirm Delete
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>

</html>