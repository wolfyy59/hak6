<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['filename'])) {
    echo json_encode(['status' => 'error', 'message' => 'No filename provided']);
    exit;
}

$filename = basename($data['filename']);
$filepath = __DIR__ . '/' . $filename;

if (file_exists($filepath) && is_file($filepath)) {
    if (unlink($filepath)) {
        echo json_encode(['status' => 'success', 'message' => 'File deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete file']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'File not found']);
}
?>