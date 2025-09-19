<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/Category.php';

$admin = new Admin();
$category = new Category();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

$feedback = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $category_name = trim($_POST['category_name']);
        if (!empty($category_name)) {
            if ($category->createCategory($category_name)) {
                $feedback['success'] = "Category added successfully.";
            } else {
                $feedback['error'] = "Failed to add category.";
            }
        } else {
            $feedback['error'] = "Category name cannot be empty.";
        }
    }
}

$categories = $category->getCategories();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Manage Categories</h1>
        <div class="text-center mb-8">
            <a href="index.php" class="text-purple-600 hover:underline">Back to Dashboard</a>
        </div>

        <?php if (!empty($feedback)): ?>
            <div class="<?php echo isset($feedback['success']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> px-4 py-2 rounded-md mb-4 text-sm">
                <?php echo $feedback['success'] ?? $feedback['error']; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-md rounded-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-purple-700 mb-6">Add New Category</h2>
            <form method="POST" class="space-y-4">
                <div>
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="category_name" id="category_name" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" name="add_category" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Add Category</button>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-2xl font-bold text-purple-700 mb-6">Existing Categories</h2>
            <ul class="space-y-4">
                <?php foreach ($categories as $cat): ?>
                    <li class="flex justify-between items-center bg-gray-50 p-4 rounded-lg">
                        <span class="text-gray-800"><?php echo htmlspecialchars($cat['category_name']); ?></span>
                        <div class="flex space-x-2">
                            <a href="edit_category.php?id=<?php echo $cat['category_id']; ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <a href="delete_category.php?id=<?php echo $cat['category_id']; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>