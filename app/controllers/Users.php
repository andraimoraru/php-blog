<?php
class Users extends Controller {
  public function __construct() {

  }

  public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Sanitize input
      $post = filter_input_array(INPUT_POST, [
        'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'email' => FILTER_VALIDATE_EMAIL,
        'password' => FILTER_DEFAULT,
        'confirm_password' => FILTER_DEFAULT,
      ]);

      // Fallback if input fails
      $post = $post ?? [];

      // Init data
      $data = [
        'name' => trim($post['name'] ?? ''),
        'email' => trim($post['email'] ?? ''),
        'password' => trim($post['password'] ?? ''),
        'confirm_password' => trim($post['confirm_password'] ?? ''),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // ====== VALIDATION ======
      // Name
      if (empty($data['name'])) {
        $data['name_err'] = 'Please enter your name';
      }

      // Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $data['email_err'] = 'Please enter a valid email';
      }

      // Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter a password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }

      // Confirm Password
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Please confirm your password';
      } elseif ($data['password'] !== $data['confirm_password']) {
        $data['confirm_password_err'] = 'Passwords do not match';
      }

      if (
        empty($data['name_err']) &&
        empty($data['email_err']) &&
        empty($data['password_err']) &&
        empty($data['confirm_password_err'])
      ) {
        // Register the user (TODO: add model call)
        // e.g. $this->userModel->register($data);

        die('Success! User registered.'); // Placeholder
      } else {
        // Show form again with errors
        $this->view('users/register', $data);
      }
    } else {
      // GET request – show blank form
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      $this->view('users/register', $data);
    }
  }


  public function login() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Sanitize input
      $post = filter_input_array(INPUT_POST, [
        'email' => FILTER_VALIDATE_EMAIL,
        'password' => FILTER_DEFAULT
      ]);

      // Fallback if input fails
      $post = $post ?? [];

      // Init data
      $data = [
        'email' => trim($post['email'] ?? ''),
        'password' => trim($post['password'] ?? ''),
        'email_err' => '',
        'password_err' => '',
      ];

      // ====== VALIDATION ======

      // Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      }

      // Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter your password';
      }

      if (
        empty($data['email_err']) &&
        empty($data['password_err'])
      ) {
        // Register the user (TODO: add model call)
        die('Success!'); // Placeholder
      } else {
        $this->view('users/login', $data);
      }
    } else {
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => ''
      ];
      $this->view('users/login', $data);
    }
  }
}