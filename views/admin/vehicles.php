<?php
require_once __DIR__ . '/../../autoload.php';

$vehicle = new Vehicle();
$vehicles = $vehicle->getAllVehicles();
$categories = (new Category())->listCategory();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleController = new VehicleController();
    if (isset($_POST['add_vehicle'])) {
        $result = $vehicleController->storeVehicle();
        if ($result === 'success') {
            header('Location: vehicles.php');
            exit;
        }
    } elseif (isset($_POST['edit_vehicle'])) {
        $result = $vehicleController->updateVehicle($_POST['vehicle_id']);
        if ($result === 'success') {
            header('Location: vehicles.php');
            exit;
        }
    } elseif (isset($_POST['Vehicleid'])) {
        $result = $vehicleController->deleteVehicle($_POST['Vehicleid']);
        if ($result === 'success') {
            header('Location: vehicles.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Vehicles | MaBagnole Admin</title>
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
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
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
        <h1 class="text-4xl font-bold text-red-500 mb-8 flex items-center">
            <i class="fas fa-car mr-3"></i> Manage Vehicles
        </h1>

        <div class="mb-6">
            <button id="addVehicleBtn"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Vehicle
            </button>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-xl border border-gray-700">
                <thead>
                    <tr class="text-left text-gray-300 border-b border-gray-700">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Model</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Price/Day</th>
                        <th class="px-6 py-3">Availability</th>
                        <th class="px-6 py-3">image</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">
                    <?php foreach ($vehicles as $vehi): ?>

                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                            <td class="px-6 py-4"><?= $vehi->Vehicle_id ?></td>
                            <td class="px-6 py-4"><?= $vehi->vehicleModel ?></td>
                            <td class="px-6 py-4"><?= $vehi->categoryName ?></td>
                            <td class="px-6 py-4"><?= $vehi->vehicleDescription ?></td>
                            <td class="px-6 py-4"><?= $vehi->vehiclePricePerDay ?>$</td>
                            <td class="px-6 py-4">
                                <?= $vehi->vehicleAvailability == 1 ? 'Available' : 'Not Available' ?>
                            </td>
                            <td class="px-6 py-4"><img src="<?= $vehi->image ?>" alt=""></td>


                            <td class="px-6 py-4 flex gap-2">
                                <button onclick="openEditVehicle(
        <?= $vehi->Vehicle_id ?>,
        '<?= htmlspecialchars($vehi->vehicleModel) ?>',
        '<?= htmlspecialchars($vehi->image) ?>',
        '<?= htmlspecialchars($vehi->vehicleDescription) ?>',
        <?= $vehi->vehiclePricePerDay ?>,
        <?= $vehi->vehicleAvailability ?>,
        <?= $vehi->vehicleIdCategory ?>
    )" class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white font-semibold editBtn">
                                    Edit
                                </button>



                                <form method="POST" action="#" ;
                                    onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    <input type="hidden" name="Vehicleid" value="<?= $vehi->Vehicle_id ?>">
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-800 hover:bg-red-900 rounded text-white font-semibold">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>



    <div id="addVehicleModal" class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <div class="bg-gray-900 w-full max-w-lg rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-500">Add Vehicle</h2>
                <button id="closeVehicleModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="#" class="space-y-4">
                <input type="hidden" name="add_vehicle" value="1">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Vehicle Model</label>
                    <input type="text" name="vehicleModel" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Image (filename)</label>
                    <input type="text" name="vehicleImage" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Description</label>
                    <textarea name="vehicleDescription" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500"></textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Price per Day ($)</label>
                    <input type="number" step="0.01" name="vehiclePricePerDay" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Availability</label>
                    <select name="vehicleAvailability"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Category</label>
                    <select name="vehicleIdCategory" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->Category_id ?>">
                                <?= htmlspecialchars($category->categoryName) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" id="cancelVehicleModal"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg font-semibold">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold text-white">
                        Save
                    </button>
                </div>

            </form>
        </div>
    </div>


    <div id="editVehicleModal"
        class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <div class="bg-gray-900 w-full max-w-lg rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-500">Edit Vehicle</h2>
                <button id="closeEditVehicleModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="#" class="space-y-4">
                <input type="hidden" name="edit_vehicle" value="2">

                <input type="hidden" name="vehicle_id" id="editVehicleId">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Vehicle Model</label>
                    <input type="text" name="vehicleModel" id="editVehicleModel" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Image (filename)</label>
                    <input type="text" name="vehicleImage" id="editVehicleImage" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Description</label>
                    <textarea name="vehicleDescription" id="editVehicleDesc" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500"></textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Price per Day ($)</label>
                    <input type="number" step="0.01" name="vehiclePricePerDay" id="editVehiclePrice" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Availability</label>
                    <select name="vehicleAvailability" id="editVehicleAvailability"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                        <option value="1">Available</option>
                        <option value="0">Not Available</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Category</label>
                    <select name="vehicleIdCategory" id="editVehicleCategory" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->Category_id ?>">
                                <?= htmlspecialchars($category->categoryName) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" id="cancelEditVehicleModal"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg font-semibold">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold text-white">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>



</body>
<script>
    const addVehicleBtn = document.getElementById('addVehicleBtn');
    const addVehicleModal = document.getElementById('addVehicleModal');
    const closeVehicleModal = document.getElementById('closeVehicleModal');
    const cancelVehicleModal = document.getElementById('cancelVehicleModal');

    addVehicleBtn.onclick = () => addVehicleModal.classList.remove('hidden');
    closeVehicleModal.onclick = () => addVehicleModal.classList.add('hidden');
    cancelVehicleModal.onclick = () => addVehicleModal.classList.add('hidden');




    const editModal = document.getElementById('editVehicleModal');

    function openEditVehicle(id, model, image, desc, price, availability, category) {
        document.getElementById('editVehicleId').value = id;
        document.getElementById('editVehicleModel').value = model;
        document.getElementById('editVehicleImage').value = image;
        document.getElementById('editVehicleDesc').value = desc;
        document.getElementById('editVehiclePrice').value = price;
        document.getElementById('editVehicleAvailability').value = availability;
        document.getElementById('editVehicleCategory').value = category;

        editModal.classList.remove('hidden');
    }

    document.getElementById('closeEditVehicleModal').onclick = () => editModal.classList.add('hidden');
    document.getElementById('cancelEditVehicleModal').onclick = () => editModal.classList.add('hidden');
</script>

</html>