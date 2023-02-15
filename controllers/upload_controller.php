<?php
require_once(__DIR__ . "\\.\\..\\config.php");
require_once(__DIR__ . "\\.\\validation.php");
require_once(__DIR__ . "\\.\\..\\models\\ResourceModel.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// User not logged in
if (!array_key_exists("user_data", $_SESSION)) {
    header("Location: " . Config::SITE_URL);
    exit();
}
// Validation list for login form validation
$validation_list = $ValidationConfig["upload_file_validation_list"];
// Validation
$validation_res = validate_list($validation_list, array_merge($_POST, $_FILES));

if($validation_res["has_error"]) {
    // Errors when trying to login
    header(
            "Location: ".Config::SITE_URL."?route=upload_file&errors=" . 
                urlencode(serialize($validation_res["errors"])) .
                "&prev_values=" .
                urlencode(serialize($_POST)));
    exit();
} else {
    // Successfull upload
        $ext = pathinfo(strlen($_POST["filename"]) > 0 ? $_POST["filename"] : $_FILES["fileToUpload"]["name"],
         PATHINFO_EXTENSION);

    // Autoextract
    if(isset($_POST["extractArchive"]) && $ext == "zip") {
        $zip = new ZipArchive();
        $zip->open($_FILES["fileToUpload"]["tmp_name"]);
        $zip->extractTo(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
            (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . "\\");
        $zip->close();
    } else {
        move_uploaded_file(
            $_FILES["fileToUpload"]["tmp_name"],
            CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
            (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . "\\" .
            (strlen($_POST["filename"]) > 0 ? $_POST["filename"] : $_FILES["fileToUpload"]["name"])
        );
    }
    header("Location: ".Config::SITE_URL."?route=folder_view&path=".(isset($_REQUEST["path"]) ? $_REQUEST["path"] : ""));
    exit();
}

?>