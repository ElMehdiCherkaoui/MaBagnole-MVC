<?php

require_once __DIR__ . '/../autoload.php';

class AuthController
{
    public function login()
    {

    session_start();
        $message = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user = new User();
            $check = $user->login(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));

            if ($check == "admin") {
                $_SESSION['userEmailLogin'] = htmlspecialchars($_POST['email']);
                header("Location: admin/dashboard.php");
                exit;
            } elseif ($check == "client") {
                $_SESSION['userEmailLogin'] = htmlspecialchars($_POST['email']);
                header("Location: client/dashboard.php");
                exit;
            } else {
                $message = $check;
            }
        }

    }

    public function register()
    {
        session_start();

        $message = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user = new User();
            $user->userName = htmlspecialchars($_POST['name']);
            $user->userEmail = htmlspecialchars($_POST['email']);
            $user->passwordHash = $_POST['password'];

            $check = $user->register();

            if ($check == "success") {
                header("Location: login.php");
                exit;
            } else {
                $message = $check;
            }
        }

    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}