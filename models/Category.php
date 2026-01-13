<?php
class Category
{
    private $category_id;
    private $categoryName;
    private $descriptionCategory;

    public function __construct(
        $category_id = null,
        $categoryName = null,
        $descriptionCategory = null
    ) {
        $this->category_id = $category_id;
        $this->categoryName = $categoryName;
        $this->descriptionCategory = $descriptionCategory;
    }

    public function __get($categoryName)
    {
        return $this->$categoryName;
    }

    public function __set($categoryName, $value)
    {
        $this->$categoryName = $value;
    }

    public function __toString()
    {
        return "Category (category_id: {$this->category_id}, categoryName: {$this->categoryName})";
    }
    public function listCategory()
    {
        $database = new Database();
        $db = $database->getConnection();
        $sql = "SELECT * FROM Category";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function ajouteCategory()
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("INSERT INTO Category (categoryName,categoryDescription) values (:categoryName,:descriptionCategory)");
        $stmt->bindParam(":categoryName", $this->categoryName);
        $stmt->bindParam(":descriptionCategory", $this->descriptionCategory);

        $check = $stmt->execute();
        if ($check) {
            return 'success';
        } else {
            return "problem Conection";
        }
    }
    public function modifyCategory($id_category)
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("UPDATE Category SET  categoryName = :categoryName  , categoryDescription = :descriptionCategory WHERE Category_id = :id");
        $stmt->bindParam(":categoryName", $this->categoryName);
        $stmt->bindParam(":descriptionCategory", $this->descriptionCategory);
        $stmt->bindParam(":id", $id_category);

        $check = $stmt->execute();
        if ($check) {
            return 'success';
        } else {
            return "problem Conection";
        }
    }
    public function suppressionCategory($id_category)
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("DELETE FROM Category WHERE Category_id = :id");
        $stmt->bindParam(":id", $id_category);
        $check = $stmt->execute();
        if ($check) {
            return 'success';
        } else {
            return "problem Conection";
        }
    }
    public function countCategory()
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT COUNT(*) AS TotalCategory FROM Category";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->TotalCategory;
    }
}
