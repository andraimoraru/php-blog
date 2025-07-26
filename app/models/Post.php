<?php
class Post {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    // Get all posts
    public function getPosts() {
        $this->db->query('SELECT * , 
                        users.name AS name,
                        posts.id AS postId,
                        users.id AS userId,
                        posts.body AS body,
                        posts.title AS title,
                        posts.created_at AS postCreatedAt                      
                        FROM posts
                        JOIN users 
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC');
              
        $results = $this->db->resultSet();      
        return $results;    
    }   
}