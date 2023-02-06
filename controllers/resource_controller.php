<?php


require_once(__DIR__."\\..\\config.php");
require_once(__DIR__."\\..\\models\\ResourceModel.php");
function getUserNameFromURL($path) {
    $i = strpos($path, "tmp");
    $str1 = substr($path, $i);
    $i2 = strpos($str1, "/");
    $str2 = substr($str1, $i2+1);
    $i3 = strpos($str2, "/");
    $str3 = substr($str2, 0, $i3);
    return $str3;
}
function get_data_uri($image, $mime = '') {
	return 'data: '.(function_exists('mime_content_type') ? mime_content_type($image) : $mime).';base64,'.base64_encode(file_get_contents($image));
}
function get_pdf_uri($file, $mime = '') {
	return 'data:application/pdf;base64,'.base64_encode(file_get_contents($file));
}
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// User not logged in
if (!array_key_exists("user_data", $_SESSION)) {
    header("Location: ".Config::SITE_URL);
    exit();
}
$names = [];
// Get user directory names on folder view
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET' && $_REQUEST["route"]=="folder_view") {
    // Path has been passed
    if (isset($_REQUEST["path"])) {
        $names = ResourceModel::list_dir($_SESSION["user_data"]["username"], "\\".$_REQUEST["path"]);
    } else {
        $names = ResourceModel::list_dir($_SESSION["user_data"]["username"], "");
    }
}
?>