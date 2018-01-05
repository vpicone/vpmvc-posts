<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    // Handles loading form at register page and submitting requests
    public function register()
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          // Process form

          // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          // Init data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

          // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Pleae enter email';
            } else {
            // Check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

          // Validate Name
            if (empty($data['name'])) {
                $data['name_err'] = 'Pleae enter name';
            }

          // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Pleae enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

          // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Pleae confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

          // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
            // Validated

            // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Register User
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }

            } else {
            // Load view with errors
                $this->view('users/register', $data);
            }

        } else {
          // Init data
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

          // Load view
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            //  Email validation
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            }

            //  Password validation
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            }


            // Check for existing user
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                $data['email_err'] = 'No user found.';
            }

            // Make sure errors are empty
            // Make sure errors are empty
            if (empty($data['email_err']) &&
                empty($data['password_err'])) {

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                // Create session for user
                    $this->createUserSession($loggedInUser);
                } else {
                    // Credentials invalid, reload form with errors
                    $data['email_err'] = "Invalid credentials.";
                    $data['password_err'] = "Invalid credentials.";
                    $this->view('users/login', $data);
                }


            } else {
                //Load view with the errors
                $this->view('users/login', $data);
            }


        } else {
            // Get request, load form with data if redirect after error.
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        //The id comes from the row which is returned when a user is logged in.
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['role'] = $user->role;
        redirect('posts');
    }

    public function logout()
    {
        //You need to remove global variables explicitly.
        session_unset();

        //destroys the entire session and all assoc data.
        session_destroy();
        redirect('users/login');
    }



    public function load()
    {
        if (($handle = fopen("../MOCK_DATA.csv", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $name = filter_var($data[0], FILTER_SANITIZE_STRING);
                $email = filter_var($data[1], FILTER_SANITIZE_EMAIL);
                $password = filter_var($data[2], FILTER_SANITIZE_STRING);

                $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
                $userData = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $encrypted_password
                ];

                if ($this->userModel->register($userData)) {
                    echo "$name registered. <br>";
                } else {
                    echo "Failure.";
                }
            }
            fclose($handle);
        } else {
            redirect('/');
        }
    }


}