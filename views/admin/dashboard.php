<?php
require_once __DIR__ . '/../../autoload.php';

$totalVehicles = (new Vehicle)->getTotalCount();
$totalReservations = (new Reservation)->countTotalReservation();
$totalReviews = (new Review())->countReviews();
$totalCategorys = (new Category())->countCategory();
$totalThemes   = (new Theme())->countThemes();
$totalArticles = (new Article())->countArticles();
$totalTags     = (new Tag())->countTags();
$totalComments = (new Comment())->countAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | MaBagnole</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-900 text-gray-100 min-h-screen font-sans flex">

    <aside class="bg-gray-950 w-64 min-h-screen flex flex-col fixed border-r border-gray-800">
        <div class="p-6 flex items-center justify-center border-b border-gray-800">
            <span class="text-2xl font-bold text-red-500 flex items-center">
                <i class="fas fa-car mr-2"></i> MaBagnole Admin
            </span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="dashboard.php"
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="vehicles.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-car mr-2"></i> Vehicles
            </a>
            <a href="categories.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-tags mr-2"></i> Categories
            </a>
            <a href="admin_themes.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-clipboard-list mr-2"></i> Themes
            </a>
            <a href="admin_articles.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-newspaper mr-2"></i> Articles
            </a>
            <a href="reservations.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-calendar-check mr-2"></i> Reservations
            </a>
            <a href="reviews.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-star mr-2"></i> Reviews
            </a>
            <a href="admin_tags.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-tags mr-2"></i> Tags
            </a>
            <a href="admin_comments.php"
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-comments mr-2"></i> Comments
            </a>
            <a href="../logout.php"
                class="block px-4 py-3 rounded-lg text-gray-400 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </nav>
    </aside>

    <main class="flex-1 ml-64 p-8">
        <h1 class="text-4xl font-bold text-red-500 mb-12 flex items-center">
            <i class="fas fa-tachometer-alt mr-3"></i> Admin Dashboard
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Vehicles</h2>
                    <i class="fas fa-car text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center">
                    <?= $totalVehicles ?>
                </p>
            </div>
            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Reservations</h2>
                    <i class="fas fa-calendar-check text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center"><?= $totalReservations ?></p>
            </div>
            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Reviews</h2>
                    <i class="fas fa-star text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center"><?= $totalReviews ?></p>
            </div>
            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Categories</h2>
                    <i class="fas fa-tags text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center"><?= $totalCategorys ?></p>
            </div>
            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Themes</h2>
                    <i class="fas fa-clipboard-list text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center">
                    <?= $totalThemes->totalCount ?>
                </p>
            </div>

            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Articles</h2>
                    <i class="fas fa-newspaper text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center">
                    <?= $totalArticles->totalCount ?>
                </p>
            </div>

            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Tags</h2>
                    <i class="fas fa-tags text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center">
                    <?= $totalTags->totalCount ?>
                </p>
            </div>

            <div
                class="bg-gray-800 p-6 rounded-2xl border-l-4 border-red-500 shadow hover:scale-105 transform transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-red-400">Comments</h2>
                    <i class="fas fa-comments text-red-400 text-2xl"></i>
                </div>
                <p class="text-4xl font-bold text-gray-100 text-center">
                    <?= $totalComments->totalCountComment ?>
                </p>
            </div>
        </div>

    </main>



</body>

</html>