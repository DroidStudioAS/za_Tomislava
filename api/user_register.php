<?php
require('../models/user.php');

function registerUser($username, $password, $email, $age, $isAdmin) {
    // Connect to the database
    $server_name = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $dbname = 'assignment';

    $conn = new mysqli($server_name, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (user_username, user_password, user_email, user_age, user_is_admin) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssii', $username, $hashed_password, $email, $age, $isAdmin);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo 'New record created successfully';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Endpoint
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get individual parameters from the request
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $isAdmin = filter_input(INPUT_POST, 'isAdmin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Call the registerUser function with individual parameters
    registerUser($username, $password, $email, $age, $isAdmin);
}

