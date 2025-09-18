<?php
session_start();
require_once "../ExcuseLetter.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header("Location: ../index.php");
    exit;
}

$excuseLetter = new ExcuseLetter();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attachment_path = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $attachment_path = $upload_dir . basename($_FILES['attachment']['name']);
        move_uploaded_file($_FILES['attachment']['tmp_name'], '../' . $attachment_path);
    }

    $excuseLetter->submitLetter($_SESSION['student_id'], $_POST['letter_content'], $attachment_path);
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Excuse Letter</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold text-purple-700 mb-6">Submit Excuse Letter</h2>

        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Excuse Letter</label>
                <textarea name="letter_content" rows="10" required
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2"></textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Attachment (Optional)</label>
                <input type="file" name="attachment"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-2">
            </div>

            <button type="submit" 
                    class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Submit
            </button>
        </form>

        <div class.mt-6 text-center">
            <a href="dashboard.php" class="text-purple-600 hover:underline">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
