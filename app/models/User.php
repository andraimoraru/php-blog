<?php
 class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        if ($row) {
            return true; // User found
        } else {
            return false; // User not found
        }
    }
}