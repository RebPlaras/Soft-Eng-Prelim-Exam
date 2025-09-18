<?php
session_start();
require_once "../Student.php";
require_once "../Course.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}

$student = new Student();
$course = new Course();
$courses = $course->getCourses();

$data = $student->getStudentById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student->updateStudent($_GET['id'], $_POST['course_id'], $_POST['year_level']);
    header("Location: manage_students.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-purple-700 mb-6">Edit Student</h2>

        <!-- Form -->
        <form method="post" class="space-y-4">
            <!-- User ID -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">User ID</label>
                <input type="number" value="<?= $data['user_id'] ?>" disabled
                       class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-100 p-2">
            </div>

            <!-- Course Dropdown -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Course</label>
                <select name="course_id" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $data['course_id'] == $c['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['course_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Year Level -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Year Level</label>
                <input type="number" name="year_level" value="<?= $data['year_level'] ?>" min="1" max="5" required
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Update
            </button>
        </form>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <a href="manage_students.php" class="text-purple-600 hover:underline">Back to Students</a>
        </div>
    </div>
</body>
</html>
