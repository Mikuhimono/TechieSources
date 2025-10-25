<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: html/home.html");
    exit();
} else {
    header("Location: html/login.html");
    exit();
}
