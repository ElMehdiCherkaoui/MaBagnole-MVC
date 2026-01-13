<?php
class Reservation
{
    private $reservation_Id;
    private $reservationStartDate;
    private $reservationEndDate;
    private $reservationPickupLocation;
    private $reservationStatus;
    private $reservationTotalAmount;
    private $reservationIdUser;
    private $reservationIdVehicle;

    public function __construct(
        $reservation_Id = null,
        $reservationStartDate = null,
        $reservationEndDate = null,
        $reservationPickupLocation = null,
        $reservationStatus = 'pending',
        $reservationTotalAmount = null,
        $reservationIdUser = null,
        $reservationIdVehicle = null
    ) {
        $this->reservation_Id = $reservation_Id;
        $this->reservationStartDate = $reservationStartDate;
        $this->reservationEndDate = $reservationEndDate;
        $this->reservationPickupLocation = $reservationPickupLocation;
        $this->reservationStatus = $reservationStatus;
        $this->reservationTotalAmount = $reservationTotalAmount;
        $this->reservationIdUser = $reservationIdUser;
        $this->reservationIdVehicle = $reservationIdVehicle;
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
        return "Reservation (reservation_Id: {$this->reservation_Id}, reservationStatus: {$this->reservationStatus}, Total: {$this->reservationTotalAmount})";
    }
    public function listReservation()
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT *
    FROM Reservation r
    JOIN Vehicle v ON r.reservationIdVehicle = v.Vehicle_id
    JOIN Users u ON r.reservationIdUser = u.Users_id ";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    public function ajouteReservation()
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "INSERT INTO Reservation 
            (reservationStartDate, reservationEndDate, reservationPickUpLocation,
             reservationStatus, reservationTotalAmount, reservationIdUser, reservationIdVehicle)
            VALUES
            (:startDate, :endDate, :location, :status, :total, :userId, :vehicleId)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':startDate', $this->reservationStartDate);
        $stmt->bindParam(':endDate', $this->reservationEndDate);
        $stmt->bindParam(':location', $this->reservationPickupLocation);
        $stmt->bindParam(':status', $this->reservationStatus);
        $stmt->bindParam(':total', $this->reservationTotalAmount);
        $stmt->bindParam(':userId', $this->reservationIdUser);
        $stmt->bindParam(':vehicleId', $this->reservationIdVehicle);

        $check = $stmt->execute();
        if ($check) {
            return "success";
        }
        return "conection problem";
    }
    public function confirmReservation($id)
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "UPDATE Reservation 
                SET reservationStatus = 'confirmed'
                WHERE reservation_id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $check = $stmt->execute();
        if ($check) {
            return "success";
        }
        return "conection problem";
    }
    public function cancleReservation($id)
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "UPDATE Reservation 
                SET reservationStatus = 'cancelled'
                WHERE reservation_id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $check = $stmt->execute();
        if ($check) {
            return "success";
        }
        return "conection problem";
    }
    public function countTotalReservation()
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT COUNT(*) AS TotalReservations FROM Reservation";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->TotalReservations;
    }
    public function getReservationsByUser($userId)
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT * FROM Reservation r JOIN Vehicle v ON r.reservationIdVehicle = v.Vehicle_id WHERE r.reservationIdUser = :userId ORDER BY r.Reservation_id DESC";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function finishReservation($id)
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "UPDATE Reservation 
                SET reservationStatus = 'done'
                WHERE reservation_id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);

        $check = $stmt->execute();
        if ($check) {
            return "success";
        }
        return "conection problem";
    }
}