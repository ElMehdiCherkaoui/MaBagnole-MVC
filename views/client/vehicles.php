<?php
require_once __DIR__ . '/../../autoload.php';
session_start();

$search   = $_POST['search'] ?? '';
$category = $_POST['category'] ?? 'all';

if (!empty($search)) {
    $filteredVehicles = (new Vehicle)->getVehiclesByModel($search);
} else {
    $filteredVehicles = (new Vehicle)->getAllVehicles();
}

if (isset($_POST['ajax']) && $_POST['ajax'] === 'true') {
    header('Content-Type: application/json');

    if ($category !== 'all') {
        $filteredVehicles = (new Vehicle)->getVehiclesByCategory($category);
    }
    echo json_encode($filteredVehicles);
    exit;
}

$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);
$categories = (new Category)->listCategory();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Vehicles | MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
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
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Browse Vehicles</h1>
            <a href="dashboard.php"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>


        <form method="POST" class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="relative w-full md:w-1/2">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                <input id="searchInput" name="search" type="text" placeholder="Search by model or features..."
                    value="<?php echo htmlspecialchars($search); ?>"
                    class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="relative w-full md:w-1/4">
                <i class="fas fa-filter absolute left-3 top-3 text-gray-400"></i>
                <select id="categoryFilter" name="category"
                    class="w-full pl-10 pr-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat->categoryName); ?>"
                        <?php echo $category === $cat->categoryName ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat->categoryName); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white w-full md:w-1/4 px-4 py-2 rounded-lg transition flex items-center justify-center">
                <i class="fas fa-search mr-2"></i> Filter
            </button>
        </form>

        <table id="vehiclesTable" class="display w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Model</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Price/Day</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="vehiclesContainer">
                <?php foreach ($filteredVehicles as $vehicle): ?>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <img src="<?php echo htmlspecialchars($vehicle->image); ?>"
                            alt="<?php echo htmlspecialchars($vehicle->vehicleModel); ?>"
                            class="h-16 w-24 object-cover rounded">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        <?php echo htmlspecialchars($vehicle->vehicleModel); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($vehicle->categoryName); ?></td>
                    <td class="px-6 py-4"><?php echo htmlspecialchars($vehicle->vehiclePricePerDay); ?> MAD/day</td>
                    <td class="px-6 py-4">
                        <a href="vehicle_details.php?id=<?php echo htmlspecialchars($vehicle->Vehicle_id); ?>"
                            class="text-blue-600 hover:text-blue-800">View Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer class="bg-white border-t shadow-inner mt-16">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 flex items-center justify-center">
            <i class="fas fa-copyright mr-2"></i> 2025 MaBagnole — All rights reserved.
        </div>
    </footer>


    <script>
    let table;

    $(document).ready(function() {
        table = $('#vehiclesTable').DataTable({
            "pageLength": 10,
            "lengthChange": false,
            "searching": false,
            "info": false,
            "language": {
                "paginate": {
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });

    })

    const categoryFilter = document.getElementById('categoryFilter');

    categoryFilter.addEventListener("change", () => {
        loadVehicles(categoryFilter.value);
    });

    function loadVehicles(category) {
        fetch(window.location.pathname, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `category=${encodeURIComponent(category)}&ajax=true`
            })
            .then(res => res.json())
            .then(data => {
                table.clear();
                data.forEach(vehicle => {
                    table.row.add([
                        `<img src="${vehicle.image}" alt="${vehicle.vehicleModel}" class="h-16 w-24 object-cover rounded">`,
                        vehicle.vehicleModel,
                        vehicle.categoryName,
                        `${vehicle.vehiclePricePerDay} MAD/day`,
                        `<a href="vehicle_details.php?id=${vehicle.Vehicle_id}" class="text-blue-600 hover:text-blue-800">View Details</a>`
                    ]);
                });

                table.draw();
            })
            .catch(error => console.error('Error:', error));
    }
    </script>


</body>

</html>