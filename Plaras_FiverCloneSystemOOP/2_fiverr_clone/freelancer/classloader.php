<?php
require_once __DIR__ . '/../client/classes/Database.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Proposal.php';
require_once __DIR__ . '/../client/classes/Offer.php';

$userObj = new User();
$proposalObj = new Proposal();
$offerObj = new Offer();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>