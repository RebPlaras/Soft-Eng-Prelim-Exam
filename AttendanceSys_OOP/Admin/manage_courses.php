<?php
session_start();
require_once "../Course.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}

$course = new Course();
$courses = $course->getCourses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-purple-700">Manage Courses</h2>
            <div class="space-x-3">
                <a href="dashboard.php" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Back
                </a>
                <a href="course_add.php" 
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                   + Add Course
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Course Name</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($courses as $c): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2"><?= $c['id'] ?></td>
                            <td class="px-4 py-2"><?= $c['course_name'] ?></td>
                            <td class="px-4 py-2 space-x-3">
                                <a href="course_edit.php?id=<?= $c['id'] ?>" 
                                   class="text-blue-600 hover:underline">Edit</a>
                                <a href="course_delete.php?id=<?= $c['id'] ?>" 
                                   onclick="return confirm('Delete this course?')" 
                                   class="text-red-600 hover:underline">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
