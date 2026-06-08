<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$files = glob("*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);
$deleted = 0;

foreach ($files as $file) {
    $basename = basename($file);
    if ($basename !== 'index.html' && $basename !== 'gallery.html') {
        if (unlink($file)) {
            $deleted++;
        }
    }
}

echo json_encode(['status' => 'success', 'deleted_count' => $deleted]);
?>