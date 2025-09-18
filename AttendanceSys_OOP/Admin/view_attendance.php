<?php
session_start();
require_once "../Attendance.php";
require_once "../Course.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}

$attendance = new Attendance();
$course = new Course();
$courses = $course->getCourses();

$records = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $records = $attendance->filterAttendance($_POST['course_id'], $_POST['year_level']);
} else {
    $records = $attendance->getAttendance();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-purple-700">Attendance Records</h2>
            <div class="space-x-4">
                <a href="dashboard.php" class="text-gray-600 hover:text-gray-800 transition">Back</a>
                <a href="mark_attendance.php" 
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Mark Attendance
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="post" class="flex flex-wrap gap-4 mb-6 items-end">
            <div>
                <label class="block text-gray-700 mb-1">Course</label>
                <select name="course_id" required
                        class="border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= $c['course_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Year Level</label>
                <select name="year_level" required
                        class="border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>

            <button type="submit"
                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Filter
            </button>
        </form>

        <!-- Attendance Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse bg-white rounded-lg shadow">
                <thead>
                    <tr class="bg-purple-600 text-white text-left">
                        <th class="p-3">ID</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Course</th>
                        <th class="p-3">Year</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Late</th>
                        <th class="p-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($records) > 0): ?>
                        <?php foreach ($records as $r): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= $r['id'] ?></td>
                                <td class="p-3"><?= $r['name'] ?></td>
                                <td class="p-3"><?= $r['course_name'] ?></td>
                                <td class="p-3"><?= $r['year_level'] ?></td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-sm font-medium 
                                        <?= $r['status'] === 'Present' ? 'bg-green-100 text-green-700' : 
                                           ($r['status'] === 'Absent' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') ?>">
                                        <?= $r['status'] ?>
                                    </span>
                                </td>
                                <td class="p-3">
                                    <?= $r['is_late'] === 'Yes' 
                                        ? '<span class="text-orange-600 font-semibold">Yes</span>' 
                                        : '<span class="text-gray-600">No</span>' ?>
                                </td>
                                <td class="p-3"><?= $r['date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
