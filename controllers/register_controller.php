<?php


require_once(__DIR__ . "\\.\\..\\config.php");
require_once(".\\validation.php");
require_once(".\\..\\models\\UserModel.php");

function check_username_free($username) {
    return count(UserModel::select(array("username" => $username))) == 0;
}
function check_email_free($email) {
    return count(UserModel::select(array("email" => $email))) == 0;
}
function passwords_match($password, $password_repeat) {
    return $password == $password_repeat;
}
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Validation array for register form
$validation_list = array(
    "username" => [
        array(
            "error_message" => "Потребителското име трябва да съдържа между 6 и 30 символа.",
            "validate" => bind_partial_last('is_str_len_in_range', 6, 30)
        ),
        array(
            "error_message" => "Потребителското име трябва да съдържа само малки латински букви и цифри.",
            "validate" => bind_partial_last('test_regex', "/^[a-zA-Z0-9]+$/")
        ),
        array(
            "error_message" => "Потребителското име вече е заето.",
            "validate" => bind_partial_last('check_username_free'),
        )
    ],
    "email" => [
        array(
            "error_message" => "Въведете валиден имейл адрес.",
            "validate" => bind_partial_last('test_regex', "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/")
        ),
        array(
            "error_message" => "Имейлът вече е зает.",
            "validate" => bind_partial_last('check_email_free'),
        )
    ],
    "full_name" => [
        array(
            "error_message" => "Пълното име трябва да съдържа между 2 и 30 символа.",
            "validate" => bind_partial_last('is_str_len_in_range', 2, 30)
        ),
    ],
    "password" => [
        array(
            "error_message" => "Паролата трябва да съдържа между 6 и 20 символа.",
            "validate" => bind_partial_last('is_str_len_in_range', 6, 20)
        ),
        array(
            "error_message" => "Паролата трябва да съдържа поне една малка латинска буква, главна латинска буква и цифра.",
            "validate" => bind_partial_last('test_regex', "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/")
        )
        ],
    "password_repeat" => [
        array(
            "error_message" => "Паролите трябва да съвпадат.",
            "validate" => bind_partial_last('passwords_match', $_POST["password"])
        )
    ]
);
// Validation
$validation_res = validate_list($validation_list, $_POST);
if($validation_res["has_error"]) {
    // Errors when trying to register
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