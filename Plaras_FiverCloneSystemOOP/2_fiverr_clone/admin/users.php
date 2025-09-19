<?php
session_start();
require_once 'classes/Admin.php';
require_once '../client/classes/User.php';

$admin = new Admin();
$user = new User();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

$users = $user->getUsers();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Manage Users</h1>
        <div class="text-center mb-8">
            <a href="index.php" class="text-purple-600 hover:underline">Back to Dashboard</a>
        </div>

        <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-2xl font-bold text-purple-700 mb-6">All Users</h2>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-purple-200">
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2"><?php echo htmlspecialchars($u['username']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($u['email']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($u['role']); ?></td>
                            <td class="px-4 py-2">
                                <a href="delete_user.php?id=<?php echo $u['user_id']; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>