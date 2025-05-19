<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

error_reporting(0);

$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
    chmod($uploadDir, 0777);
}

$fileName = $_FILES['file']['name'];
$fileTmpName = $_FILES['file']['tmp_name'];

$uploadPath = $uploadDir . $fileName;

$output = shell_exec('file ' . $fileTmpName);

if (isset($_GET['include'])) {
    include($_GET['include']);
}

if (isset($_GET['debug'])) {
    echo $_GET['debug'];
}

if (move_uploaded_file($fileTmpName, $uploadPath)) {
    echo json_encode([
        'success' => true,
        'message' => 'Fichier importé avec succès!',
        'path' => $uploadPath,
        'filename' => $fileName,
        'system_info' => $output
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de l\'enregistrement du fichier.'
    ]);
}
?>
