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

function file_size_constraint($file, $max_size_bites) {
    return $file["size"] < $max_size_bites;
}

function file_not_exists($file) {
    // return !file_exists(Config::ROOT_FOLDER."\\tmp\\.".$_SESSION["user_data"]["username"]."\\".$file["name"]);
    return !file_exists(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        str_replace("/", "\\", (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "")) . "\\" .
        (strlen($_POST["filename"]) > 0 ? $_POST["filename"] : $_FILES["fileToUpload"]["tmp_name"]));
}

// Validation list for login form validation
$validation_list = array(
    "filename" => [
        array(
            "error_message" => "Името на файла трябва да бъде най-много 30 символа",
            "validate" => bind_partial_last('is_str_len_in_range', 0, 30)
        ),
    ],
    "fileToUpload" => [
        array(
            "error_message" => "Файлът с това име вече съществува.",
            "validate" => bind_partial_last('file_not_exists')
        ),
        array(
            "error_message" => "Файлът трябва да бъде по-малък от 30 килобайта.",
            "validate" => bind_partial_last('file_size_constraint',30720)
        ),
    ]
);
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
    move_uploaded_file(
        $_FILES["fileToUpload"]["tmp_name"],
        CONFIG::ROOT_FOLDER."\\tmp\\" . $_SESSION["user_data"]["username"] . "\\".
        (isset($_REQUEST["path"])?$_REQUEST["path"]:"") . "\\".
        (strlen($_POST["filename"]) > 0 ? $_POST["filename"] : $_FILES["fileToUpload"]["name"]));

    header("Location: ".Config::SITE_URL."?route=folder_view&path=".(isset($_REQUEST["path"]) ? $_REQUEST["path"] : ""));
    exit();
}

?>