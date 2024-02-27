<?php
require('../models/user.php');

function getAllUsers() {
    // Connect to the database
    $server_name = 'localhost';
    $username_db = 'root';
    $password_db = '';
    $dbname = 'assignment';

    $conn = new mysqli($server_name, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to select all users
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    
    // Close the connection
    $conn->close();
    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch all rows as an associative array
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    } else {
        // No users found
        return array();
    }


}

// Endpoint
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Call the getAllUsers function to fetch all users
    $allUsers = getAllUsers();
    
    // Return the data as JSON
    echo json_encode($allUsers);
} else {
    // Method not allowed
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed";
}

