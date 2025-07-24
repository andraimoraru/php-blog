<?php
class Post {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    // Get all posts
    public function getPosts() {
        $this->db->query('SELECT * FROM posts');
        $results = $this->db->resultSet();
        return $results;    
    }   
}