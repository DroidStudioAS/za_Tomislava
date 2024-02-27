<?php
session_start();

// Check if the user is logged in and isAdmin is set
if(isset($_SESSION['user_is_admin'])) {
    // If user is an admin, show all users
    if($_SESSION['user_is_admin'] == 1) {
        // Include logic to display all users
        include('admin_content.php');
    } else {
        // If user is not an admin, show only their own details
        include('user_content.php');
    }
} else {
    // If user is not logged in or session value not set, redirect to login page
    header('Location: index.php');
    exit();
}
