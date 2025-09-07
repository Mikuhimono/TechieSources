<?php
header("Content-Type: application/json");
$dataFile = __DIR__ . "/data/users.json";

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) { echo json_encode(["error" => "No input"]); exit; }

$username = trim($input["username"]);
$password = $input["password"];
$email = trim($input["email"]);

$users = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
if (!is_array($users)) $users = [];

// Check duplicate
foreach ($users as $u) {
    if ($u["username"] === $username || $u["email"] === $email) {
        echo json_encode(["error" => "Username or email already taken"]);
        exit;
    }
}

// Save new user
$newUser = [
    "id" => uniqid("u_"),
    "username" => $username,
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT),
    "nickname" => $username,
    "profile_pic" => "",
    "created" => date("c")
];

$users[] = $newUser;
file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));

echo json_encode(["success" => true, "user" => $newUser]);
?>