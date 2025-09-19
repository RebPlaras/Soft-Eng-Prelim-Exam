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

// First, delete subcategories associated with this category
require_once 'classes/Subcategory.php';
$subcategory = new Subcategory();
$subcategories = $subcategory->getSubcategoriesByCategory($category_id);
foreach ($subcategories as $sub) {
    $subcategory->deleteSubcategory($sub['subcategory_id']);
}

// Then, delete the category
$category->deleteCategory($category_id);

header('Location: categories.php');
exit();
?>