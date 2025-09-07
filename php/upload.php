<?php
 
$dataFile = "../pdf_data.json"; // where the files stored
// Expecting fields: title, year, and pdf_file
$title = $_POST['title'];
$year = $_POST['year'];
$file = $_FILES['pdf_file'];

// Basic MIME/type check (improve in production)
if ($file['type'] != "application/pdf") {
    die("Only PDF files are allowed.");
}

// Target path
$targetDir = "../uploads/";
$filename = basename($file["name"]);
$targetFile = $targetDir . $filename;

// Duplicate checker
foreach (scandir($targetDir) as $existingFile) {
    if (pathinfo($existingFile, PATHINFO_EXTENSION) === 'pdf') {
        if (md5_file($targetDir . $existingFile) === md5_file(filename: $file["tmp_name"])) {
            die("This RRL is already in the website. Please upload another RRL.");
        }
    }
}

// include_once("review_pdfs.php");

// Move upload file
if (move_uploaded_file($file["tmp_name"] , $targetFile)) {
    $entry = [
        "title" => $title,
        "year" => $year,
        "filename" => $filename,
        "uploaded_at" => date("Y-m-d H:i:s")
    ];

    // Update pdf_data.json
    $data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
    $data[] = $entry;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
    echo "Upload successful.";
} else {
    echo "Upload failed. Try again!";
}
?>