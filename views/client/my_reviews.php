<?php
require_once __DIR__ . '/../../autoload.php';
session_start();
$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);
$listReviews = (new Review())->listReviews($_SESSION['userEmailLogin']);

if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST["review_id"])) {
    (new Review())->softDelete($_POST["review_id"]);
    header("location: my_reviews.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_review_id'])) {

    $review = new Review();
    $review->reviewRate = $_POST['rating'];
    $review->reviewComment = $_POST['comment'];

    $review->editReviews($_POST['edit_review_id']);

    header("Location: my_reviews.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Reviews | MaBagnole</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">

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



    <div class="max-w-6xl mx-auto mt-10 px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-star mr-3 text-yellow-500"></i> My Reviews
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <?php foreach ($listReviews as $review): ?>
                <div class="bg-white shadow-md rounded-xl p-6 hover:shadow-xl transition border-l-4 border-blue-500">

                    <div class="flex items-center mb-4">
                        <i class="fas fa-car text-blue-600 text-2xl mr-3"></i>
                        <h2 class="text-xl font-semibold text-gray-800">
                            <?= htmlspecialchars($review->vehicleModel) ?>
                        </h2>
                    </div>

                    <div class="flex items-center mb-2">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <span class="text-yellow-400 font-semibold">
                            <?= str_repeat('★', $review->reviewRate) ?>
                            <?= str_repeat('☆', 5 - $review->reviewRate) ?>
                            (<?= $review->reviewRate ?>/5)
                        </span>
                    </div>

                    <p class="text-gray-600 mb-4">
                        <?= htmlspecialchars($review->reviewComment) ?>
                    </p>
                    <div class="flex gap-2">
                        <button type="button"
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded transition flex items-center justify-center"
                            onclick="openEditModal(
                            '<?= $review->Review_id ?>',
                            '<?= $review->reviewRate ?>',
                            `<?= htmlspecialchars($review->reviewComment) ?>`)">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>


                        <form method="POST" action="my_reviews.php" class="flex-1"
                            onsubmit="return confirm('Are you sure you want to delete this review?')">
                            <input type="hidden" name="review_id" value="<?= $review->Review_id ?>">
                            <button type="submit"
                                class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded transition">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>


                </div>
                <?php endforeach; ?>

            </div>


        </div>
    </div>
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">

            <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>

            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-edit mr-2 text-blue-500"></i> Edit Review
            </h2>

            <form method="POST" action="my_reviews.php" class="space-y-4">

                <input type="hidden" name="edit_review_id" id="edit_review_id">

                <div>
                    <label class="block font-semibold mb-1">Rating</label>
                    <select name="rating" id="edit_rating" class="w-full border rounded p-2">
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Comment</label>
                    <textarea name="comment" id="edit_comment" rows="4" class="w-full border rounded p-2"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded">
                    Save Changes
                </button>

            </form>

        </div>
    </div>

    <footer class="bg-white border-t shadow-inner mt-16">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 flex items-center justify-center">
            <i class="fas fa-copyright mr-2"></i> 2025 MaBagnole — All rights reserved.
        </div>
    </footer>

</body>
<script>
function openEditModal(id, rating, comment) {
    document.getElementById('edit_review_id').value = id;
    document.getElementById('edit_rating').value = rating;
    document.getElementById('edit_comment').value = comment;

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>

</html>