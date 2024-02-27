<?php
require('../models/user.php');

function editUser($userId, $newUsername, $newEmail, $newAge, $newIsAdmin) {
    // Connect to the database
    $server_name = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $dbname = 'assignment';

    $conn = new mysqli($server_name, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE users SET user_username=?, user_email=?, user_age=?, user_is_admin=? WHERE user_id=?");
    $stmt->bind_param('sssii', $newUsername, $newEmail, $newAge, $newIsAdmin, $userId);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "User updated successfully. User ID: $userId, New Username: $newUsername, New Email: $newEmail, New Age: $newAge, New Is Admin: $newIsAdmin";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

//endpoint
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get individual parameters from the request
    $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newUsername = filter_input(INPUT_POST, 'newUsername', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newEmail = filter_input(INPUT_POST, 'newEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newAge = filter_input(INPUT_POST, 'newAge', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newIsAdmin = filter_input(INPUT_POST, 'newIsAdmin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Call the editUser function with individual parameters
    editUser($userId, $newUsername, $newEmail, $newAge, $newIsAdmin);
} else {
    echo "Invalid request method";
}

