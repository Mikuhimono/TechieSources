<?php

/* (⚠ FOR ANDROID/iOS) 
Phone browsers often don’t have a full PDF viewer they can’t render inline, 
so they automatically download instead. */
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Disable for Android/iOS Phone
if (preg_match('/(android|iphone|ipad|ipod|blackberry|windows phone)/i', $userAgent)) {
    die("Access to this device is not allowed to view the RRL");
}
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = "../uploads/" . $filename;

    if (file_exists($filepath)) {
        header('Content-Type: application/pdf'); // force PDF response
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        echo "File not found.";
        }
    } else {
        echo "No file specified.";
    }
?>