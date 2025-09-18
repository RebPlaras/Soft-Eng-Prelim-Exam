<?php require_once 'classloader.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%);
        }
    </style>
    <title>Writer Registration</title>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <nav class="gradient-bg p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold flex items-center" href="../index.php">
                <i class="fas fa-book-open mr-2"></i>
                <span class="bg-clip-text">School Newspaper</span>
            </a>
        </div>
    </nav>
    <main class="flex-grow">
        <div class="container mx-auto mt-12">
            <div class="flex justify-center">
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-lg rounded-xl border border-primary-100">
                        <div class="gradient-bg text-white text-center py-4 px-6 rounded-t-xl">
                            <h2 class="text-2xl font-bold">Writer Registration</h2>
                        </div>
                        <div class="p-8">
                            <form action="core/handleForms.php" method="POST">
                                <div class="mb-4">
                                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                                    <input type="text" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" name="username" required>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                                    <input type="email" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" name="email" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                                    <input type="password" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" name="password" required>
                                </div>
                                <div class="mb-6">
                                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                                    <input type="password" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" name="confirm_password" required>
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="gradient-bg hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline w-full" name="insertNewUserBtn">Register</button>
                                </div>
                            </form>
                            <div class="text-center mt-6">
                                <p class="text-gray-600">Already have an account? <a href="login.php" class="text-primary-600 hover:text-primary-800 font-semibold">Login here!</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="gradient-bg text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 School Newspaper</p>
        </div>
    </footer>
</body>
</html>