<?php
session_start();
require_once "User.php";
require_once "Student.php";

$user = new User();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $loggedInUser = $user->login($email, $password);

    if ($loggedInUser) {
        $_SESSION['user_id'] = $loggedInUser['id'];
        $_SESSION['role'] = $loggedInUser['role'];
        $_SESSION['name'] = $loggedInUser['name'];

        // if student, also store student_id in session
        if ($loggedInUser['role'] === 'Student') {
            $studentObj = new Student();
            $studentData = $studentObj->getStudentByUserId($loggedInUser['id']);
            if ($studentData) {
                $_SESSION['student_id'] = $studentData['id'];
            }
        }

        // redirect based on role
        if ($loggedInUser['role'] === 'Admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: student/dashboard.php");
        }
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-purple-700 mb-6">Login</h2>

        <?php if ($error): ?>
            <p class="bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4 text-sm">
                <?= $error ?>
            </p>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required 
                       class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required 
                       class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            <button type="submit" 
                class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                Login
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Don’t have an account? 
            <a href="register.php" class="text-purple-600 hover:underline">Register here</a>
        </p>
    </div>
</body>
</html>
