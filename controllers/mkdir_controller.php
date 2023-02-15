<?php

require_once(__DIR__ . "\\.\\..\\config.php");
require_once(__DIR__ . "\\.\\validation.php");
require_once(__DIR__ . "\\.\\..\\models\\UserModel.php");

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Validation list for login form validation
$validation_list = $ValidationConfig["mkdir_validation_list"];
// Validation
$validation_res = validate_list($validation_list, $_POST);

if($validation_res["has_error"]) {
    // Errors when trying to login
    header(
            "Location: ".Config::SITE_URL."?route=mkdir&errors=" . 
                urlencode(serialize($validation_res["errors"])) .
                "&prev_values=" .
                urlencode(serialize($_POST)));
    exit();
} else {
    // Successfull mkdir 
    mkdir(Config::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        str_replace("/", "\\", (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "")) . "\\" .
        $_POST["dirname"]);
    header("Location: ".Config::SITE_URL."?route=folder_view&path=".(isset($_REQUEST["path"]) ? $_REQUEST["path"] : ""));
    exit();
}
?>