<?php
class Tag
{
    private $tag_id;
    private $label;

    public function __construct($tag_id = null, $label = null)
    {
        $this->tag_id = $tag_id;
        $this->label = $label;
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
        return "Tag (tag_id: {$this->tag_id}, label: {$this->label})";
    }

    public function listTags()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT * FROM Tags ORDER BY Tag_id ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addTag($label)
    {
        $db = (new DataBase)->getConnection();
        $sql = "INSERT INTO Tags (label) VALUES (:label)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':label', $label);
        return $stmt->execute();
    }

    public function editTag($id, $label)
    {
        $db = (new DataBase)->getConnection();
        $sql = "UPDATE Tags SET label = :label WHERE Tag_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':label', $label);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteTag($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "DELETE FROM Tags WHERE Tag_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
            public function countTags()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT COUNT(*) AS totalCount FROM Tags;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(pdo::FETCH_OBJ);
    }
}