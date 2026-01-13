<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MaBagnole | Vehicle Rental Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600 flex items-center">
                <i class="fas fa-car mr-2"></i> MaBagnole
            </h1>

            <div class="hidden md:flex space-x-4">
                <a href="views/login.php" class="text-gray-700 hover:text-blue-600 font-medium flex items-center">
                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                </a>
                <a href="views/register.php"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                    <i class="fas fa-user-plus mr-1"></i> Register
                </a>
            </div>


        </div>

    </nav>



    <section class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-50 to-gray-100">
        <div class="max-w-4xl text-center px-6">

            <div class="mb-6">
                <i class="fas fa-car-side text-6xl text-blue-600"></i>
            </div>

            <h2 class="text-4xl md:text-6xl font-extrabold mb-6 text-gray-800">
                Rent Vehicles Easily & Securely
            </h2>

            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                MaBagnole is a modern vehicle rental platform that allows you to
                explore, compare, and reserve cars in just a few clicks.
                Simple, fast, and reliable.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="views/login.php"
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>

                <a href="views/register.php"
                    class="border border-blue-600 text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i> Create Account
                </a>
            </div>

        </div>
    </section>

    <footer class="bg-white border-t shadow-inner">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-gray-500 flex items-center justify-center">
            <i class="fas fa-copyright mr-2"></i> 2025 MaBagnole — All rights reserved.
        </div>
    </footer>

</body>

</html>