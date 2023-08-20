<?php
class LoginUser {
    // Class properties
    private $username;
    private $password;
    public $error;
    public $success;
    private $storage = "data.json";
    private $stored_users;

    // Constructor to initialize the class properties
    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
        $this->stored_users = json_decode(file_get_contents($this->storage), true);
        $this->login();
    }

    // Method to perform user login
    private function login() {
        foreach ($this->stored_users as $user) {
            // Check if the username matches
            if ($user['username'] == $this->username) {
                // Verify the password
                if (password_verify($this->password, $user['password'])) {
                    // Start a new session and set user data
                    session_start();
                    $_SESSION['user'] = $this->username;
                    
                    // Redirect to the index page after successful login
                    header("Location: ../index.php");
                    exit(); // Exit to prevent further execution
                }
            }
        }
        
        // If no matching user or wrong password, set error message
        return $this->error = "Wrong username or password";
    }
}

?>