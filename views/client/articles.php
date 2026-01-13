<?php
require_once __DIR__ . '/../../autoload.php';
session_start();

$articles = (new Article())->listArticles();
if (!isset($_SESSION['userEmailLogin'])) {
    header("Location: login.php");
    exit();
}

$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);


if (isset($_POST['themeId'])) {

    $page = $_POST['page'] ?? 1;
    $perPage = $_POST['perPage'] ?? 5;
    $page = (int)$page;
    $perPage = (int)$perPage;
    $articleModel = new Article();

    if (!empty($_POST['search'])) {
        $rows = $articleModel->paginateByThemeAndSearch($_POST['themeId'], $_POST['search'], $page, $perPage);
        $totalArticle = $articleModel->countByThemeAndSearch($_POST['themeId'], $_POST['search']);
        $totalArticles = (int)  $totalArticle->totalByThemeAndSearch;
    } elseif (!empty($_POST['tag'])) {
        $rows = $articleModel->paginateByThemeAndTag($_POST['themeId'], $_POST['tag'], $page, $perPage);
        $totalArticle = $articleModel->countByThemeAndTag($_POST['themeId'], $_POST['tag']);
        $totalArticles = (int)  $totalArticle->totalByThemeAndTag;
    } else {
        $rows = $articleModel->paginateByTheme($_POST['themeId'], $page, $perPage);
        $totalArticle = $articleModel->countByTheme($_POST['themeId']);
        $totalArticles = (int) $totalArticle->totalByTheme;
    }


    $groupedArticles = [];

    foreach ($rows as $row) {
        $id = $row->Article_id;

        if (!isset($groupedArticles[$id])) {
            $groupedArticles[$id] = [
                'id' => $id,
                'title' => $row->articleTitle,
                'content' => $row->articleContent,
                'author' => $row->Users_id,
                'tags' => []
            ];
        }

        if (!empty($row->label)) {
            $groupedArticles[$id]['tags'][] = $row->label;
        }
    }


    $totalPages = ceil($totalArticles / $perPage);
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles | MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600 flex items-center">
                <i class="fas fa-car mr-2"></i> MaBagnole
            </h1>
            <div class="hidden md:flex space-x-4 items-center">
                <div class="text-gray-700 font-medium">Welcome, User</div>
                <a href="dashboard.php"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">Dashboard</a>
                <a href="../logout.php"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <h2 class="text-2xl font-semibold text-gray-800">Articles</h2>
            <p class="mt-2 text-gray-600">Explore articles and discussions related to your selected theme.</p>

            <div class="flex items-center mt-4 mb-6 space-x-4">
                <form method="POST" class="flex flex-wrap gap-4 items-center">
                    <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">


                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-filter"></i> Filter
                    </button>

                    <select name="tag" class="w-48 p-3 border border-gray-300 rounded-lg">
                        <option value="">Select a Tag</option>
                        <?php foreach ($articles as $tags): ?>
                        <option value="<?= $tags->label  ?>"><?= $tags->label  ?></option>
                        <?php endforeach ?>
                    </select>

                    <input type="text" name="search" class="w-full p-3 border border-gray-300 rounded-lg"
                        placeholder="Search for articles by title...">

                </form>

            </div>

            <div class="mt-6 space-y-6">

                <?php foreach ($groupedArticles as $article): ?>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">

                    <h3 class="text-xl font-semibold text-blue-600 hover:text-blue-800 cursor-pointer">
                        <form action="article_detail.php" method="POST">
                            <input type="hidden" name="articlesId" value="<?= $article['id'] ?>">
                            <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">
                            <button type="submit">
                                <?= htmlspecialchars($article['title']) ?>
                            </button>
                        </form>
                    </h3>

                    <p class="mt-2 text-gray-600">
                        <?= htmlspecialchars(substr($article['content'], 0, 120)) ?>...
                    </p>

                    <div class="mt-4">
                        <span class="text-sm font-semibold text-gray-700">Tags: </span>

                        <?php foreach ($article['tags'] as $tag): ?>
                        <span class="inline-block bg-blue-600 text-white px-3 py-1 rounded-full text-xs mr-2">
                            <?= htmlspecialchars($tag) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            By <?= htmlspecialchars($article['author']) ?>
                        </span>
                        <form action="article_detail.php" method="POST">
                            <input type="hidden" name="articlesId" value="<?= $article['id'] ?>">
                            <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">
                            <button type="submit" class="text-blue-600 hover:text-blue-800">
                                Read More
                            </button>
                        </form>
                    </div>

                </div>
                <?php endforeach; ?>

            </div>


            <div class="mt-8">
                <nav aria-label="Page navigation example" class="flex items-center space-x-4 overflow-x-auto">
                    <ul class="flex -space-x-px text-sm">

                        <?php if ($page > 1): ?>
                        <li>
                            <form method="POST">
                                <input type="hidden" name="themeId" value="<?= $_POST['themeId'] ?? '' ?>">
                                <input type="hidden" name="page" value="<?= $page - 1 ?>">
                                <input type="hidden" name="perPage" value="<?= $perPage ?>">
                                <button
                                    class="flex items-center justify-center text-body bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading shadow-xs font-medium leading-5 rounded-s-base text-sm px-3 h-9 focus:outline-none">
                                    Previous
                                </button>
                            </form>
                        </li>
                        <?php endif; ?>

                        <?php
                        $start = 1;
                        $end = $totalPages;

                        for ($i = $start; $i <= $end; $i++):
                        ?>
                        <li>
                            <form method="POST">
                                <input type="hidden" name="themeId" value="<?= $_POST['themeId'] ?? '' ?>">
                                <input type="hidden" name="page" value="<?= $i ?>">
                                <input type="hidden" name="perPage" value="<?= $perPage ?>">
                                <button
                                    class="flex items-center justify-center text-sm w-9 h-9 font-medium border border-default-medium shadow-xs focus:outline-none text-fg-brand bg-neutral-tertiary-medium">
                                    <?= $i ?>
                                </button>
                            </form>
                        </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                        <li>
                            <form method="POST">
                                <input type="hidden" name="themeId" value="<?= $_POST['themeId'] ?? '' ?>">
                                <input type="hidden" name="page" value="<?= $page + 1 ?>">
                                <input type="hidden" name="perPage" value="<?= $perPage ?>">
                                <button
                                    class="flex items-center justify-center text-body bg-neutral-secondary-medium border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading shadow-xs font-medium leading-5 rounded-e-base text-sm px-3 h-9 focus:outline-none">
                                    Next
                                </button>
                            </form>
                        </li>
                        <?php endif; ?>

                    </ul>

                    <form method="POST" class="w-32 mx-auto">
                        <input type="hidden" name="themeId" value="<?= $_POST['themeId'] ?? '' ?>">
                        <input type="hidden" name="page" value="1">
                        <select name="perPage" onchange="this.form.submit()"
                            class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm leading-4 rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                            <option value="5" <?= $perPage == 5 ? 'selected' : '' ?>>5 per page</option>
                            <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10 per page</option>
                            <option value="15" <?= $perPage == 15 ? 'selected' : '' ?>>15 per page</option>
                            <option value="25" <?= $perPage == 25 ? 'selected' : '' ?>>25 per page</option>
                            <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50 per page</option>
                        </select>
                    </form>
                </nav>

            </div>

        </div>
    </div </body>

</html>