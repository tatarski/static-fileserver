<?php


require_once(__DIR__ . "\\.\\..\\config.php");
require_once(".\\validation.php");
require_once(".\\..\\models\\UserModel.php");


if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Validation array for register form
$validation_list = $ValidationConfig["registration_validation_list"];
// Validation
$validation_res = validate_list($validation_list, $_POST);
if($validation_res["has_error"] || !passwords_match($_POST["password"], $_POST["password_repeat"])) {
    // Errors when trying to register
    if(!passwords_match($_POST["password"], $_POST["password_repeat"])) {
        array_push($validation_res["errors"]["password"], "Паролите не съвпадат");
    }
    header(
            "Location: ".Config::SITE_URL."?route=register&errors=" . 
                urlencode(serialize($validation_res["errors"])) .
                "&prev_values=" .
                urlencode(serialize($_POST)));
    exit();
} else {
    // Successfull register
    // Hash password
    $_POST["hashed_password"] = password_hash($_POST["password"],  PASSWORD_DEFAULT);
    unset($_POST["password"]);
    unset($_POST["password_repeat"]);

    // Insert new user into database
    call_user_func_array("UserModel::insert", $_POST);
    $_SESSION["user_data"] = $_POST;

    // Redirect to root folder folder view
    header("Location: ".Config::SITE_URL."?route=folder_view");
    exit();
}
?>