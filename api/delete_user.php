<?php
require('../models/user.php');

function deleteUser($userId) {
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
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
    $stmt->bind_param('i', $userId);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo 'User deleted successfully';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Endpoint
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get individual parameter from the request
    $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Call the deleteUser function with the user ID parameter
    deleteUser($userId);
}

