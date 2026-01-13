<?php
require_once __DIR__ . '/../../autoload.php';
$article = new Article();
$articles = $article->listArticles();

$Theme = new Theme();
$themes = $Theme->listThemes();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_article'])) {
    $article->articleThemeId = $_POST['articleThemeId'];
    $article->articleUserId = $_POST['articleUserId'];
    $article->articleTitle = $_POST['articleTitle'];
    $article->articleContent = $_POST['articleContent'];
    $article->media_url = $_POST['media_url'];
    $article->articleStatus = $_POST['articleStatus'];

    $result = $article->addArticle();

    if ($result === 'success') {
        header('Location: admin_articles.php');
        exit;
    } else {
        echo $result;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_article'])) {
    $article->articleThemeId = $_POST['articleThemeId'];
    $article->articleUserId = $_POST['articleUserId'];
    $article->articleTitle = $_POST['articleTitle'];
    $article->articleContent = $_POST['articleContent'];
    $article->media_url = $_POST['media_url'];
    $article->articleStatus = $_POST['articleStatus'];
    $id = $_POST['article_id'];

    $result = $article->editArticle($id);

    if ($result === 'success') {
        header('Location: admin_articles.php');
        exit;
    } else {
        echo $result;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article'])) {

    $id = $_POST['article_id'];

    $result = $article->deleteArticle($id);

    if ($result === 'success') {
        header('Location: admin_articles.php');
        exit;
    } else {
        echo $result;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateStatus'])) {
    $article->articleStatus = $_POST['articleStatus'];
    $id = $_POST['article_id'];

    $result = $article->updateStatusArticle($id);

    if ($result === 'success') {
        header('Location: admin_articles.php');
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
    <title>Manage Articles | MaBagnole Admin</title>
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
                class="block px-4 py-3 rounded-lg text-white bg-red-700 font-semibold transition flex items-center">
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
            <i class="fas fa-newspaper mr-3"></i> Manage Articles
        </h1>

        <div class="mb-6">
            <button id="openAddArticleModal"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Article
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 rounded-xl border border-gray-700">
                <thead>
                    <tr class="text-left text-gray-300 border-b border-gray-700">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Article Title</th>
                        <th class="px-6 py-3">Author</th>
                        <th class="px-6 py-3">Theme</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-100">
                    <?php foreach ($articles as $article): ?>
                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                            <td class="px-6 py-4"><?= $article->Article_id ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($article->articleTitle) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($article->userName) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($article->themeTitle) ?></td>

                            <td class="px-6 py-4">
                                <?php
                                $status = strtolower($article->articleStatus ?? '');
                                $badgeClass = 'bg-yellow-500';
                                if ($status === 'approved' || $status === 'published') $badgeClass = 'bg-green-600';
                                elseif ($status === 'rejected') $badgeClass = 'bg-red-600';
                                elseif ($status === 'pending') $badgeClass = 'bg-yellow-500';
                                ?>
                                <span class="px-3 py-1 <?= $badgeClass ?> text-white rounded-full text-sm">
                                    <?= htmlspecialchars($article->articleStatus) ?>
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">


                                    <button type="button" onclick="openEditArticleModal(
                    <?= (int)$article->Article_id ?>,
                    '<?= $article->articleTitle ?>',
                    '<?= $article->articleContent ?>',
                    '<?= $article->media_url ?>',
                    '<?= $article->articleStatus ?>',
                    <?= (int)($article->articleThemeId) ?>
                )" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 rounded text-white font-semibold">
                                        Edit
                                    </button>

                                    <?php if ($article->articleStatus === 'pending'): ?>
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="updateStatus" value="1">
                                            <input type="hidden" name="article_id" value="<?= (int)$article->Article_id ?>">
                                            <input type="hidden" name="articleStatus" value="approved">
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-white font-semibold">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" class="inline">
                                            <input type="hidden" name="updateStatus" value="1">
                                            <input type="hidden" name="article_id" value="<?= (int)$article->Article_id ?>">
                                            <input type="hidden" name="articleStatus" value="rejected">
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 hover:bg-red-700 rounded text-white font-semibold">
                                                Reject
                                            </button>
                                        </form>
                                    <?php endif; ?>


                                    <form method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this article?')">
                                        <input type="hidden" name="delete_article" value="1">
                                        <input type="hidden" name="article_id" value="<?= (int)$article->Article_id ?>">
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-800 hover:bg-red-900 rounded text-white font-semibold">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </main>

    <div id="addArticleModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-red-500">Add New Article</h2>
                <button id="closeAddArticleModal" type="button"
                    class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="add_article" value="1">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Article Title</label>
                    <input type="text" name="articleTitle" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Content</label>
                    <textarea name="articleContent" required rows="5"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500"></textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Media URL (optional)</label>
                    <input type="text" name="media_url"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Status</label>
                    <select name="articleStatus" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                        <option value="pending">pending</option>
                        <option value="approved">approved</option>
                        <option value="rejected">rejected</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Theme</label>
                    <select name="articleThemeId" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                        <option value="" disabled selected>Select a theme</option>

                        <?php foreach ($themes as $theme): ?>
                            <option value="<?= (int)$theme->Theme_id ?>">
                                <?= htmlspecialchars($theme->themeTitle) ?> (ID: <?= (int)$theme->Theme_id ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div>
                    <label class="block mb-1 text-sm font-semibold">User ID</label>
                    <input type="number" name="articleUserId" value="1" required class=" w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white
                        focus:outline-none focus:border-red-500">
                </div>

                <div class="flex justify-end gap3">
                    <button type="button" id="cancelAddArticleModal"
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

    <div id="editArticleModal"
        class="flex fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 ">
        <div class="bg-gray-900 w-full max-w-md rounded-xl border border-gray-700 p-6
         max-h-[40em] overflow-auto
         [&::-webkit-scrollbar]:w-2
         [&::-webkit-scrollbar-track]:bg-gray-800
         [&::-webkit-scrollbar-thumb]:bg-gray-600
         [&::-webkit-scrollbar-thumb]:rounded-lg
         [&::-webkit-scrollbar-thumb:hover]:bg-gray-500">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-yellow-500">Edit Article</h2>
                <button id="closeEditArticleModal" type="button"
                    class="text-gray-400 hover:text-white text-xl">&times;</button>
            </div>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="edit_article" value="1">
                <input type="hidden" name="article_id" id="edit_article_id">

                <div>
                    <label class="block mb-1 text-sm font-semibold">Article Title</label>
                    <input type="text" name="articleTitle" id="edit_articleTitle" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-yellow-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Content</label>
                    <textarea name="articleContent" id="edit_articleContent" required rows="5"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-yellow-500"></textarea>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Media URL (optional)</label>
                    <input type="text" name="media_url" id="edit_media_url"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-yellow-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold">Status</label>
                    <select name="articleStatus" id="edit_articleStatus" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-yellow-500">
                        <option value="pending">pending</option>
                        <option value="approved">approved</option>
                        <option value="rejected">rejected</option>
                    </select>
                </div>


                <div>
                    <label class="block mb-1 text-sm font-semibold">Theme</label>
                    <select name="articleThemeId" id="edit_articleThemeId" required
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-red-500">
                        <option value="" disabled selected>Select a theme</option>

                        <?php foreach ($themes as $theme): ?>
                            <option value="<?= (int)$theme->Theme_id ?>">
                                <?= htmlspecialchars($theme->themeTitle) ?> (ID: <?= (int)$theme->Theme_id ?>)
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>



                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelEditArticleModal"
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
    const addArticleModal = document.getElementById("addArticleModal");
    const editArticleModal = document.getElementById("editArticleModal");

    document.getElementById("openAddArticleModal").addEventListener("click", () => {
        addArticleModal.classList.remove("hidden");
    });
    document.getElementById("closeAddArticleModal").addEventListener("click", () => {
        addArticleModal.classList.add("hidden");
    });
    document.getElementById("cancelAddArticleModal").addEventListener("click", () => {
        addArticleModal.classList.add("hidden");
    });

    document.getElementById("closeEditArticleModal").addEventListener("click", () => {
        editArticleModal.classList.add("hidden");
    });
    document.getElementById("cancelEditArticleModal").addEventListener("click", () => {
        editArticleModal.classList.add("hidden");
    });


    function openEditArticleModal(id, title, content, mediaUrl, status, themeId, userId) {
        document.getElementById("edit_article_id").value = id;
        document.getElementById("edit_articleTitle").value = title || "";
        document.getElementById("edit_articleContent").value = content || "";
        document.getElementById("edit_media_url").value = mediaUrl || "";
        document.getElementById("edit_articleStatus").value = status || "pending";

        document.getElementById("edit_articleThemeId").value = themeId;

        document.getElementById("editArticleModal").classList.remove("hidden");
    }
</script>


</html>