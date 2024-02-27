<?php
require('../models/user.php');

// Function to fetch data of a single user from the database
function getUserData($username) {
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
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_username=?");
    $stmt->bind_param('s', $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    $user = null;

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        // Create a user object
        $user = new User($row['user_id'], $row['user_username'], $row['user_password'], $row['user_email'], $row['user_age'], $row['user_is_admin']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Return the user object as JSON
    return json_encode($user);
}

// Endpoint
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get the user ID parameter from the request
    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Call the function to fetch user data for the specified user ID
    $userData = getUserData($username);

    // Output the JSON data
    echo $userData;
}

