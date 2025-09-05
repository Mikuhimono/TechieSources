<?php
// Path to JSON and uploads folder
$jsonFile = __DIR__ . '/../pdf_data.json';
$uploadsDir = __DIR__ . '/../uploads/';

// Read JSON data
if (!file_exists($jsonFile)) {
    die("❌ pdf_data.json not found.");
}

$jsonData = file_get_contents($jsonFile);
$pdfList = json_decode($jsonData, true);

if ($pdfList === null) {
    die("❌ Failed to decode pdf_data.json.");
}

$missingFiles = [];

// Check each file
foreach ($pdfList as $pdf) {
    $filePath = $uploadsDir . $pdf['filename'];
    if (!file_exists($filePath)) {
        $missingFiles[] = $pdf['filename'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Missing PDFs Checker</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .ok { color: green; }
        .missing { color: red; }
    </style>
</head>
<body>
    <h2>Missing PDFs Report</h2>
    <?php if (empty($missingFiles)): ?>
        <p class="ok">✅ No missing files. Everything matches.</p>
    <?php else: ?>
        <p class="missing">⚠️ Missing Files Found:</p>
        <table>
            <tr><th>Filename</th></tr>
            <?php foreach ($missingFiles as $file): ?>
                <tr><td><?= htmlspecialchars($file) ?></td></tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
