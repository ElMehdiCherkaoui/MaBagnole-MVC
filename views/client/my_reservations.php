<?php
require_once __DIR__ . '/../../autoload.php';
session_start();

if (!isset($_SESSION['userEmailLogin'])) {
    header("Location: login.php");
    exit;
}

$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);

if (!$user || !isset($user->Users_id)) {
    header("Location: login.php");
    exit;
}

$reservationModel = new Reservation();
$reservations = $reservationModel->getReservationsByUser($user->Users_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
    $reservationModel->cancleReservation((int)$_POST['cancel_id']);
    header("Location: my_reservations.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['makeReview']) && isset($_POST['vehicleId'])) {
    $_SESSION['vehicleId'] = $_POST['vehicleId'];
    if ($_SESSION['vehicleId']) {
        header("Location: create_review.php");
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Reservations</title>
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
                <div class="text-gray-700 font-medium">Welcome, <?= $user->userName;  ?></div>
                <a href="dashboard.php"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">Dashboard</a>
                <a href="../logout.php"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Logout</a>
            </div>


        </div>


    </nav>



    <div class="max-w-6xl mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">My Reservations</h1>

        <?php if (empty($reservations)): ?>
            <p class="text-gray-600">You have no reservations yet.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($reservations as $reservation): ?>
                    <div class="bg-white shadow-md rounded-xl p-6 hover:shadow-xl transition border-l-4 
                <?php
                    if ($reservation->reservationStatus == 'confirmed' || $reservation->reservationStatus == 'done') echo 'border-green-500';
                    elseif ($reservation->reservationStatus == 'pending') echo 'border-yellow-500';
                    else echo 'border-gray-400';
                ?>">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-car text-blue-600 text-2xl mr-3"></i>
                            <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($reservation->vehicleModel) ?>
                            </h2>
                        </div>
                        <div class="space-y-2 mb-4">
                            <p class="text-gray-600 flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i>
                                <strong>Pickup:</strong> <?= htmlspecialchars($reservation->reservationPickUpLocation) ?> –
                                <?= htmlspecialchars($reservation->reservationStartDate) ?>
                            </p>
                            <p class="text-gray-600 flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i>
                                <strong>Return:</strong> <?= htmlspecialchars($reservation->reservationPickUpLocation) ?> –
                                <?= htmlspecialchars($reservation->reservationEndDate) ?>
                            </p>
                            <p class="text-gray-600 flex items-center">
                                <i class="fas fa-dollar-sign text-gray-500 mr-2"></i>
                                <strong>Total Amount:</strong> $<?= number_format($reservation->reservationTotalAmount, 2) ?>
                            </p>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        <?php
                        if ($reservation->reservationStatus == 'confirmed' || $reservation->reservationStatus == 'done') echo 'bg-green-100 text-green-800';
                        elseif ($reservation->reservationStatus == 'pending') echo 'bg-yellow-100 text-yellow-800';
                        else echo 'bg-gray-100 text-gray-800';
                        ?>">
                                <i class="fas fa-<?php
                                                    if ($reservation->reservationStatus == 'confirmed' || $reservation->reservationStatus == 'done') echo 'check-circle';
                                                    elseif ($reservation->reservationStatus == 'pending') echo 'clock';
                                                    else echo 'ban';
                                                    ?> mr-1"></i>
                                <?= htmlspecialchars($reservation->reservationStatus) ?>
                            </span>
                        </div>
                        <?php if ($reservation->reservationStatus == 'pending' || $reservation->reservationStatus == 'confirmed'): ?>
                            <form method="POST" class="w-full">
                                <input type="hidden" name="cancel_id" value="<?= $reservation->reservation_id ?>">
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition w-full flex items-center justify-center">
                                    <i class="fas fa-times mr-2"></i> Cancel Reservation
                                </button>
                            </form>
                        <?php elseif ($reservation->reservationStatus == 'done'): ?>
                            <form method="POST" class="w-full">
                                <input type="hidden" name="vehicleId" value="<?= $reservation->Vehicle_id ?>">

                                <button type="submit" name="makeReview"
                                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition w-full flex items-center justify-center">
                                    <i class="fas fa-star mr-2 "></i>Make a Review
                                </button>
                            </form>
                        <?php else: ?>
                            <button
                                class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed w-full flex items-center justify-center"
                                disabled>
                                <i class="fas fa-times mr-2"></i> Cancel Reservation
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-white border-t shadow-inner mt-16">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 flex items-center justify-center">
            <i class="fas fa-copyright mr-2"></i> 2025 MaBagnole — All rights reserved.
        </div>
    </footer>

</body>

</html>