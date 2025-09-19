<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/Subcategory.php';

$admin = new Admin();
$subcategory = new Subcategory();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: subcategories.php');
    exit();
}

$subcategory_id = $_GET['id'];

$subcategory->deleteSubcategory($subcategory_id);

header('Location: subcategories.php');
exit();
?>