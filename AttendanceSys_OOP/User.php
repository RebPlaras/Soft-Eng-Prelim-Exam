<?php
require_once "Database.php";

class User extends Database {
    private $table = "users";

    // register user
    public function register($name, $email, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO $this->table (name, email, password, role) VALUES (?, ?, ?, ?)";
        return $this->create($query, [$name, $email, $hashedPassword, $role]);
    }

    // login user
    public function login($email, $password) {
        $query = "SELECT * FROM $this->table WHERE email = ?";
        $result = $this->read($query, [$email]);

        if ($result && password_verify($password, $result[0]['password'])) {
            return $result[0]; // return user info
        }
        return false;
    }

    // get the user by role
    public function getUsersByRole($role) {
        $query = "SELECT * FROM users WHERE role = ?";
        return $this->read($query, [$role]);
    }

}
