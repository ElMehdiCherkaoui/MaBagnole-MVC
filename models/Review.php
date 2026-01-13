<?php
class Review
{
    private $Review_id;
    private $reviewRate;
    private $reviewComment;
    private $reviewDeletedDate;
    private $reviewIdUser;
    private $reviewIdVehicle;

    public function __construct(
        $Review_id = null,
        $reviewRate = null,
        $reviewComment = null,
        $reviewDeletedDate = null,
        $reviewIdUser = null,
        $reviewIdVehicle = null
    ) {
        $this->Review_id = $Review_id;
        $this->reviewRate = $reviewRate;
        $this->reviewComment = $reviewComment;
        $this->reviewDeletedDate = $reviewDeletedDate;
        $this->reviewIdUser = $reviewIdUser;
        $this->reviewIdVehicle = $reviewIdVehicle;
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
        return "Review (Review_id: {$this->Review_id}, reviewRate: {$this->reviewRate})";
    }
        public function listAllReviews()
    {
        $db = (new DataBase)->getConnection();

        $sql = "SELECT * FROM Review
            LEFT JOIN Users ON Review.reviewIdUser = Users.Users_id
            LEFT JOIN Vehicle ON Review.reviewIdVehicle = Vehicle.Vehicle_id";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function listReviews($email)
    {
        $db = (new DataBase)->getConnection();

        $sql = "SELECT * FROM Review
            LEFT JOIN Users ON Review.reviewIdUser = Users.Users_id
            LEFT JOIN Vehicle ON Review.reviewIdVehicle = Vehicle.Vehicle_id
            WHERE userEmail = :email
            AND reviewDeleteTime IS NULL";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function editReviews($id)
    {
        $db = (new DataBase)->getConnection();

        $sql = "UPDATE Review 
            SET reviewRate = :Rate, reviewComment = :Comment
            WHERE Review_id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':Rate', $this->reviewRate);
        $stmt->bindParam(':Comment', $this->reviewComment);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return 'success';
        }
        return 'Lost Connection';
    }

    public function softDelete($id)
    {
        $db = (new DataBase)->getConnection();

        $sql = "UPDATE Review SET reviewDeleteTime = NOW() WHERE Review_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return 'success';
        }
        return 'Lost Connection';
    }

    public function countReviews()
    {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT COUNT(*) AS TotalReviews FROM Review";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->TotalReviews;
    }
    public function CreateReview($userid)
    {
        $db = (new DataBase)->getConnection();

        $sql = "INSERT INTO Review 
            (reviewRate, reviewComment, reviewIdUser, reviewIdVehicle)
            VALUES (:rate, :comment, :user, :vehicle)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':rate', $this->reviewRate);
        $stmt->bindParam(':comment', $this->reviewComment);
        $stmt->bindParam(':user', $userid);
        $stmt->bindParam(':vehicle', $this->reviewIdVehicle);

        if ($stmt->execute()) {
            return 'success';
        }
        return 'Lost Connection';
    }

        public function recoveryReview($id)
    {
        $db = (new DataBase)->getConnection();

        $sql = "UPDATE Review SET reviewDeleteTime = NULL WHERE Review_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return 'success';
        }
        return 'Lost Connection';
    }
}