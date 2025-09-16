<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ICT Research Hub | Upload</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <style>
        body {
            font-family: 'Segioe UI', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background: #f3defe;
            border-radius: 10px;
            padding: 50px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        pre {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 6px;
            text-align: left;
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Upload PDF</h2>
        <pre>
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
if (move_uploaded_file($file["tmp_name"], $targetFile)) {
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
</pre>
    </div>
</body>

</html>