<?php
require_once(__DIR__ . "\\.\\..\\config.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['path'])) {
    $filename = Config::SITE_URL . "/tmp/" . $_SESSION["user_data"]["username"] . "" .
        str_replace("/", "/", $_REQUEST['path']);

    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: utf-8");
    header("Content-disposition: attachment; filename=\"" . basename($filename) . "\"");
    readfile($filename);
    exit();
} else {
    echo "Filename is not defined.";
}
?>