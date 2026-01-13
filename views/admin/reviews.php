<?php
require_once __DIR__ . '/../../autoload.php';

$reviews = (new Review())->listAllReviews();

if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST["review_id"])) {
    (new Review())->recoveryReview($_POST["review_id"]);
    header('location: reviews.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Reviews | MaBagnole Admin</title>
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
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
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
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
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
        <h1 class="text-4xl font-bold text-red-500 mb-8 flex items-center">
            <i class="fas fa-star mr-3"></i> Manage Reviews
        </h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-xl border border-gray-700">
                <thead>
                    <tr class="text-left text-gray-300 border-b border-gray-700">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Vehicle</th>
                        <th class="px-6 py-3">Client</th>
                        <th class="px-6 py-3">Rating</th>
                        <th class="px-6 py-3">Comment</th>
                        <th class="px-6 py-3">Delete Date</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">
                    <?php foreach ($reviews as $review): ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                        <td class="px-6 py-4">
                            <?= $review->Review_id ?>
                        </td>
                        <td class="px-6 py-4"><?= $review->vehicleModel ?></td>
                        <td class="px-6 py-4"> <?= $review->userName ?></td>
                        <td class="px-6 py-4"> <?= $review->reviewRate ?></td>
                        <td class="px-6 py-4"> <?= $review->reviewComment ?></td>
                        <?php if ($review->reviewDeleteTime == NULL): ?>
                        <td class="px-6 py-4"> <span class="text-green-500">Active</span></td>
                        <td class="px-6 py-4 flex gap-2 text-gray-400">No Action</td>
                        <?php else: ?> <td class="px-6 py-4"> <?= $review->reviewDeleteTime ?>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <form method="POST" action="reviews.php" ;
                                onsubmit="return confirm('Are you sure you want to recovery this review?')">
                                <input type="hidden" name="review_id" value="<?= $review->Review_id ?>">
                                <button type="submit"
                                    class="px-3 py-1 bg-red-800 hover:bg-red-900 rounded text-white font-semibold">
                                    Recovery
                                </button>
                            </form>
                        </td>
                        <?php endif ?>

                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </main>



</body>

</html>