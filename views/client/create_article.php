<?php
require_once __DIR__ . '/../../autoload.php';
session_start();

if (!isset($_SESSION['userEmailLogin'])) {
    header("Location: login.php");
    exit();
}

$themes = (new Theme())->listThemes();
$user   = (new User())->listUserLogged($_SESSION['userEmailLogin']);
$tags   = (new Tag())->listTags();
$add_tag = new ArticleTag();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $article = new Article();
    $article->articleTitle   = trim($_POST['title']);
    $article->articleContent = trim($_POST['content']);
    $article->articleThemeId = (int) $_POST['theme'];
    $article->articleUserId  = $user->Users_Id;
    $article->media_url      = null;
    $article->articleStatus  = 'pending';

    $articleId = $article->addArticle();

    if ($articleId) {

        if (!empty($_POST['tags'])) {
            foreach ($_POST['tags'] as $tagId) {
                $add_tag->addTag($articleId, (int)$tagId);
            }
        }

        header("Location: themes.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article | MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600 flex items-center">
                <i class="fas fa-car mr-2"></i> MaBagnole
            </h1>
            <div class="hidden md:flex space-x-4 items-center">
                <div class="text-gray-700 font-medium">Welcome, <?= htmlspecialchars($user->userName); ?></div>
                <a href="dashboard.php"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">Dashboard</a>
                <a href="../logout.php"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Create a New Article</h1>

        <form method="POST" class="space-y-6">
            <div>
                <label for="title" class="block text-gray-700 font-medium">Article Title</label>
                <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-lg"
                    required>
            </div>

            <div>
                <label for="content" class="block text-gray-700 font-medium">Article Content</label>
                <textarea name="content" id="content" rows="6" class="w-full p-3 border border-gray-300 rounded-lg"
                    required></textarea>
            </div>

            <div>
                <label for="theme" class="block text-gray-700 font-medium">Select Theme</label>
                <select name="theme" id="theme" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    <?php foreach ($themes as $theme): ?>
                    <option value="<?= $theme->Theme_id ?>"><?= $theme->themeTitle ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Select Tags</label>
                <div class="mt-2 space-y-2">
                    <?php foreach ($tags as $tag): ?>
                    <label class="inline-flex items-center mr-4">
                        <input type="checkbox" name="tags[]" value="<?= $tag->Tag_id ?>" class="form-checkbox">
                        <span class="ml-2"><?= $tag->label ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>



            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Publish
                    Article</button>
            </div>
        </form>
    </div>

</body>

</html>