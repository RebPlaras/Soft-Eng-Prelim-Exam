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

if (!isset($_GET['id'])) {
    header('Location: categories.php');
    exit();
}

$category_id = $_GET['id'];
$cat = $category->getCategory($category_id);

if (!$cat) {
    header('Location: categories.php');
    exit();
}

$feedback = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        if ($category->updateCategory($category_name, $category_id)) {
            header('Location: categories.php');
            exit();
        } else {
            $feedback['error'] = "Failed to update category.";
        }
    } else {
        $feedback['error'] = "Category name cannot be empty.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Edit Category</h1>
        <a href="categories.php">Back to Categories</a>

        <?php if (!empty($feedback)): ?>
            <div class="alert alert-danger mt-3">
                <?php echo $feedback['error']; ?>
            </div>
        <?php endif; ?>

        <div class="card mt-4">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" name="category_name" class="form-control" value="<?php echo htmlspecialchars($cat['category_name']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>