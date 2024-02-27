<?php
require('../models/user.php');

/****Helper Functions*******/
function isUsernameTaken($username) {
    session_start();
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
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_username = ?");
    $stmt->bind_param('s', $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Username is taken
        return true;
    } else {
        // Username is not taken
        return false;
    }


}

function isEmailTaken($email) {
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
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
    $stmt->bind_param('s', $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Email is taken
        return true;
    } else {
        // Email is not taken
        return false;
    }


}
/****End Of Helper Functions*******/
function registerUser($username, $password, $email, $age, $isAdmin) {
    // Check if the username is already taken
    if (isUsernameTaken($username)) {
        echo "Username is already in use";
        return;
    }

    // Check if the email is already taken
    if (isEmailTaken($email)) {
        echo "Email is already in use";
        return;
    }

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
        //save admin status to session;
        $_SESSION['user_is_admin'] = 0;
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

