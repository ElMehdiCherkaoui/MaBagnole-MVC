<?php

require_once __DIR__ . '/../../autoload.php';
session_start();

$errors = [];

if (!isset($_SESSION['userEmailLogin'])) {
    header("Location: login.php");
    exit;
}

$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);

if (!$user || !isset($user->Users_id)) {
    header("Location: login.php");
    exit;
}

$vehicles = new Vehicle();
$listVehicles = $vehicles->getAllVehicles();

if (isset($_GET['id'])) {
    $vehicle = $vehicles->getVehicle((int) $_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!preg_match('/^[a-zA-Z\s]{3,50}$/', $_POST['pickup_location'])) {
        $errors[] = "Pickup location must contain only letters and spaces.";
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['pickup_date'])) {
        $errors[] = "Pickup date format is invalid.";
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['dropoff_date'])) {
        $errors[] = "Drop-off date format is invalid.";
    }

    if (!preg_match('/^[0-9]+$/', $_POST['vehicle_options'])) {
        $errors[] = "Please select a valid vehicle.";
    }

    if (empty($errors)) {
        $pickup = strtotime($_POST['pickup_date']);
        $dropoff = strtotime($_POST['dropoff_date']);

        if ($dropoff <= $pickup) {
            $errors[] = "Drop-off date must be after pickup date.";
        }
    }

    if (empty($errors)) {

        $vehicleId = (int) $_POST['vehicle_options'];
        $vehicleData = $vehicles->getVehicle($vehicleId);

        if (!$vehicleData) {
            $errors[] = "Selected vehicle does not exist.";
        } else {
            $price = $vehicleData->vehiclePricePerDay;
            $days = ($dropoff - $pickup) / (60 * 60 * 24);
            $totalamount = $days * $price;

            $reservation = new Reservation(
                null,
                $_POST['pickup_date'],
                $_POST['dropoff_date'],
                $_POST['pickup_location'],
                'pending',
                $totalamount,
                (int) $user->Users_id,
                (int) $vehicleId
            );

            $result = $reservation->ajouteReservation();

            if ($result === "success") {
                header("Location: my_reservations.php");
                exit;
            } else {
                $errors[] = $result;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reserve Vehicle | MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen text-gray-800">

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

    <main class="max-w-4xl mx-auto mt-10 px-4">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-4xl font-bold text-gray-800">Reserve Tesla Model S</h1>
            <a href="vehicle_details.php"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Details
            </a>
        </div>

        <div class="bg-white shadow-lg rounded-2xl p-8 border-l-4 border-blue-500 hover:shadow-xl transition">
            <form method="POST" class="space-y-6">
                <?php if (!empty($errors)): ?>
                <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-400 text-red-700">
                    <ul class="list-disc pl-5">
                        <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>


                <div>
                    <label for="pickup_location" class="block font-semibold mb-2 text-gray-700 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Pickup Location
                    </label>
                    <input type="text" id="pickup_location" name="pickup_location" placeholder="Enter city or address"
                        class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-transparent">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="pickup_date" class="block font-semibold mb-2 text-gray-700 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> Pickup Date
                        </label>
                        <input type="date" id="pickup_date" name="pickup_date"
                            class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-transparent">
                    </div>
                    <div>
                        <label for="dropoff_date" class="block font-semibold mb-2 text-gray-700 flex items-center">
                            <i class="fas fa-calendar-check mr-2 text-blue-500"></i> Dropoff Date
                        </label>
                        <input type="date" id="dropoff_date" name="dropoff_date"
                            class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="vehicle_options" class="block font-semibold mb-2 text-gray-700 flex items-center">
                        <i class="fas fa-cogs mr-2 text-blue-500"></i> Vehicle Options
                    </label>
                    <select id="vehicle_options" name="vehicle_options"
                        class="w-full pl-4 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-transparent">
                        <option value="">--- Select Model Car ---</option>
                        <?php foreach ($listVehicles as $listvehicle): ?>
                        <?php if ($listvehicle->vehicleModel == $vehicle->vehicleModel): ?>
                        <option value="<?= $listvehicle->Vehicle_id ?>" selected>
                            <?= $listvehicle->vehicleModel ?>
                        </option>
                        <?php else: ?>
                        <option value="<?= $listvehicle->Vehicle_id ?>">
                            <?= $listvehicle->vehicleModel ?>
                        </option>
                        <?php endif ?>

                        <?php endforeach ?>
                    </select>
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 font-semibold text-white shadow-lg transition flex items-center justify-center">
                    <i class="fas fa-calendar-check mr-2"></i> Reserve Now
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