<?php
class User {
    // Properties
    public $username;
    public $password;
    public $email;
    public $age;
    public $isAdmin;

    // Constructor
    public function __construct($username, $password, $email, $age, $isAdmin) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->age = $age;
        $this->isAdmin = $isAdmin;
    }

    // Getters and setters (optional)
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function isAdmin() {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }
}
