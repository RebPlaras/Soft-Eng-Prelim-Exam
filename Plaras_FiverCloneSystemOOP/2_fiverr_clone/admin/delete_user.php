<?php
session_start();
require_once 'classes/Admin.php';
require_once 'classes/User.php';
require_once __DIR__ . '../../../client/classes/Offer.php';
require_once __DIR__ . '../../../freelancer/classes/Proposal.php';

$admin = new Admin();
$user = new User();
$offer = new Offer();
$proposal = new Proposal();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit();
}

$user_id_to_delete = $_GET['id'];

// Delete user's offers
$sql = "DELETE FROM offers WHERE user_id = ?";
$offer->executeNonQuery($sql, [$user_id_to_delete]);

// Delete user's proposals
$sql = "DELETE FROM proposals WHERE user_id = ?";
$proposal->executeNonQuery($sql, [$user_id_to_delete]);

// Delete from administrators table
$sql = "DELETE FROM administrators WHERE user_id = ?";
$admin->executeNonQuery($sql, [$user_id_to_delete]);

// Delete user
$user->deleteUser($user_id_to_delete);

header('Location: users.php');
exit();
?>