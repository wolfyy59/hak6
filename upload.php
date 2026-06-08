<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $targetDir = __DIR__ . '/';
    $originalName = basename($_FILES['photo']['name']);
    $filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $originalName);
    $targetPath = $targetDir . $filename;
    
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
        chmod($targetPath, 0644);
        
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $fileUrl = $protocol . $host . '/' . $filename;
        
        echo json_encode([
            'status' => 'success',
            'filename' => $filename,
            'file_url' => $fileUrl
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save file']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No photo uploaded']);
}
?>