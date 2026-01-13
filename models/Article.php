<?php
class Article
{
    private $article_id;
    private $articleThemeId;
    private $articleUserId;
    private $articleTitle;
    private $articleContent;
    private $media_url;
    private $articleStatus;
    private $created_at;
    private $updated_at;

    public function __construct($article_id = null, $articleThemeId = null, $articleUserId = null, $articleTitle = null, $articleContent = null, $media_url = null, $articleStatus = null, $created_at = null, $updated_at = null)
    {
        $this->article_id = $article_id;
        $this->articleThemeId = $articleThemeId;
        $this->articleUserId = $articleUserId;
        $this->articleTitle = $articleTitle;
        $this->articleContent = $articleContent;
        $this->media_url = $media_url;
        $this->articleStatus = $articleStatus;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return "Article (article_id: {$this->article_id}, articleThemeId: {$this->articleThemeId}, articleUserId: {$this->articleUserId}, articleTitle: {$this->articleTitle}, articleStatus: {$this->articleStatus}, created_at: {$this->created_at}, updated_at: {$this->updated_at})";
    }


    public function listArticles()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT * FROM Articles a
        LEFT JOIN Themes t ON a.articleThemeId = t.Theme_id
        LEFT JOIN Users u ON a.articleUserId = u.Users_id
        LEFT JOIN Article_Tags au ON au.articleTagId = a.Article_id
        LEFT JOIN Tags tg ON tg.Tag_id = au.tagArticleId ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getArticle($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT * FROM Articles a
        LEFT JOIN Themes t ON a.articleThemeId = t.Theme_id
        LEFT JOIN Users u ON a.articleUserId = u.Users_id
        LEFT JOIN Article_Tags au ON au.articleTagId = a.Article_id
        LEFT JOIN Tags tg ON tg.Tag_id = au.tagArticleId 
        WHERE Article_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addArticle()
    {
        $db = (new DataBase)->getConnection();
        $sql = "INSERT INTO Articles (articleThemeId, articleUserId, articleTitle, articleContent, media_url, articleStatus)
            VALUES (:articleThemeId, :articleUserId, :articleTitle, :articleContent, :media_url, :articleStatus)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':articleThemeId', $this->articleThemeId);
        $stmt->bindParam(':articleUserId', $this->articleUserId);
        $stmt->bindParam(':articleTitle', $this->articleTitle);
        $stmt->bindParam(':articleContent', $this->articleContent);
        $stmt->bindParam(':media_url', $this->media_url);
        $stmt->bindParam(':articleStatus', $this->articleStatus);
        $stmt->execute();
        if ($stmt) {
            return $db->lastInsertId();;
        }
    }

    public function editArticle($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "UPDATE Articles SET articleThemeId = :articleThemeId, articleUserId = :articleUserId, articleTitle = :articleTitle,
            articleContent = :articleContent, media_url = :media_url, articleStatus = :articleStatus WHERE Article_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':articleThemeId', $this->articleThemeId);
        $stmt->bindParam(':articleUserId', $this->articleUserId);
        $stmt->bindParam(':articleTitle', $this->articleTitle);
        $stmt->bindParam(':articleContent', $this->articleContent);
        $stmt->bindParam(':media_url', $this->media_url);
        $stmt->bindParam(':articleStatus', $this->articleStatus);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) {
            return 'success';
        } else {
            return "Problem Coneection";
        }
    }

    public function deleteArticle($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "DELETE FROM Articles WHERE Article_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt) {
            return 'success';
        } else {
            return "Problem Coneection";
        }
    }
    public function updateStatusArticle($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "UPDATE Articles SET articleStatus = :articleStatus WHERE Article_id = :id";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':articleStatus', $this->articleStatus);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt) {
            return 'success';
        } else {
            return "Problem Coneection";
        }
    }
    public function paginateByTheme($themeId,  $page,  $perPage)
    {

        $db = (new DataBase)->getConnection();
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM Articles a
        LEFT JOIN Themes t ON a.articleThemeId = t.Theme_id
        LEFT JOIN Users u ON a.articleUserId = u.Users_id
        LEFT JOIN Article_Tags au ON au.articleTagId = a.Article_id
        LEFT JOIN Tags tg ON tg.Tag_id = au.tagArticleId
        WHERE a.articleThemeId = :themeid AND articleStatus = 'approved'
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':themeid', $themeId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

public function paginateByThemeAndSearch($themeId, $search, $page, $perPage)
{
    $db = (new DataBase())->getConnection();
    $offset = ($page - 1) * $perPage;

    $sql = "SELECT * FROM Articles a
            LEFT JOIN Themes t ON a.articleThemeId = t.Theme_id
            LEFT JOIN Users u ON a.articleUserId = u.Users_id
            LEFT JOIN Article_Tags au ON au.articleTagId = a.Article_id
            LEFT JOIN Tags tg ON tg.Tag_id = au.tagArticleId
            WHERE a.articleThemeId = :themeId 
              AND a.articleStatus = 'approved' 
              AND a.articleTitle LIKE :search
            ORDER BY a.created_at DESC
            LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':themeId', $themeId, PDO::PARAM_INT);
    $stmt->bindValue(':search', "%$search%");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


public function paginateByThemeAndTag($themeId, $tag, $page, $perPage)
{
    $db = (new DataBase())->getConnection();
    $offset = ($page - 1) * $perPage;

    $sql = "SELECT *
            FROM Articles a
            LEFT JOIN Themes t ON a.articleThemeId = t.Theme_id
            LEFT JOIN Users u ON a.articleUserId = u.Users_id
            LEFT JOIN Article_Tags au ON au.articleTagId = a.Article_id
            LEFT JOIN Tags tg ON tg.Tag_id = au.tagArticleId
            WHERE a.articleThemeId = :themeId 
              AND a.articleStatus = 'approved'
              AND tg.label = :tag
            ORDER BY a.created_at DESC
            LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':themeId', $themeId, PDO::PARAM_INT);
    $stmt->bindValue(':tag', $tag);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


    public function countByTheme($themeId)
    {
        $db = (new DataBase())->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as totalByTheme FROM Articles WHERE articleThemeId = :themeId");
        $stmt->bindParam(':themeId', $themeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(pdo::FETCH_OBJ);
    }

public function countByThemeAndSearch($themeId, $search)
{
    $db = (new DataBase())->getConnection();
    
    $stmt = $db->prepare(
        "SELECT COUNT(*) AS totalByThemeAndSearch 
         FROM Articles 
         WHERE articleThemeId = :themeId 
           AND articleTitle LIKE :search"
    );

    $stmt->bindValue(':themeId', $themeId, PDO::PARAM_INT);
    $stmt->bindValue(':search', "%$search%");
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_OBJ);
}


public function countByThemeAndTag($themeId, $tag)
{
    $db = (new DataBase())->getConnection();

    $stmt = $db->prepare(
        "SELECT COUNT(*) AS totalByThemeAndTag
         FROM Articles a
         JOIN Article_Tags au ON a.Article_id = au.articleTagId
         JOIN Tags tg ON tg.Tag_id = au.tagArticleId
         WHERE a.articleThemeId = :themeId AND tg.label = :tag"
    );

    $stmt->bindValue(':themeId', $themeId, PDO::PARAM_INT);
    $stmt->bindValue(':tag', $tag);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_OBJ);
}





    public function countArticles()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT COUNT(*) FROM Articles  ;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(pdo::FETCH_OBJ);
    }
}