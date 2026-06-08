<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$files = glob("*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);
$imageFiles = [];

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];

foreach ($files as $file) {
    if (basename($file) !== 'index.html' && basename($file) !== 'gallery.html') {
        $imageFiles[] = [
            'name' => basename($file),
            'url' => $protocol . $host . '/' . basename($file),
            'size' => filesize($file),
            'modified' => filemtime($file)
        ];
    }
}

usort($imageFiles, function($a, $b) {
    return $b['modified'] - $a['modified'];
});

echo json_encode($imageFiles);
?>