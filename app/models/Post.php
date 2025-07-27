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
    // Add post
    public function addPost($data) {
        $this->db->query('INSERT INTO posts (title, body, user_id) 
                        VALUES (:title, :body, :user_id)');
        // Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        $this->db->bind(':user_id', $data['user_id']);  
        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // Get post by ID
    public function getPostById($id) {
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
                        WHERE posts.id = :id');
        // Bind value
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;    
    }
}