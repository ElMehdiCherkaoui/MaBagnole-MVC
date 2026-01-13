<?php
class User
{
    private $user_id;
    private $userName;
    private $userEmail;
    private $userRole;
    private $userStatus;
    private $passwordHash;
    private $userCreateDate;

    public function __construct(
        $user_id = null,
        $userName = null,
        $userEmail = null,
        $userRole = null,
        $userStatus = null,
        $passwordHash = null,
        $userCreateDate = null
    ) {
        $this->user_id = $user_id;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userRole = $userRole;
        $this->userStatus = $userStatus;
        $this->passwordHash = $passwordHash;
        $this->userCreateDate = $userCreateDate;
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
        return "User (ID: {$this->user_id}, Name: {$this->userName}, Email: {$this->userEmail}, Role: {$this->userRole}, status: {$this->userStatus}, createDate: {$this->userCreateDate})";
    }


    public function login($email, $password)
    {
        if (empty($email) || empty($password)) {
            return "All fields are required";
        }

        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT 
                Users_id,
                userName,
                userEmail,
                userRole,
                userStatus,
                password_hash
            FROM Users
            WHERE userEmail = :email";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetchObject();

        if (!$user) {
            return "Invalid email or password";
        }

        if (!password_verify($password, $user->password_hash)) {
            return "Invalid email or password";
        }

        if ($user->userStatus == 0) {
            return "Account is disabled";
        }

        return $user->userRole;
    }

    public function register()
    {
        if (
            empty($this->userName) ||
            empty($this->userEmail) ||
            empty($this->passwordHash)
        ) {
            return "All fields are required";
        }

        $database = new Database();
        $db = $database->getConnection();

        $check = $db->prepare("SELECT COUNT(*) as Total FROM Users WHERE userEmail = :email");
        $check->bindParam(":email", $this->userEmail);
        $check->execute();
        $results_array = $check->fetchObject();

        if (((int)$results_array->Total)  > 0) {
            return "Email already exists";
        }



        $hashedPassword = password_hash($this->passwordHash, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (
                userName,
                userEmail,
                userRole,
                userStatus,
                password_hash,
                userCreated
            ) VALUES (
                :name,
                :email,
                'client',
                1,
                :password,
                NOW()
            )";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":name", $this->userName);
        $stmt->bindParam(":email", $this->userEmail);
        $stmt->bindParam(":password", $hashedPassword);

        $stmt->execute();
        return "success";
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function listUserLogged($userEmail)
    {
        $db = (new Database)->getConnection();
        $sql = "SELECT * FROM users WHERE userEmail = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $userEmail);
        $stmt->execute();
        return $stmt->fetchObject();
    }
}