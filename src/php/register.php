<?php
session_start();
// Register
header("Content-Type: application/json");
$dataFile = __DIR__ . "/data/users.json";

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
    echo json_encode(["error" => "No input"]);
    exit;
}

$username = trim($input["username"]);
$password = $input["password"];
$email = trim($input["email"]);

$users = file_exists($dataFile)
    ? json_decode(file_get_contents($dataFile), true)
    : [];

if (!is_array($users)) $users = [];

// DEVICE IDENTIFICATION
$deviceFingerprint = hash(
    'sha256',
    ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown') .
    ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0')
);

// DEVICE LIMIT: MAX 3 ACCOUNTS PER DEVICE
$deviceCount = 0;
foreach ($users as $u) {
    if (isset($u["device_id"]) && $u["device_id"] === $deviceFingerprint) {
        $deviceCount++;
    }
}

if ($deviceCount >= 3) {
    echo json_encode([
        "error" => "This device has reached the maximum of 3 accounts"
    ]);
    exit;
}

foreach ($users as $u) {
    if ($u["username"] === $username || $u["email"] === $email) {
        echo json_encode(["error" => "Username or email already taken"]);
        exit;
    }
}

$newUser = [
    "id" => uniqid("u_"),
    "username" => $username,
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT),
    "nickname" => $username,
    "profile_pic" => "/images/starter.png",
    "created" => date("c"),
    "role" => "user",
    "device_id" => $deviceFingerprint
];

$users[] = $newUser;
file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));

$_SESSION["username"] = $username;

echo json_encode(["success" => true, "user" => $newUser]);
?>
