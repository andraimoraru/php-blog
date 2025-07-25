<?php
 class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Register a new user
    public function register($data) {
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);        
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        //Hashed password
        $hashedPassword = $row->password;
        // Check if password matches
        if (password_verify($password, $hashedPassword)) {
            return $row; // Return user data
        } else {
            return false; // Password does not match    
        }
    }   

    public function findUserByEmail($email) {

        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        // Check if user exists
        if ($row) {
            return true; // User found
        } else {
            return false; // User not found
        }
    }
}