<?php
session_start();
require_once 'classes/Admin.php';
require_once __DIR__ . '../../../client/classes/Offer.php';

$admin = new Admin();
$offer = new Offer();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: offers.php');
    exit();
}

$offer_id_to_delete = $_GET['id'];

$offer->deleteOffer($offer_id_to_delete);

header('Location: offers.php');
exit();
?>