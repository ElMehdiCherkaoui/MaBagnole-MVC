<?php
require_once __DIR__ . '/../../autoload.php';
session_start();
$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);


$vehicleId = (int)$_SESSION['vehicleId'];

$vehicle = (new Vehicle)->getVehicle($vehicleId);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rating  = $_POST['rating'];
    $comment = $_POST['comment'];
    $vehicle = $vehicleId;
    $userid = $user->Users_id;

    if ($rating && $comment && $vehicle) {

        $review = new Review();
        $review->reviewRate = $rating;
        $review->reviewComment = $comment;
        $review->reviewIdVehicle = $vehicle;

        $result = $review->CreateReview($userid);

        if ($result === 'success') {
            header('Location: my_reviews.php');
            exit;
        } else {
            $error = "Something went wrong";
        }
    } else {
        $error = "All fields are required";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Review | MaBagnole</title>
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

    <script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
    </script>

    <main class="max-w-3xl mx-auto mt-10 px-4">
        <h1 class="text-4xl font-bold text-center mb-12 text-gray-800 flex items-center justify-center">
            <i class="fas fa-star text-yellow-500 mr-3"></i> Create a Review
        </h1>

        <div class="bg-white shadow-md rounded-2xl p-8 border-l-4 border-blue-500 hover:shadow-xl transition">
            <form action="#" method="POST" class="space-y-6">
                <?php if (!empty($error)): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    <?= $error ?>
                </div>
                <?php endif; ?>
                <div>
                    <label for="vehicle" class="block font-semibold mb-2 text-gray-700 flex items-center">
                        <i class="fas fa-car mr-2 text-blue-600"></i> Vehicle
                    </label>
                    <input type="text" disabled
                        class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="<?php echo htmlspecialchars($vehicle->vehicleModel); ?>">
                </div>


                <div>
                    <label for="rating" class="block font-semibold mb-2 text-gray-700 flex items-center">
                        <i class="fas fa-star mr-2 text-yellow-500"></i> Rating
                    </label>
                    <select id="rating" name="rating"
                        class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="1">★☆☆☆☆ (1 star)</option>
                        <option value="2">★★☆☆☆ (2 stars)</option>
                        <option value="3">★★★☆☆ (3 stars)</option>
                        <option value="4">★★★★☆ (4 stars)</option>
                        <option value="5">★★★★★ (5 stars)</option>
                    </select>
                </div>

                <div>
                    <label for="comment" class="block font-semibold mb-2 text-gray-700 flex items-center">
                        <i class="fas fa-comment mr-2 text-blue-600"></i> Comment
                    </label>
                    <textarea id="comment" name="comment" rows="4" placeholder="Write your review..."
                        class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <button type="submit"
                    class="w-full p-3 rounded-xl bg-blue-500 hover:bg-blue-600 font-semibold text-white shadow-lg transition flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Review
                </button>
            </form>
        </div>
    </main>

    <footer class="bg-white border-t shadow-inner mt-16">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 flex items-center justify-center">
            <i class="fas fa-copyright mr-2"></i> 2025 MaBagnole — All rights reserved.
        </div>
    </footer>

</body>

</html>