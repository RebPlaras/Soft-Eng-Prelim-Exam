<?php
if (!class_exists('Database')) {
    require_once __DIR__ . '../../../client/classes/Database.php';
}

class Admin extends Database {

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }
}
?>