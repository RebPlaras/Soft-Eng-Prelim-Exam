<?php  
require_once __DIR__ . '../../../1_api/admin/classes/Article.php';
require_once __DIR__ . '../../../1_api/admin/classes/Database.php';
require_once __DIR__ . '../../../1_api/admin/classes/User.php';
require_once __DIR__ . '../../../1_api/admin/classes/Notification.php';
require_once __DIR__ . '../../../1_api/admin/classes/Category.php';

$databaseObj= new Database();
$userObj = new User();
$articleObj = new Article();
$notificationObj = new Notification();
$categoryObj = new Category();

$userObj->startSession();