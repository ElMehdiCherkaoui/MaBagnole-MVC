<?php
class FavoriteArticle
{
    private $favorite_id;
    private $favoriteArticleUserId;
    private $favoriteArticleId;
    private $favoriteArticleCreatedAt;

    public function __construct($favorite_id = null, $favoriteArticleUserId = null, $favoriteArticleId = null, $favoriteArticleCreatedAt = null)
    {
        $this->favorite_id = $favorite_id;
        $this->favoriteArticleUserId = $favoriteArticleUserId;
        $this->favoriteArticleId = $favoriteArticleId;
        $this->favoriteArticleCreatedAt = $favoriteArticleCreatedAt;
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
        return "FavoriteArticle (favorite_id: {$this->favorite_id}, favoriteArticleUserId: {$this->favoriteArticleUserId}, favoriteArticleId: {$this->favoriteArticleId}, favoriteArticleCreatedAt: {$this->favoriteArticleCreatedAt})";
    }

    public function addFavorite()
    {
        $db = (new DataBase())->getConnection();

        $sql = "
        INSERT INTO Favorite_Articles (favoriteArticleUserId, favoriteArticleId)
        VALUES (:userId, :articleId)
    ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userId', $this->favoriteArticleUserId);
        $stmt->bindParam(':articleId', $this->favoriteArticleId);

        return $stmt->execute();
    }

    public function removeFavorite($articleId)
    {
        $db = (new DataBase())->getConnection();

        $sql = "
        DELETE FROM Favorite_Articles
        WHERE favoriteArticleUserId = :userId
          AND favoriteArticleId = :articleId
    ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userId', $this->favoriteArticleUserId);
        $stmt->bindParam(':articleId', $articleId);

        return $stmt->execute();
    }
public function isFavorite($userId, $articleId)
{
    $db = (new DataBase())->getConnection();

    $sql = "
        SELECT favorite_id
        FROM Favorite_Articles
        WHERE favoriteArticleUserId = :userId
          AND favoriteArticleId = :articleId
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':articleId', $articleId);
    $stmt->execute();

    return $stmt->fetch() !== false;
}

    public function listFavoritesByUser($userId) {}
}