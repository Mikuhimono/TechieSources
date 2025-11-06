<?php
// Start the website
session_start();

// Check if the user is logged in or not
if (isset($_SESSION['username'])) { // User is already logged in
    header("Location: html/home.html");
    exit();
} else { // User is mot logged in
    header("Location: html/login.html");
    exit();
}
?>