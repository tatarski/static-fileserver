<?php


require_once(__DIR__ . "\\.\\..\\config.php");
require_once(".\\validation.php");
require_once(".\\..\\models\\TemplateModel.php");
require_once(".\\..\\models\\UserModel.php");

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
function check_template_free($str) {
    return !TemplateModel::exists($str);
}

function is_json($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}
// Validation array for register form
$validation_list = array(
    "template_name" => [
        array(
            "error_message" => "Името на шаблона трябва да бъде между 6 и 20 символа.",
            "validate" => bind_partial_last('is_str_len_in_range', 6, 20)
        ),
        array(
            "error_message" => "Името на шаблона трябва да съдържа само малки  и главни латински букви и цифри.",
            "validate" => bind_partial_last('test_regex', "/^[a-zA-Z0-9]+$/")
        ),
        array(
            "error_message" => "Името на шаблона вече е заето.",
            "validate" => bind_partial_last('check_template_free'),
        )
    ],
    "template_json" => [
        array(
            "error_message" => "Въведете правилен json текст.",
            "validate" => bind_partial_last('is_json'),
        )
    ]
);
// Validation
$validation_res = validate_list($validation_list, $_POST);
if($validation_res["has_error"]) {
    // Errors when trying to register
    header(
            "Location: ".Config::SITE_URL."?route=create_template&errors=" . 
                urlencode(serialize($validation_res["errors"])) .
                "&prev_values=" .
                urlencode(serialize($_POST)));
    exit();
} else {
    // Successfull template create

    $usr = UserModel::select(array("username" => $_SESSION["user_data"]["username"]));
    TemplateModel::insert(json_decode($_POST["template_json"]), $_POST["template_name"], $usr[0]["id"]);

    // Redirect to list templates
    header("Location: ".Config::SITE_URL."?route=list_templates");
    exit();
}
?>