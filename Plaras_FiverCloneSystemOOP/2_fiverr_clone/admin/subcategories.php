<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/Subcategory.php';
require_once 'classes/Category.php';

$admin = new Admin();
$subcategory = new Subcategory();
$category = new Category();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

$feedback = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_subcategory'])) {
        $subcategory_name = trim($_POST['subcategory_name']);
        $category_id = $_POST['category_id'];
        if (!empty($subcategory_name) && !empty($category_id)) {
            if ($subcategory->createSubcategory($category_id, $subcategory_name)) {
                $feedback['success'] = "Subcategory added successfully.";
            } else {
                $feedback['error'] = "Failed to add subcategory.";
            }
        } else {
            $feedback['error'] = "Subcategory name and category cannot be empty.";
        }
    }
}

$subcategories = $subcategory->getSubcategories();
$categories = $category->getCategories();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Subcategories</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Manage Subcategories</h1>
        <div class="text-center mb-8">
            <a href="index.php" class="text-purple-600 hover:underline">Back to Dashboard</a>
        </div>

        <?php if (!empty($feedback)): ?>
            <div class="<?php echo isset($feedback['success']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> px-4 py-2 rounded-md mb-4 text-sm">
                <?php echo $feedback['success'] ?? $feedback['error']; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-md rounded-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-purple-700 mb-6">Add New Subcategory</h2>
            <form method="POST" class="space-y-4">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['category_id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="subcategory_name" class="block text-sm font-medium text-gray-700">Subcategory Name</label>
                    <input type="text" name="subcategory_name" id="subcategory_name" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" name="add_subcategory" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Add Subcategory</button>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-2xl font-bold text-purple-700 mb-6">Existing Subcategories</h2>
            <ul class="space-y-4">
                <?php foreach ($subcategories as $sub): ?>
                    <li class="flex justify-between items-center bg-gray-50 p-4 rounded-lg">
                        <div>
                            <span class="text-gray-800"><?php echo htmlspecialchars($sub['subcategory_name']); ?></span>
                            <span class="text-gray-500 text-sm">(Category: <?php echo htmlspecialchars($sub['category_name']); ?>)</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="edit_subcategory.php?id=<?php echo $sub['subcategory_id']; ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <a href="delete_subcategory.php?id=<?php echo $sub['subcategory_id']; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>