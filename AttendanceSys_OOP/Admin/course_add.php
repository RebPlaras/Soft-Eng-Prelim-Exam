<?php
session_start();
require_once "../Course.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}

$course = new Course();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course->addCourse($_POST['course_name']);
    header("Location: manage_courses.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-purple-700 mb-6">Add Course</h2>

        <!-- Form -->
        <form method="post" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Course Name</label>
                <input type="text" name="course_name" required
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
            </div>

            <button type="submit" 
                    class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Save
            </button>
        </form>

        <!-- Back link -->
        <div class="mt-6 text-center">
            <a href="manage_courses.php" class="text-purple-600 hover:underline">Back to Courses</a>
        </div>
    </div>
</body>
</html>
