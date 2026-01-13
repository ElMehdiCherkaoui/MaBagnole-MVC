<?php
// require_once '../config/database.php';
// require_once '../models/User.php';
// session_start();
require_once __DIR__ . '/../autoload.php';
$login = new AuthController; 
$login->login();

// $message = null;

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $users = new User();

//     $check = $users->login(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));

//     if ($check == "admin") {
//         $_SESSION['userEmailLogin'] = htmlspecialchars($_POST['email']);

//         header("Location: admin/dashboard.php");
//     } else if ($check == "client") {
//         $_SESSION['userEmailLogin'] = htmlspecialchars($_POST['email']);

//         header("Location: client/dashboard.php");
//     } else {
//         $message = $check;
//     }
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login | MaBagnole</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-md p-8 border border-gray-200">

        <div class="text-center mb-6">
            <div class="mb-4">
                <i class="fas fa-car-side text-4xl text-blue-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-blue-600">Welcome Back</h1>
            <p class="text-gray-500 mt-2">
                Login to access your MaBagnole account
            </p>
        </div>

        <form method="POST" action="">
            <?php if (!empty($message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <?= htmlspecialchars($message) ?>
            </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                    <input type="email" name="email" placeholder="john@email.com" required
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1 text-gray-700">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                    <input type="password" name="password" placeholder="********" required
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Don’t have an account?
            <a href="register.php" class="text-blue-600 font-medium hover:underline">
                Register
            </a>
        </p>

    </div>

</body>

</html>