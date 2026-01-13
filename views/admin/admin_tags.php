<?php
require_once __DIR__ . '/../../autoload.php';

$Tag = new Tag();
$tags = $Tag->listTags();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tag'])) {

    $label = $_POST['label'];

    $result = $Tag->addTag($label);

    if ($result) {
        header('Location: admin_tags.php');
        exit;
    } else {
        echo "Error while adding tag";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_tag'])) {

    $label = $_POST['label'];
    $id    = $_POST['tag_id'];

    $result = $Tag->editTag($id, $label);

    if ($result) {
        header('Location: admin_tags.php');
        exit;
    } else {
        echo "Error while editing tag";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_tag'])) {

    $id = $_POST['tag_id'];

    $result = $Tag->deleteTag($id);

    if ($result) {
        header('Location: admin_tags.php');
        exit;
    } else {
        echo "Error while deleting tag";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Tags | MaBagnole Admin</title>
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
                class="block px-4 py-3 rounded-lg text-red-500 font-semibold hover:bg-red-900 hover:text-white transition flex items-center">
                <i class="fas fa-star mr-2"></i> Reviews
            </a>
            <a href="admin_tags.php"
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
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
            <i class="fas fa-tags mr-3"></i> Manage Tags
        </h1>

        <div class="mb-6">
            <button id="openAddTagModal"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Tag
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-xl border border-gray-700">
                <thead>
                    <tr class="text-left text-gray-300 border-b border-gray-700">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Tag Name</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>

                <tbody class="text-gray-100">
                    <?php foreach ($tags as $tag): ?>
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                        <td class="px-6 py-4"><?= $tag->Tag_id ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($tag->label) ?></td>

                        <td class="px-6 py-4 flex gap-2">
                            <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 rounded text-white font-semibold"
                                onclick="openEditTagModal(<?= $tag->Tag_id ?>, '<?= htmlspecialchars($tag->label) ?>')">
                                Edit
                            </button>


                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this tag?')">
                                <input type="hidden" name="tag_id" value="<?= $tag->Tag_id ?>">
                                <button type="submit" name="delete_tag"
                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white font-semibold">
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

    <div id="addTagModal" class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-500">Add New Tag</h2>
                <button id="closeAddTagModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="admin_tags.php" class="space-y-4">
                <input type="hidden" name="add_tag" value="1">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Tag Name</label>
                    <input type="text" name="label" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelAddTagModal"
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

    <div id="editTagModal" class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">

        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-blue-500">Edit Tag</h2>
                <button id="closeEditTagModal" class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" action="admin_tags.php" class="space-y-4">
                <input type="hidden" name="edit_tag" value="1">
                <input type="hidden" name="tag_id" id="edit_tag_id">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Tag Name</label>
                    <input type="text" name="label" id="edit_tag_label" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-blue-500">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelEditTagModal"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg font-semibold">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold text-white">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>


</body>
<script>
const addTagModal = document.getElementById('addTagModal');
const closeAddTagModal = document.getElementById('closeAddTagModal');
const cancelAddTagModal = document.getElementById('cancelAddTagModal');
const openAddTagModal = document.getElementById("openAddTagModal");

function AddTagModal() {
    addTagModal.classList.remove('hidden');
}

function closeAddModal() {
    addTagModal.classList.add('hidden');
}
openAddTagModal.addEventListener('click', AddTagModal);
closeAddTagModal.addEventListener('click', closeAddModal);
cancelAddTagModal.addEventListener('click', closeAddModal);


const editTagModal = document.getElementById('editTagModal');
const closeEditTagModal = document.getElementById('closeEditTagModal');
const cancelEditTagModal = document.getElementById('cancelEditTagModal');

const editTagIdInput = document.getElementById('edit_tag_id');
const editTagLabelInput = document.getElementById('edit_tag_label');

function openEditTagModal(tagId, label) {
    editTagIdInput.value = tagId;
    editTagLabelInput.value = label;
    editTagModal.classList.remove('hidden');
}

function closeEditModal() {
    editTagModal.classList.add('hidden');
}

closeEditTagModal.addEventListener('click', closeEditModal);
cancelEditTagModal.addEventListener('click', closeEditModal);
</script>

</html>