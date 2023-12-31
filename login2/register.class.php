<?php
class RegisterUser {
    private $username;
    private $raw_password;
    private $encrypted_password;
    public $error;
    public $success;
    private $storage = "data.json";
    private $stored_users;
    private $new_user;

    public function __construct($username, $password) {
        // Sanitize and validate input data
        $this->username = trim(filter_var($username, FILTER_SANITIZE_STRING));
        $this->raw_password = filter_var(trim($password), FILTER_SANITIZE_STRING);
        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        $this->stored_users = json_decode(file_get_contents($this->storage), true);

        $nextId = count($this->stored_users);

        // Define the new user data
        $this->new_user = [
            "id" => $nextId,
            "username" => $this->username,
            "password" => $this->encrypted_password,
            'favoriteGames' => [],
            'completedGames' => [],
            'ratedGames' => [],
            'profilePicture' => 'dog1.jpg'
        ];

        // Check field values and insert user if valid
        if ($this->checkFieldValues()) {
            $this->insertUser();
        }
    }

    private function checkFieldValues() {
        if (empty($this->username) || empty($this->raw_password)) {
            $this->error = "Both fields are required.";
            return false;
        } else if (strlen($this->raw_password) < 6) {
            $this->error = "Password must be at least 6 characters long.";
            return false;
        } else if (!preg_match('/[A-Z]/', $this->raw_password)) {
            $this->error = "Password must contain at least one uppercase letter.";
            return false;
        } else if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>?]/', $this->raw_password)) {
            $this->error = "Password must contain at least one special character.";
            return false;
        } else {
            return true;
        }
    }

    private function usernameExists() {
        foreach ($this->stored_users as $user) {
            if ($this->username == $user['username']) {
                $this->error = "Username already taken, please choose a different one.";
                return true;
            }
        }
        return false;
    }

    private function insertUser() {
        if ($this->usernameExists() == FALSE) {
            array_push($this->stored_users, $this->new_user);
            if (file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))) {
                return $this->success = "Your registration was successful";
            } else {
                return $this->error = "Something went wrong, please try again";
            }
        }
    }
}

?>