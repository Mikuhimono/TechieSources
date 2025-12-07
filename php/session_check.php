<?php
session_start();
header("Content-Type: application/json");

// If not logged in
if (!isset($_SESSION["username"])) {
    echo json_encode([
        "status" => "not_logged_in"
    ]);
    exit;
}

// If role is missing, default to user
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "user";

echo json_encode([
    "status" => "logged_in",
    "username" => $_SESSION["username"],
    "role" => $role
]);
exit;
?>