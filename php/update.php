<?php
header("Content-Type: application/json");
session_start();

$dataFile = __DIR__ . "/data/users.json"; // Connect the data/users.json
if (!isset($_SESSION["username"])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$users = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : []; // Check the data/users.jsopn
if (!is_array($users)) $users = [];

// Find user
foreach ($users as &$u) {
    if ($u["username"] === $_SESSION["username"]) {
        // Nickname update
        if (!empty($_POST["nickname"])) {
            $u["nickname"] = trim($_POST["nickname"]);
        }

        // Password update
        if (!empty($_POST["new_password"])) {
            if ($_POST["new_password"] === $_POST["confirm_password"]) {
                $u["password"] = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
            } else {
                echo json_encode(["error" => "Passwords do not match"]);
                exit;
            }
        }

        // Profile picture update
        if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
            $filename = $u["username"] . "." . strtolower($ext);
            $uploadDir = __DIR__ . "/../profiles/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $dest = $uploadDir . $filename;

            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $dest)) {
                $u["profile_pic"] = "../profiles/" . $filename;
                $u["profile_pic"] .= "?v=" . time();
            } else {
                echo json_encode(["error" => "Failed to upload file"]);
                exit;
            }
        }

        // Save back
        file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));
        echo json_encode(["success" => true, "user" => $u]);
        exit;
    }
}

echo json_encode(["error" => "User not found"]);
?>