<?php
session_start();
require_once "../Attendance.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header("Location: ../index.php");
    exit;
}

$attendance = new Attendance();
$records = $attendance->getAttendanceByStudent($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-purple-700">My Attendances</h2>
            <a href="dashboard.php" 
               class="text-sm bg-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300 transition">
                Back
            </a>
             <a href="record_attendance.php" 
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    File an Attendance
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Late</th>
                        <th class="px-4 py-2 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($records)): ?>
                        <?php foreach ($records as $r): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2"><?= $r['id'] ?></td>
                                <td class="px-4 py-2">
                                    <?php if ($r['status'] === 'Present'): ?>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded">
                                            Present
                                        </span>
                                    <?php elseif ($r['status'] === 'Absent'): ?>
                                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-700 rounded">
                                            Absent
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded">
                                            Excused
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2">
                                    <?= $r['is_late'] === 'Yes' 
                                        ? '<span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded">Yes</span>' 
                                        : '<span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded">No</span>' ?>
                                </td>
                                <td class="px-4 py-2"><?= $r['date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                No attendance records found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
