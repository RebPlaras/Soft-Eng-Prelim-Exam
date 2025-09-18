<?php
session_start();
require_once "../Student.php";
require_once "../Course.php";
require_once "../User.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}

$student = new Student();
$course = new Course();
$user = new User();

$courses = $course->getCourses();
$users = $user->getUsersByRole("Student"); // only get student-role users

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student->addStudent($_POST['user_id'], $_POST['course_id'], $_POST['year_level']);
    header("Location: manage_students.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-purple-700 mb-6">Enroll Student</h2>

        <!-- Form -->
        <form method="post" class="space-y-4">
            <!-- Student Dropdown -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">User (Student)</label>
                <select name="user_id" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <option value="">-- Select Student --</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> (<?= htmlspecialchars($u['email']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Course Dropdown -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Course</label>
                <select name="course_id" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <option value="">-- Select Course --</option>
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['course_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Year Level -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Year Level</label>
                <input type="number" name="year_level" min="1" max="5" required
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Enroll
            </button>
        </form>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <a href="manage_students.php" class="text-purple-600 hover:underline">Back to Students</a>
        </div>
    </div>
</body>
</html>
