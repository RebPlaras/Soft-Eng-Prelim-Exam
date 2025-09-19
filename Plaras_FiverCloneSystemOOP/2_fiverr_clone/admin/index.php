<?php
session_start();
require_once 'classes/Admin.php';

$admin = new Admin();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Admin Dashboard</h1>
        <p class="text-center text-gray-600 mb-8">Welcome, Administrator!</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <a href="categories.php" class="bg-white shadow-md rounded-xl p-8 text-center hover:bg-purple-100 transition">
                <h2 class="text-xl font-bold text-purple-700">Manage Categories</h2>
            </a>
            <a href="subcategories.php" class="bg-white shadow-md rounded-xl p-8 text-center hover:bg-purple-100 transition">
                <h2 class="text-xl font-bold text-purple-700">Manage Subcategories</h2>
            </a>
            <a href="users.php" class="bg-white shadow-md rounded-xl p-8 text-center hover:bg-purple-100 transition">
                <h2 class="text-xl font-bold text-purple-700">Manage Users</h2>
            </a>
            <a href="proposals.php" class="bg-white shadow-md rounded-xl p-8 text-center hover:bg-purple-100 transition">
                <h2 class="text-xl font-bold text-purple-700">Manage Proposals</h2>
            </a>
            <a href="offers.php" class="bg-white shadow-md rounded-xl p-8 text-center hover:bg-purple-100 transition">
                <h2 class="text-xl font-bold text-purple-700">Manage Offers</h2>
            </a>
        </div>
        <div class="mt-8 text-center">
            <a href="../client/index.php" class="bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Switch to Client View</a>
            <?php if (isset($_SESSION['is_client']) && !$_SESSION['is_client']): ?>
                <a href="../freelancer/index.php" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition ml-4">Switch to Freelancer View</a>
            <?php endif; ?>
            <a href="logout.php" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition ml-4">Logout</a>
        </div>
    </div>
</body>
</html>