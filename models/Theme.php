<?php class Theme
{
    private $Theme_id;
    private $themeTitle;
    private $themeDescription;

    public function __construct($Theme_id = null, $themeTitle = null, $themeDescription = null)
    {
        $this->Theme_id = $Theme_id;
        $this->themeTitle = $themeTitle;
        $this->themeDescription = $themeDescription;
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
        return "Theme (Theme_id: {$this->Theme_id}, themeTitle: {$this->themeTitle}, themeDescription: {$this->themeDescription})";;
    }


    public function listThemes()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT * FROM Themes";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addTheme()
    {
        $db = (new DataBase)->getConnection();
        $sql = "INSERT INTO
                Themes (themeTitle, themeDescription)
                VALUES (:themeTitle,:themeDescription)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":themeTitle", $this->themeTitle);
        $stmt->bindParam(":themeDescription", $this->themeDescription);
        $stmt->execute();
        if ($stmt) {
            return 'success';
        } else {
            return "Problem Coneection";
        }
    }
    public function getTheme($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT * FROM Themes WHERE Theme_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function editTheme($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "UPDATE Themes SET themeTitle = :title, themeDescription = :description WHERE Theme_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $this->themeTitle);
        $stmt->bindParam(':description', $this->themeDescription);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt) {
            return 'success';
        } else {
            return "Problem Coneection";
        }
    }

    public function deleteTheme($id)
    {
        $db = (new DataBase)->getConnection();
        $sql = "DELETE FROM Themes WHERE Theme_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt) {
            return 'success';
        } else {
            return "Problem Coneection";
        }
    }
        public function countThemes()
    {
        $db = (new DataBase)->getConnection();
        $sql = "SELECT COUNT(*) AS totalCount FROM Themes  ;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(pdo::FETCH_OBJ);
    }
}