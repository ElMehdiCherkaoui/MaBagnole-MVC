<?php
class Comment
{
    private $comment_id;
    private $commentArticleId;
    private $commentUserId;
    private $commentContent;
    private $commentCreatedAt;
    private $commentDeletedAt;

    public function __construct($comment_id = null, $commentArticleId = null, $commentUserId = null, $commentContent = null, $commentCreatedAt = null, $commentDeletedAt = null)
    {
        $this->comment_id = $comment_id;
        $this->commentArticleId = $commentArticleId;
        $this->commentUserId = $commentUserId;
        $this->commentContent = $commentContent;
        $this->commentCreatedAt = $commentCreatedAt;
        $this->commentDeletedAt = $commentDeletedAt;
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
        return "Comment (comment_id: {$this->comment_id}, commentArticleId: {$this->commentArticleId}, commentUserId: {$this->commentUserId}, commentCreatedAt: {$this->commentCreatedAt}, commentDeletedAt: {$this->commentDeletedAt})";
    }

    public function listAll()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT * FROM Comments c
        LEFT JOIN Articles a ON c.commentArticleId = a.Article_id
        LEFT JOIN Users u ON c.commentUserId = u.Users_id
        WHERE c.commentDeletedAt IS NULL
        ORDER BY c.commentCreatedAt DESC
    ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listByArticle($articleId)
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT *
        FROM Comments c
        LEFT JOIN Users u ON c.commentUserId = u.Users_id
        LEFT JOIN Articles a ON c.commentArticleId = a.Article_id
        WHERE c.commentArticleId = :articleId
          AND c.commentDeletedAt IS NULL
        ORDER BY c.commentCreatedAt DESC
    ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':articleId', $articleId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addComment()
    {
        $db = (new DataBase)->getConnection();
        $sql = "
        INSERT INTO Comments (commentArticleId, commentUserId, commentContent)
        VALUES (:articleId, :userId, :content)
    ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':articleId', $this->commentArticleId);
        $stmt->bindParam(':userId', $this->commentUserId);
        $stmt->bindParam(':content', $this->commentContent);
        return $stmt->execute();
    }


    public function editComment($commentId)
    {
        $db = (new DataBase)->getConnection();
        $sql = "UPDATE Comments
        SET commentContent = :content
        WHERE Comment_id = :commentId
          AND commentDeletedAt IS NULL
    ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':content', $this->commentContent);
        $stmt->bindParam(':commentId', $commentId);
        return $stmt->execute();
    }
    public function softDeleteComment($commentId)
    {
        $db = (new DataBase)->getConnection();
        $sql = "UPDATE Comments
        SET commentDeletedAt = NOW()
        WHERE Comment_id = :commentId
    ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':commentId', $commentId);
        return $stmt->execute();
    }
    public function countAll()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT COUNT(*) AS totalCountComment FROM Comments WHERE commentDeletedAt IS NULL ;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(pdo::FETCH_OBJ);
    }
}