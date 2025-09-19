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

if (!isset($_GET['id'])) {
    header('Location: subcategories.php');
    exit();
}

$subcategory_id = $_GET['id'];
$sub = $subcategory->getSubcategory($subcategory_id);

if (!$sub) {
    header('Location: subcategories.php');
    exit();
}

$feedback = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subcategory_name = trim($_POST['subcategory_name']);
    $category_id = $_POST['category_id'];
    if (!empty($subcategory_name) && !empty($category_id)) {
        if ($subcategory->updateSubcategory($subcategory_name, $subcategory_id)) {
            header('Location: subcategories.php');
            exit();
        } else {
            $feedback['error'] = "Failed to update subcategory.";
        }
    } else {
        $feedback['error'] = "Subcategory name and category cannot be empty.";
    }
}

$categories = $category->getCategories();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Subcategory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Edit Subcategory</h1>
        <a href="subcategories.php">Back to Subcategories</a>

        <?php if (!empty($feedback)): ?>
            <div class="alert alert-danger mt-3">
                <?php echo $feedback['error']; ?>
            </div>
        <?php endif; ?>

        <div class="card mt-4">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $sub['category_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['category_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subcategory_name">Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control" value="<?php echo htmlspecialchars($sub['subcategory_name']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>