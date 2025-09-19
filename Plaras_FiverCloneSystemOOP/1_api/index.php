<?php  
require_once 'freelancer/classloader.php';

$allUsers = $userObj->getUsers();
$allProposals = $proposalObj->getProposals();
$allOffers = $offerObj->getOffers();

$offerObj->createOffer(1, "test if we can insert offer", 7);
echo "<pre>";
print_r($allOffers);
echo "<pre>";

?>