<?php
 class Pages extends Controller {
        private $postModel;


        public function __construct() {
            $this->postModel = $this->model('Post');

        }
        public function index() {

            $data = [
                'title' => 'Blog posts',
                'description' => 'This is a simple blog application built with PHP MVC framework.'
            ];
            $this->view('pages/index', $data);


        }
    
        public function about() {
            $data = [
                'title' => 'About Us',
                'description' => 'App to share blogs with other users.'
            ];
            $this->view('pages/about', $data);
        }
    

 }