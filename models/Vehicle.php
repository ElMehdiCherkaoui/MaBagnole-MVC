<?php
class Vehicle
{
    private $Vehicle_id;
    private $vehicleImage;
    private $vehicleModel;
    private $vehicleDescription;
    private $vehiclePricePerDay;
    private $vehicleAvailability;
    private $vehicleIdCategory;

    public function __construct(
        $Vehicle_id = null,
        $vehicleImage = null,
        $vehicleModel = null,
        $vehicleDescription = null,
        $vehiclePricePerDay = null,
        $vehicleAvailability = null,
        $vehicleIdCategory = null
    ) {
        $this->Vehicle_id = $Vehicle_id;
        $this->vehicleImage = $vehicleImage;
        $this->vehicleModel = $vehicleModel;
        $this->vehicleDescription = $vehicleDescription;
        $this->vehiclePricePerDay = $vehiclePricePerDay;
        $this->vehicleAvailability = $vehicleAvailability;
        $this->vehicleIdCategory = $vehicleIdCategory;
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
        return "Vehicle (Vehicle_id: {$this->Vehicle_id}, vehicleModel: {$this->vehicleModel}, Price/Day: {$this->vehiclePricePerDay})";
    }
    public function getAllVehicles()
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT * FROM Vehicle LEFT JOIN Category ON Vehicle.vehicleIdCategory = Category.Category_id ";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getVehicle($id)
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT * FROM Vehicle LEFT JOIN Category ON Vehicle.vehicleIdCategory = Category.Category_id WHERE Vehicle_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function addVehicle()
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("
        INSERT INTO Vehicle 
        (image, vehicleModel, vehicleDescription, vehiclePricePerDay, vehicleAvailability, vehicleIdCategory)
        VALUES (:image, :vehicleModel, :vehicleDescription, :vehiclePricePerDay, :vehicleAvailability, :vehicleIdCategory)
    ");

        $stmt->bindParam(':image', $this->vehicleImage);
        $stmt->bindParam(':vehicleModel', $this->vehicleModel);
        $stmt->bindParam(':vehicleDescription', $this->vehicleDescription);
        $stmt->bindParam(':vehiclePricePerDay', $this->vehiclePricePerDay);
        $stmt->bindParam(':vehicleAvailability', $this->vehicleAvailability);
        $stmt->bindParam(':vehicleIdCategory', $this->vehicleIdCategory);

        $check = $stmt->execute();

        if ($check) {
            return "success";
        }
        return "connection problem";
    }


    public function updateVehicle($Vehicle_id)
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("
        UPDATE Vehicle SET
            image = :image,
            vehicleModel = :vehicleModel,
            vehicleDescription = :vehicleDescription,
            vehiclePricePerDay = :vehiclePricePerDay,
            vehicleAvailability = :vehicleAvailability,
            vehicleIdCategory = :vehicleIdCategory
        WHERE Vehicle_id = :Vehicle_id
    ");

        $stmt->bindParam(':image', $this->vehicleImage);
        $stmt->bindParam(':vehicleModel', $this->vehicleModel);
        $stmt->bindParam(':vehicleDescription', $this->vehicleDescription);
        $stmt->bindParam(':vehiclePricePerDay', $this->vehiclePricePerDay);
        $stmt->bindParam(':vehicleAvailability', $this->vehicleAvailability);
        $stmt->bindParam(':vehicleIdCategory', $this->vehicleIdCategory);
        $stmt->bindParam(':Vehicle_id', $Vehicle_id);

        $check = $stmt->execute();
        if ($check) {
            return "success";
        }
        return "connection problem";
    }

    public function deleteVehicle($Vehicle_id)
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("DELETE FROM Vehicle WHERE Vehicle_id = :Vehicle_id");
        $stmt->bindParam(':Vehicle_id', $Vehicle_id);

        $check = $stmt->execute();
        if ($check) {
            return "success";
        }
        return "connection problem";
    }
    public function isAvailable($Vehicle_id)
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("SELECT vehicleAvailability FROM Vehicle WHERE Vehicle_id = :Vehicle_id");
        $stmt->bindParam(':Vehicle_id', $Vehicle_id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        if ($result) {
            return (bool)$result->vehicleAvailability;
        } else {
            return null;
        }
    }

    public function calculateRentalCost($Vehicle_id, $days)
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("SELECT vehiclePricePerDay FROM Vehicle WHERE Vehicle_id = :Vehicle_id");
        $stmt->bindParam(':Vehicle_id', $Vehicle_id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($result) {
            return $result->vehiclePricePerDay * $days;
        } else {
            return null;
        }
    }
    public function getTotalCount()
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT COUNT(*) AS TotalVehicles FROM Vehicle";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        return $result->TotalVehicles;
    }

    public function getVehiclesByModel($model)
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT *
                FROM Vehicle v
                LEFT JOIN Category c ON v.vehicleIdCategory = c.Category_id
                WHERE v.vehicleModel = :model";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':model', $model);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getVehiclesByCategory($categoryName)
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT *
                FROM Vehicle v
                LEFT JOIN Category c ON v.vehicleIdCategory = c.Category_id
                WHERE c.categoryName = :categoryName";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':categoryName', $categoryName);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}