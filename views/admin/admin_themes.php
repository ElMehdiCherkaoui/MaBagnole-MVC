<?php
require_once __DIR__ . '/../../autoload.php';
$Theme = new Theme();
$themes = $Theme->listThemes();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_theme'])) {


    $Theme->themeTitle = $_POST['themeTitle'];
    $Theme->themeDescription = $_POST['themeDescription'];

    $result = $Theme->addTheme();

    if ($result === 'success') {
        header('Location: admin_themes.php');
        exit;
    } else {
        echo $result;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_theme'])) {


    $Theme->themeTitle = $_POST['themeTitle'];
    $Theme->themeDescription = $_POST['themeDescription'];
    $id = $_POST['theme_id'];

    $result = $Theme->editTheme($id);

    if ($result === 'success') {
        header('Location: admin_themes.php');
       
    } else {
        echo $result;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_theme'])) {

    $id = $_POST['theme_id'];

    $result = $Theme->deleteTheme($id);

    if ($result === 'success') {
        header('Location: admin_themes.php');
       
    } else {
        echo $result;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Themes | MaBagnole Admin</title>
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
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
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
            <i class="fas fa-clipboard-list mr-3"></i> Manage Themes
        </h1>

        <div class="mb-6">
            <button id="openAddModal"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Theme
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-xl border border-gray-700">
                <thead>
                    <tr class="text-left text-gray-300 border-b border-gray-700">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Theme Title</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">
                    <?php foreach ($themes as $theme): ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                        <td class="px-6 py-4"><?= $theme->Theme_id ?></td>
                        <td class="px-6 py-4"><?= $theme->themeTitle ?></td>
                        <td class="px-6 py-4"><?= $theme->themeDescription ?></td>
                        <td class="px-6 py-4 flex gap-2">
                            <button
                                onclick="openEditModal(<?= $theme->Theme_id ?>, '<?= addslashes($theme->themeTitle) ?>', '<?= addslashes($theme->themeDescription) ?>')"
                                class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white font-semibold editBtn">
                                Edit
                            </button>

                            <form method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this theme?')">
                                <input type="hidden" name="delete_theme" value="1">
                                <input type="hidden" name="theme_id" value="<?= $theme->Theme_id ?>">
                                <button type="submit"
                                    class="px-3 py-1 bg-red-800 hover:bg-red-900 rounded text-white font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addThemeModal" class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-500">Add New Theme</h2>
                <button id="closeAddModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="add_theme" value="1">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Theme Title</label>
                    <input type="text" name="themeTitle" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Description</label>
                    <textarea name="themeDescription" required
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

    <div id="editThemeModal" class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-yellow-500">Edit Theme</h2>
                <button id="closeEditModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="edit_theme" value="1">
                <input type="hidden" name="theme_id" id="theme_id">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Theme Title</label>
                    <input type="text" name="themeTitle" id="themeTitle" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-yellow-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Description</label>
                    <textarea name="themeDescription" id="themeDescription" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-yellow-500"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelEditModal"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg font-semibold">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-5 py-2 bg-yellow-600 hover:bg-yellow-700 rounded-lg font-semibold text-white">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>


</body>
<script>
const addThemeModal = document.getElementById("addThemeModal");
document.getElementById("closeAddModal").addEventListener("click", () => {
    addThemeModal.classList.add("hidden");
});
document.getElementById("cancelAddModal").addEventListener("click", () => {
    addThemeModal.classList.add("hidden");
});
document.getElementById("openAddModal").addEventListener("click", () => {
    addThemeModal.classList.remove("hidden");
})


function openEditModal(themeId, title, description) {
    document.getElementById('theme_id').value = themeId;
    document.getElementById('themeTitle').value = title;
    document.getElementById('themeDescription').value = description;

    document.getElementById('editThemeModal').classList.remove('hidden');
}


document.getElementById('closeEditModal').addEventListener('click', function() {
    document.getElementById('editThemeModal').classList.add('hidden');
});

document.getElementById('cancelEditModal').addEventListener('click', function() {
    document.getElementById('editThemeModal').classList.add('hidden');
});
</script>

</html>