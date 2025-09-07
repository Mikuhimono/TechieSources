<?php
header("Content-Type: application/json");
$dataFile = __DIR__ . "/data/users.json";

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) { echo json_encode(["error" => "No input"]); exit; }

$username = trim($input["username"]);
$password = $input["password"];

$users = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

foreach ($users as $u) {
    if (($u["username"] === $username || $u["email"] === $username) && password_verify($password, $u["password"])) {
        session_start();
        $_SESSION["username"] = $u["username"];
        echo json_encode(["success" => true, "user" => $u]);
        exit;
    }
}

echo json_encode(["error" => "Invalid username or password"]);
?>