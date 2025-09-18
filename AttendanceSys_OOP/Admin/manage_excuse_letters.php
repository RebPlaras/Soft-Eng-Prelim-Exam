<?php
session_start();
require_once "../ExcuseLetter.php";
require_once "../Course.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../index.php");
    exit;
}

$excuseLetter = new ExcuseLetter();
$course = new Course();

$letters = $excuseLetter->getLetters();
$courses = $course->getCourses();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $excuseLetter->updateLetterStatus($_POST['letter_id'], $_POST['status']);
    header("Location: manage_excuse_letters.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['course_id']) && $_GET['course_id'] !== 'all') {
    $letters = $excuseLetter->filterLettersByCourse($_GET['course_id']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Excuse Letters</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold text-purple-700 mb-6">Manage Excuse Letters</h2>

        <div class="mb-4">
            <form method="get">
                <label class="mr-2">Filter by Course:</label>
                <select name="course_id" onchange="this.form.submit()">
                    <option value="all">All Courses</option>
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= (isset($_GET['course_id']) && $_GET['course_id'] == $c['id']) ? 'selected' : '' ?>><?= $c['course_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-xl p-8">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="py-2">Student</th>
                        <th class="py-2">Course</th>
                        <th class="py-2">Year</th>
                        <th class="py-2">Letter</th>
                        <th class="py-2">Attachment</th>
                        <th class="py-2">Date</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($letters as $letter): ?>
                        <tr>
                            <td class="py-2"><?= $letter['name'] ?></td>
                            <td class="py-2"><?= $letter['course_name'] ?></td>
                            <td class="py-2"><?= $letter['year_level'] ?></td>
                            <td class="py-2"><?= substr($letter['letter_content'], 0, 50) ?>...</td>
                            <td class="py-2">
                                <?php if ($letter['attachment_path']): ?>
                                    <a href="../<?= $letter['attachment_path'] ?>" target="_blank" class="text-purple-600 hover:underline">View</a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td class="py-2"><?= $letter['submission_date'] ?></td>
                            <td class="py-2"><?= $letter['status'] ?></td>
                            <td class="py-2">
                                <form method="post" class="inline-block">
                                    <input type="hidden" name="letter_id" value="<?= $letter['id'] ?>">
                                    <select name="status">
                                        <option value="Pending" <?= $letter['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Approved" <?= $letter['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                        <option value="Rejected" <?= $letter['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                    </select>
                                    <button type="submit" name="update_status" class="bg-purple-600 text-white px-2 py-1 rounded-lg hover:bg-purple-700 transition">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-center">
            <a href="dashboard.php" class="text-purple-600 hover:underline">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
