<?php

require_once(__DIR__ . "\\.\\..\\config.php");
require_once(__DIR__ . "\\.\\validation.php");
require_once(__DIR__ . "\\.\\..\\models\\UserModel.php");

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Cheeck if user exists
function user_exists($username) {
    return count(UserModel::select(array("username" => $username))) != 0;
}
// Check if credentials are correct
function password_matches_username($password, $username) {
    $res = UserModel::select(array("username" => $username));
    if(count($res) == 0) {
        return True;
    }
    $usr = $res[0];
    return password_verify($password, $usr["hashed_password"]);
}
// Validation list for login form validation
$validation_list = $ValidationConfig["login_validation_list"];
// Validation
$validation_res = validate_list($validation_list, $_POST);

if($validation_res["has_error"] || !password_matches_username($_POST["password"], $_POST["username"])) {
    // Errors when trying to login
    if(!password_matches_username($_POST["password"], $_POST["username"])) {
        array_push($validation_res["errors"]["password"], "Потребителят не съществува или паролата е неправилна.");
    }
    header(
            "Location: ".Config::SITE_URL."?route=login&errors=" . 
                urlencode(serialize($validation_res["errors"])) .
                "&prev_values=" .
                urlencode(serialize($_POST)));
    exit();
} else {
    // Successfull login
    $_SESSION["user_data"] = $_POST;
    header("Location: ".Config::SITE_URL."?route=folder_view");
    exit();
}
?>