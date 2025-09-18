<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Top bar with logout -->
    <div class="flex justify-end p-4">
        <a href="../logout.php" 
           class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition">
           Logout
        </a>
    </div>

    <!-- Dashboard box -->
    <div class="flex-grow flex items-center justify-center">
        <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-lg">
            <h2 class="text-2xl font-bold text-purple-700 text-center mb-6">
                Welcome, <?= $_SESSION['name'] ?> (Admin)
            </h2>

            <ul class="space-y-4">
                <li>
                    <a href="manage_students.php" 
                       class="block w-full text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                       Manage Students
                    </a>
                </li>
                <li>
                    <a href="manage_courses.php" 
                       class="block w-full text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                       Manage Courses
                    </a>
                </li>
                <li>
                    <a href="view_attendance.php" 
                       class="block w-full text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                       View Attendance
                    </a>
                </li>
                <li>
                    <a href="manage_excuse_letters.php" 
                       class="block w-full text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                       Manage Excuse Letters
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
