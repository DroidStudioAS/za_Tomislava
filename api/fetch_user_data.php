<?php
require('../models/user.php');

// Function to fetch data of all users from the database
function getAllUsersData() {
    // Connect to the database
    $server_name = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $dbname = 'assignment';

    $conn = new mysqli($server_name, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch data of all users
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = array();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Loop through each row and create a user object
        while ($row = $result->fetch_assoc()) {
            $user = new User($row['user_username'], $row['user_password'], $row['user_email'], $row['user_age'], $row['user_is_admin']);
            // Add the user object to the users array
            $users[] = $user;
        }
    }

    // Close the connection
    $conn->close();

    // Return the array of user objects as JSON
    return json_encode($users);
}

// Endpoint
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Call the function to fetch all user data
    $userData = getAllUsersData();
    // Output the JSON data
    echo $userData;
}

