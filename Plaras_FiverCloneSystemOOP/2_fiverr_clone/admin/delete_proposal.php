<?php
session_start();
require_once 'classes/Admin.php';
require_once __DIR__ . '../../../freelancer/classes/Proposal.php';
require_once __DIR__ . '../../../client/classes/Offer.php';

$admin = new Admin();
$proposal = new Proposal();
$offer = new Offer();

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: proposals.php');
    exit();
}

$proposal_id_to_delete = $_GET['id'];

// Delete offers associated with the proposal
$sql = "DELETE FROM offers WHERE proposal_id = ?";
$offer->executeNonQuery($sql, [$proposal_id_to_delete]);

// Delete the proposal
$proposal->deleteProposal($proposal_id_to_delete);

header('Location: proposals.php');
exit();
?>