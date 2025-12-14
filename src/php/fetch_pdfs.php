<?php
$search = $_GET['search'] ?? ''; // optional search string from query
$year = $_GET['year'] ?? ''; // optional year filter
$data = [];

if (file_exists("../pdf_data.json")) { // JSON file acts as a tiny database
    $json = file_get_contents("../pdf_data.json"); // load metadata
    $data = json_decode($json, true); // parse into PHP array
}

// Filter based on contains(search) and exact year
$filtered = array_filter($data, function($item) use ($search, $year) {
    return (empty($search) || stripos($item["title"], $search) !== false) &&
    (empty($year) || $item['year'] == $year);
});

echo json_encode(array_values($filtered)); // return JSON to frontend
?>