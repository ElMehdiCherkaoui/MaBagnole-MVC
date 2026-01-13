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
    <title>Edit Comment | MaBagnole</title>
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

            <h2 class="text-3xl font-semibold text-gray-800">Edit Your Comment</h2>
            <p class="mt-2 text-gray-600">You can modify your comment below. Please make sure to review it before
                saving.</p>

            <div class="mt-6 bg-gray-50 p-6 rounded-lg shadow-md">
                <p class="text-lg font-semibold text-gray-800">Your Comment</p>
                <p class="mt-2 text-gray-600">"This is a sample comment that can be edited by the user. The content can
                    be modified before submitting the changes."</p>
                <p class="mt-2 text-sm text-gray-500">Posted on: 2026-01-05</p>
            </div>

            <form action="#" method="POST" class="mt-6">

                <div class="mb-4">
                    <label for="comment" class="block text-gray-700 font-medium">Edit Comment</label>
                    <textarea id="comment" name="comment" rows="4"
                        class="w-full mt-2 p-3 border border-gray-300 rounded-lg"
                        placeholder="Edit your comment here..." required>Existing comment content</textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
                    Save Changes
                </button>
            </form>

            <div class="mt-6">
                <a href="article_detail.php?id=1" class="text-gray-500 hover:text-gray-700">Cancel</a>
            </div>

        </div>
    </div>

</body>

</html>