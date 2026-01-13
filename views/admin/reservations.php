<?php
require_once __DIR__ . '/../../autoload.php';

$reservation = new Reservation();
$reservations = $reservation->listReservation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['confirm_reservation'])) {
        $reservation->confirmReservation((int) $_POST['reservation_id']);
        header('Location: reservations.php');
        exit;
    }

    if (isset($_POST['cancel_reservation'])) {
        $reservation->cancleReservation((int) $_POST['reservation_id']);
        header('Location: reservations.php');
        exit;
    }
    if (isset($_POST['finishReservation'])) {
        $reservation->finishReservation((int) $_POST['reservation_id']);
        header('Location: reservations.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Reservations | MaBagnole Admin</title>
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
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
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
        <h1 class="text-4xl font-bold text-red-500 mb-8 flex items-center">
            <i class="fas fa-calendar-check mr-3"></i> Manage Reservations
        </h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-xl border border-gray-700">
                <thead>
                    <tr class="text-left text-gray-300 border-b border-gray-700">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Vehicle</th>
                        <th class="px-6 py-3">Client</th>
                        <th class="px-6 py-3">Pickup</th>
                        <th class="px-6 py-3">Return</th>
                        <th class="px-6 py-3">Total Amount</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">

                    <?php foreach ($reservations as $res): ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">

                        <td class="px-6 py-4"><?= $res->reservation_id ?></td>

                        <td class="px-6 py-4">
                            <?= htmlspecialchars($res->vehicleModel) ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= htmlspecialchars($res->userName) ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= htmlspecialchars($res->reservationPickUpLocation) ?> - <?= $res->reservationStartDate ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= htmlspecialchars($res->reservationPickUpLocation) ?> - <?= $res->reservationEndDate ?>
                        </td>

                        <td class="px-6 py-4">
                            $<?= number_format($res->reservationTotalAmount, 2) ?>
                        </td>

                        <td class="px-6 py-4">
                            <?php if ($res->reservationStatus === 'pending'): ?>
                            <span class="px-2 py-1 rounded-full bg-yellow-500 text-white font-semibold text-sm">
                                Pending
                            </span>

                            <?php elseif ($res->reservationStatus === 'confirmed'): ?>
                            <span class="px-2 py-1 rounded-full bg-green-600 text-white font-semibold text-sm">
                                Confirmed
                            </span>
                            <?php elseif ($res->reservationStatus === 'done'): ?>
                            <span class="px-2 py-1 rounded-full bg-green-600 text-white font-semibold text-sm">
                                Done
                            </span>

                            <?php else: ?>
                            <span class="px-2 py-1 rounded-full bg-gray-500 text-white font-semibold text-sm">
                                Cancelled
                            </span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 flex gap-2">

                            <?php if ($res->reservationStatus === 'pending'): ?>

                            <form method="POST">
                                <input type="hidden" name="reservation_id" value="<?= $res->reservation_id ?>">
                                <button name="confirm_reservation"
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-white font-semibold">
                                    Confirm
                                </button>
                            </form>

                            <form method="POST">
                                <input type="hidden" name="reservation_id" value="<?= $res->reservation_id ?>">
                                <button name="cancel_reservation"
                                    class="px-3 py-1 bg-red-800 hover:bg-red-900 rounded text-white font-semibold">
                                    Cancel
                                </button>
                            </form>

                            <?php elseif ($res->reservationStatus === 'confirmed'): ?>

                            <form method="POST">
                                <input type="hidden" name="reservation_id" value="<?= $res->reservation_id ?>">
                                <button name="finishReservation"
                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-white font-semibold">
                                    Done
                                </button>
                            </form>

                            <form method="POST">
                                <input type="hidden" name="reservation_id" value="<?= $res->reservation_id ?>">
                                <button name="cancel_reservation"
                                    class="px-3 py-1 bg-red-800 hover:bg-red-900 rounded text-white font-semibold">
                                    Cancel
                                </button>
                            </form>

                            <?php else: ?>

                            <span class="text-gray-400 italic">No Actions</span>

                            <?php endif; ?>

                        </td>

                    </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
        </div>
    </main>



</body>

</html>