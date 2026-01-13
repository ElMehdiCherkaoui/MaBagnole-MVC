<?php
class ArticleTag
{
    private $Article_Tag_Id;
    private $articleTagId;
    private $tagArticleId;

    public function __construct($articleTagId = null, $tagArticleId = null)
    {
        $this->articleTagId = $articleTagId;
        $this->tagArticleId = $tagArticleId;
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
        return "ArticleTag (articleTagId: {$this->articleTagId}, tagArticleId: {$this->tagArticleId})";
    }

    public function addTag($articleId, $tagId)
    {
        $db = (new DataBase())->getConnection();
        $sql = "INSERT INTO Article_Tags (articleTagId, tagArticleId) VALUES (:articleId, :tagId)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':articleId', $articleId);
        $stmt->bindParam(':tagId', $tagId);
        $stmt->execute();
    }

    public function detachTags() {}
    public function listArticlesByTag($tagId) {}
    public function listTagsByArticle($articleId) {}
}