<?php
require_once __DIR__ . '/../../autoload.php';

$cate = new Category();
$categories = $cate->listCategory();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {


    $cate->categoryName = $_POST['categoryName'];
    $cate->descriptionCategory = $_POST['categoryDescription'];

    $result = $cate->ajouteCategory();

    if ($result === 'success') {
        header('Location: categories.php');
        exit;
    } else {
        echo $result;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editCategoryId'])) {


    $cate->categoryName = $_POST['categoryName'];
    $cate->descriptionCategory = $_POST['categoryDescription'];
    $result = $cate->modifyCategory((int)$_POST['category_id']);

    if ($result === 'success') {
        header('Location: categories.php');
        exit;
    } else {
        echo $result;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])) {
    $category = new Category();
    $id = (int) $_POST['category_id'];

    $result = $category->suppressionCategory($id);

    if ($result === 'success') {
        header('Location: categories.php');
        exit;
    } else {
        echo $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Categories | MaBagnole Admin</title>
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
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
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
            <i class="fas fa-tags mr-3"></i> Manage Categories
        </h1>

        <div class="mb-6">
            <button id="openAddModal"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Category
            </button>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-xl border border-gray-700">
                <thead>
                    <tr class="text-left text-gray-300 border-b border-gray-700">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Category Name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">
                    <?php foreach ($categories as $category): ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                        <td class="px-6 py-4">
                            <?= $category->Category_id ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= htmlspecialchars($category->categoryName) ?>
                        </td>

                        <td class="px-6 py-4">
                            <?= htmlspecialchars($category->categoryDescription) ?>
                        </td>

                        <td class="px-6 py-4 flex gap-2">
                            <button
                                class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white font-semibold editBtn"
                                data-id="<?= $category->Category_id ?>"
                                data-name="<?= htmlspecialchars($category->categoryName) ?>"
                                data-desc="<?= htmlspecialchars($category->categoryDescription) ?>">
                                Edit
                            </button>


                            <form method="POST" action="#" ;
                                onsubmit="return confirm('Are you sure you want to delete this category?')">
                                <input type="hidden" name="category_id" value="<?= $category->Category_id ?>">
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



    <div id="addCategoryModal"
        class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-500">Add Category</h2>
                <button id="closeAddModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="categories.php" class="space-y-4">
                <input type="hidden" name="add_category" value=" 1">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Category Name</label>
                    <input type="text" name="categoryName" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Description</label>
                    <textarea name="categoryDescription" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelAddModal"
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



    <div id="editCategoryModal"
        class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-500">Edit Category</h2>
                <button id="closeEditModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="categories.php" class="space-y-4">

                <input type="hidden" name="category_id" id="editCategoryId">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Category Name</label>
                    <input type="text" name="categoryName" id="editCategoryName" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Description</label>
                    <textarea name="categoryDescription" id="editCategoryDesc" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelEditModal"
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
const openBtn = document.getElementById('openAddModal');
const modal = document.getElementById('addCategoryModal');
const closeBtn = document.getElementById('closeAddModal');
const cancelBtn = document.getElementById('cancelAddModal');

openBtn.onclick = () => modal.classList.remove('hidden');
closeBtn.onclick = () => modal.classList.add('hidden');
cancelBtn.onclick = () => modal.classList.add('hidden');




const editModal = document.getElementById('editCategoryModal');
const closeEditModal = document.getElementById('closeEditModal');
const cancelEditModal = document.getElementById('cancelEditModal');

const editId = document.getElementById('editCategoryId');
const editName = document.getElementById('editCategoryName');
const editDesc = document.getElementById('editCategoryDesc');

document.querySelectorAll('.editBtn').forEach(button => {
    button.addEventListener('click', () => {
        editId.value = button.dataset.id;
        editName.value = button.dataset.name;
        editDesc.value = button.dataset.desc;

        editModal.classList.remove('hidden');
    });
});

closeEditModal.addEventListener('click', closeModal);
cancelEditModal.addEventListener('click', closeModal);

function closeModal() {
    editModal.classList.add('hidden');
}
</script>

</html>