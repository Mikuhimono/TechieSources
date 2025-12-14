<?php
// Path to JSON and uploads folder
$jsonFile = __DIR__ . '/../src/pdf_data.json';
$uploadsDir = __DIR__ . '/../src/uploads/';

// Read JSON data
if (!file_exists($jsonFile)) {
    die("❌ pdf_data.json not found.");
}

$jsonData = file_get_contents($jsonFile);
$pdfList = json_decode($jsonData, true);

if ($pdfList === null) {
    die("❌ Failed to decode pdf_data.json.");
}

// Extract filenames from JSON
$jsonFiles = array_map(fn($pdf) => $pdf['filename'], $pdfList);

// Get all PDF files in uploads folder
$uploadFiles = array_filter(scandir($uploadsDir), fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'pdf');

// --- CHECKS ---
// Missing files: in JSON but not in uploads
$missingInUploads = array_filter($jsonFiles, fn($f) => !file_exists($uploadsDir . $f));

// Extra files: in uploads but not in JSON
$extraInUploads = array_filter($uploadFiles, fn($f) => !in_array($f, $jsonFiles));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TechieSources | Missing PDF Checker</title>
    <link rel="icon" type="image/png" href="../src/images/icon.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 70%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .missing {
            color: red;
        }

        .extra {
            color: orange;
        }
    </style>
</head>

<body>
    <h2>PDF Consistency Checker</h2>

    <h3>❌ Missing in /uploads (listed in JSON but file not found):</h3>
    <?php if (empty($missingInUploads)): ?>
        <p style="text-align:center;">✅ No missing files.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Filename</th>
            </tr>
            <?php foreach ($missingInUploads as $file): ?>
                <tr>
                    <td class="missing"><?= htmlspecialchars($file) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h3>⚠️ Extra in /uploads (file exists but not listed in JSON):</h3>
    <?php if (empty($extraInUploads)): ?>
        <p style="text-align:center;">✅ No extra files.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Filename</th>
            </tr>
            <?php foreach ($extraInUploads as $file): ?>
                <tr>
                    <td class="extra"><?= htmlspecialchars($file) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>

</html>