<?php
session_start();
require_once "../Attendance.php";
require_once "../Student.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}

$attendance = new Attendance();
$student = new Student();

$students = $student->getStudents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $status = $_POST['status'];
    $is_late = $_POST['is_late'];

    $attendance->markAttendance($student_id, $status, $is_late);

    header("Location: view_attendance.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold text-purple-700 mb-6 text-center">Mark Attendance</h2>
        <form method="post" class="space-y-4">

            <div>
                <label class="block text-gray-700 mb-1">Student</label>
                <select name="student_id" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <option value="">-- Select Student --</option>
                    <?php foreach ($students as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= $s['name'] ?> (<?= $s['email'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Status</label>
                <select name="status" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 mb-1">Late</label>
                <select name="is_late" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="view_attendance.php" 
                   class="text-gray-600 hover:text-gray-800 transition">⬅ Back</a>
                <button type="submit" 
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</body>
</html>
