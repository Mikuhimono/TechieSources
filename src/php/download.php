<?php
$filename = $_GET['file']; // Find file
$filepath = "../src/uploads/" . basename($filename); // Folder where files are stored

// Check if file exists
if (file_exists($filepath)) {
    // Send headers to tell browser to download instead of display
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
    
    // Read file and output to browser
    readfile($filepath);
    exit;
} else {
    echo "File not found."; // If the files didn't exist
}