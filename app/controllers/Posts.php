<?php 
 class Posts extends Controller {
     protected $postModel;

     public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->postModel = $this->model('Post');

     }

     public function index() {
        // Get posts
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];
         $this->view('posts/index', $data);
     }
 }
