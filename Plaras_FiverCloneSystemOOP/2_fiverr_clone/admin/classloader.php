<?php
require_once __DIR__ . '/../client/classes/Database.php';
require_once __DIR__ . '/classes/Admin.php';
require_once __DIR__ . '/classes/Category.php';
require_once __DIR__ . '/classes/Subcategory.php';
require_once __DIR__ . '/../client/classes/User.php';
require_once __DIR__ . '/../client/classes/Offer.php';
require_once __DIR__ . '/../freelancer/classes/Proposal.php';

$admin = new Admin();
$category = new Category();
$subcategory = new Subcategory();
$user = new User();
$offer = new Offer();
$proposal = new Proposal();

?>