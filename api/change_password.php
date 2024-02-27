<?php
require('../models/user.php');

// Function to change user's password
function changePassword($userId, $newPassword) {
    // Connect to the database
    $server_name = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $dbname = 'assignment';

    $conn = new mysqli($server_name, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_id=?");
    $stmt->bind_param('si', $hashedPassword, $userId);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo 'Password changed successfully';
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
    $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Call the changePassword function with individual parameters
    changePassword($userId, $newPassword);
} else {
    echo "Invalid request method";
}

