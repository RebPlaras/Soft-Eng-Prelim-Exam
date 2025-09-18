<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-purple-700 mb-6">
            🎓 Welcome, <?= htmlspecialchars($_SESSION['name']) ?> (Student)
        </h2>

        <!-- Navigation -->
        <ul class="space-y-3">
            <li>
                <a href="view_attendance.php" 
                   class="block w-full bg-purple-600 text-white px-4 py-2 rounded-lg text-center hover:bg-purple-700 transition">
                    View My Attendance
                </a>
            </li>
            <li>
                <a href="submit_excuse_letter.php" 
                   class="block w-full bg-purple-600 text-white px-4 py-2 rounded-lg text-center hover:bg-purple-700 transition">
                    Submit Excuse Letter
                </a>
            </li>
            <li>
                <a href="../logout.php" 
                   class="block w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-center hover:bg-gray-300 transition">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</body>
</html>
