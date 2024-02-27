<?php
require('../models/user.php');

function loginUser($username, $password) {
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
        // User exists, fetch the row
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['user_password'])) {
            //store the id and admin status in a session variable 
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_is_admin'] = $user['user_is_admin'];
            // Password is correct, return the user data
            return $user;
        } else {
            // Password is incorrect
            return false;
        }
    } else {
        // User does not exist
        return false;
    }


}

// Endpoint
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get individual parameters from the request
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Call the loginUser function with individual parameters
    $user = loginUser($username, $password);
    
    if ($user) {
        // User logged in successfully
        echo json_encode($user);
    } else {
        // Invalid username or password
        echo "Invalid username or password";
    }
}

