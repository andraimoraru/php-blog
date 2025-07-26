<?php
class Users extends Controller {
  private $userModel;

  public function __construct() {
    $this->userModel = $this->model('User');
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
      } elseif ($this->userModel->findUserByEmail($data['email'])) {
        $data['email_err'] = 'Email is already taken';
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
        // Validation passed, proceed with registration

        //Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); 

        // Register the user
        if ($this->userModel->register($data)) {
          flash('register_success', 'You are now registered and can log in.', 'alert alert-success');
          // Redirect to login page or success page
          redirect('users/login');

        } else {
          die('Something went wrong. Please try again.');
        }

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
            $data['password_err'] = 'Please enter your password.';
        }

        // Check if user exists
        if ($this->userModel->findUserByEmail($data['email'])) {
            // User exists
        } else {
            // User does not exist
            $data['email_err'] = 'No user found with that email.';
        }

        // Check for errors

        if (empty($data['email_err']) && empty($data['password_err'])) {
            // Validation passed, proceed with login    
            $loggedInUser = $this->userModel->login($data['email'], $data['password']);
            if ($loggedInUser) {
                // Create session
                $this->createUserSession($loggedInUser);

            } else {
                $data['password_err'] = 'Password incorrect';
                $this->view('users/login', $data);
            }
        } else {
            // Show form again with errors
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

  public function createUserSession($user) {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    redirect('posts'); // Redirect to home or dashboard
  }

  public function logout() {
    // Unset session variables
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);

    // Destroy the session
    session_destroy();

    // Redirect to login page
    redirect('users/login');
  }
}