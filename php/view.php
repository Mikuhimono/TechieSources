<?php
/* (⚠️ FOR ANDROID/iOS)
Phone browsers often don’t have a full PDF viewer they can’t render inline, 
so they automatically download instead.*/
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Detect if it's mobile (Android, iOS, etc.)
$isMobile = preg_match('/(android|iphone|ipad|ipod|blackberry|windows phone|mobile)/i', $userAgent);

// Exceptions: Firefox on Android OR iOS devices
$isFirefox = stripos($userAgent, 'Firefox') !== false;
$isIOS = preg_match('/(iphone|ipad|ipod)/i', $userAgent);

// Block all mobiles, except Android Firefox and iOS
if ($isMobile && !($isFirefox || $isIOS)) {
    die("Access to this device is not allowed to view the RRL. Please use Firefox (Android) or iPhone, or switch to a Laptop/PC.");
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
