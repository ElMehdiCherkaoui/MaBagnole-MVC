<?php
require_once __DIR__ . '/../../autoload.php';
session_start();

if (!isset($_SESSION['userEmailLogin'])) {
    header("Location: login.php");
    exit();
}

$user = (new User)->listUserLogged($_SESSION['userEmailLogin']);

$articleId = isset($_POST['articlesId']);

$article = (new Article())->getArticle($articleId);

$fav = new FavoriteArticle();
$commentModel = new Comment();

$isFavorite = $fav->isFavorite($user->Users_id, $articleId);
$comments = $commentModel->listByArticle($articleId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['Delete_Id']) && !empty($_POST['Delete_Id'])) {
        $comment = new Comment();
        $comment->softDeleteComment((int)$_POST['Delete_Id']);
        $comments = $commentModel->listByArticle($articleId);
    }

    if (isset($_POST['add_comment']) && !empty($_POST['content'])) {
        $comment = new Comment();
        $comment->commentArticleId = $articleId;
        $comment->commentUserId = $user->Users_id;
        $comment->commentContent = trim($_POST['content']);
        $comment->addComment();
        header("Location: article_detail.php?articlesId=" . $articleId);
        exit();
    }

    if (isset($_POST['edit_comment_submit']) && !empty($_POST['contentEdit']) && !empty($_POST['comment_id'])) {
        $comment = new Comment();
        $comment->commentContent = trim($_POST['contentEdit']);
        $comment->editComment((int)$_POST['comment_id']);
    }

    if (isset($_POST['add_favorite'])) {
        $favorite = new FavoriteArticle(null, $user->Users_id, $articleId, null);
        $favorite->addFavorite();
        $isFavorite = $fav->isFavorite($user->Users_id, $articleId);
    }

    if (isset($_POST['remove_favorite'])) {
        $favorite = new FavoriteArticle(null, $user->Users_id, $articleId, null);
        $favorite->removeFavorite($articleId);
        $isFavorite = $fav->isFavorite($user->Users_id, $articleId);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Details | MaBagnole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600 flex items-center">
                <i class="fas fa-car mr-2"></i> MaBagnole
            </h1>

            <div class="hidden md:flex space-x-4 items-center">
                <div class="text-gray-700 font-medium">Welcome, <?= htmlspecialchars($user->userName);  ?></div>
                <a href="dashboard.php"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">Dashboard</a>
                <a href="../logout.php"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <h2 class="text-3xl font-semibold text-gray-800"><?= $article->articleTitle ?></h2>
            <p class="mt-2 text-gray-600">By <?= $article->userName ?> | Published on <?= $article->updated_at ?></p>


            <div class="mt-4">
                <form method="POST" action="article_detail.php">
                    <input type="hidden" name="article_id" value="<?= $user->Users_Id ?>">
                    <input type="hidden" name="articlesId" value="<?= $_POST['articlesId'] ?>">
                    <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">

                    <?php if ($isFavorite): ?>
                    <button type="submit" name="remove_favorite" class="text-gray-500 hover:text-gray-700 text-lg">
                        <i class="far fa-heart"></i> Remove from Favorites
                    </button>
                    <?php else: ?>
                    <button type="submit" name="add_favorite" class="text-red-500 hover:text-red-600 text-lg">
                        <i class="fas fa-heart"></i> Add to Favorites
                    </button>
                    <?php endif; ?>
                </form>
            </div>


            <div class="mt-6 text-gray-800">
                <p><?= $article->articleContent ?></p>
            </div>

            <div class="mt-6">
                <form method="post" action="articles.php">
                    <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">
                    <button type="submit" class="text-blue-500 hover:text-blue-700">Back to Articles List</button>
                </form>
            </div>

            <div class="mt-8">
                <?php foreach ($comments as $comment): ?>
                <div class="mt-4 p-4 bg-gray-50 rounded-lg border">

                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800">
                            <?= htmlspecialchars($comment->userName) ?>
                        </span>

                        <span class="text-sm text-gray-500">
                            <?= date('d M Y H:i', strtotime($comment->commentCreatedAt)) ?>
                        </span>
                    </div>

                    <p class="mt-2 text-gray-700">
                        <?= nl2br(htmlspecialchars($comment->commentContent)) ?>
                    </p>


                    <?php if ($comment->commentUserId == $user->Users_id): ?>
                    <div class="mt-3 flex gap-3">


                        <input type="hidden" name="comment_id" value="<?= $comment->Comment_id ?>">
                        <button
                            onclick="openEditPopup(<?= $comment->Comment_id ?>,`<?= htmlspecialchars($comment->commentContent) ?>`)"
                            class="text-blue-600 text-sm hover:underline">
                            Edit
                        </button>



                        <form method="POST" onsubmit="return confirm('Delete this comment?');">
                            <input type="hidden" name="Delete_Id" value="<?= (int)$comment->Comment_id ?>">
                            <input type="hidden" name="articlesId" value="<?= $_POST['articlesId'] ?>">
                            <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">
                            <button class="text-red-600 hover:underline text-sm">
                                Delete
                            </button>
                        </form>

                    </div>
                    <?php endif; ?>

                </div>
                <?php endforeach; ?>


                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-800">Add a Comment</h4>

                    <form method="POST" action="article_detail.php" class="mt-4">
                        <textarea name="comment" rows="4" class="w-full p-3 border border-gray-300 rounded-lg"
                            placeholder="Write your comment here..." required></textarea>

                        <input type="hidden" name="articlesId" value="<?= $_POST['articlesId'] ?>">
                        <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">

                        <button type="submit" name="add_comment"
                            class="w-full mt-4 bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">
                            Post Comment
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
    <div id="editPopup" class="flex fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Edit Comment</h3>

            <form method="POST">

                <input type="hidden" name="edit_comment_submit" id="1">
                <input type="hidden" name="comment_id" id="editCommentId">
                <input type="hidden" name="articlesId" value="<?= $_POST['articlesId'] ?>">
                <input type="text" hidden name="themeId" value="<?= $_POST['themeId'] ?>">

                <textarea name="contentEdit" id="editCommentContent" class="w-full border rounded p-3" rows="4"
                    required></textarea>

                <div class="mt-4 flex justify-end gap-3">
                    <button type="button" onclick="closeEditPopup()" class="px-4 py-2 border rounded">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
<script>
function openEditPopup(commentId, content) {
    document.getElementById('editCommentId').value = commentId;
    document.getElementById('editCommentContent').value = content;

    document.getElementById('editPopup').classList.remove('hidden');
}

function closeEditPopup() {
    document.getElementById('editPopup').classList.add('hidden');

}
</script>

</html>