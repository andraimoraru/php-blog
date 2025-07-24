<?php
 class Pages extends Controller {
        private $postModel;


        public function __construct() {
            $this->postModel = $this->model('Post');

        }
        public function index() {

            $data = [
                'title' => 'Welcome to MVC',
            ];
            $this->view('pages/index', $data);


        }
    
        public function about() {
            $data = [
                'title' => 'About Us'
            ];
            $this->view('pages/about', $data);
        }
    

 }