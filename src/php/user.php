<?php
header("Content-Type: application/json");
session_start();
if (!isset($_SESSION["username"])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$dataFile = __DIR__ . "/data/users.json";
$users = json_decode(file_get_contents($dataFile), true); // Check the data/users.json

foreach ($users as $u) {
    if ($u["username"] === $_SESSION["username"]) {
        echo json_encode(["user" => $u]);
        exit;
    }
}

echo json_encode(["error" => "User not found"]);
?>