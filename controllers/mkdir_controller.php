<?php

require_once(__DIR__ . "\\.\\..\\config.php");
require_once(__DIR__ . "\\.\\validation.php");
require_once(__DIR__ . "\\.\\..\\models\\UserModel.php");

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
function file_not_exists($filename) {
    // return !file_exists(Config::ROOT_FOLDER."\\tmp\\.".$_SESSION["user_data"]["username"]."\\".$file["name"]);
    return !file_exists(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        str_replace("/", "\\", (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "")) . "\\" .
        $filename);
}

// Validation list for login form validation
$validation_list = array(
    "dirname" => [
        array(
            "error_message" => "Името вече е заето.",
            "validate" => bind_partial_last('file_not_exists')
        ),
        array(
            "error_message" => "Името на директорията трябва да съдържа между 6 и 30 символа.",
            "validate" => bind_partial_last('is_str_len_in_range', 6, 30)
        ),
        array(
            "error_message" => "Името на директорията трябва да съдържа само малки латински букви и цифри.",
            "validate" => bind_partial_last('test_regex', "/^[a-zA-Z0-9]+$/")
        ),
    ]
);
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