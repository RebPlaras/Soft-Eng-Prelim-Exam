<?php
session_start();
require_once "../Attendance.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header("Location: ../index.php");
    exit;
}

$attendance = new Attendance();
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $is_late = $_POST['is_late'];

    // Mark attendance for the logged-in student
    if ($attendance->markAttendance($_SESSION['student_id'], $status, $is_late)) {
        $success = "Attendance recorded successfully.";
    } else {
        $error = "Failed to record attendance.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Top bar -->
    <div class="flex justify-end p-4">
        <a href="../logout.php" 
           class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition">
           Logout
        </a>
    </div>

    <!-- Content -->
    <div class="flex-grow flex items-center justify-center">
        <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold text-purple-700 text-center mb-6">
                Record My Attendance
            </h2>

            <?php if ($error): ?>
                <p class="text-red-500 text-center mb-4"><?= $error ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p class="text-green-500 text-center mb-4"><?= $success ?></p>
            <?php endif; ?>

            <form method="post" class="space-y-4">
                <div>
                    <label class="block font-semibold mb-1">Status:</label>
                    <select name="status" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Excused">Excused</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Late:</label>
                    <select name="is_late" required class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                    Record Attendance
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="dashboard.php" class="text-purple-700 hover:underline">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
