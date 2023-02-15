<?php


require_once(__DIR__ . "\\.\\..\\config.php");
require_once(".\\validation.php");
require_once(".\\..\\models\\TemplateModel.php");
require_once(".\\..\\models\\HasTemplateModel.php");

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

$path = "\\".$_SESSION["user_data"]["username"]."\\". $_REQUEST["path"];
// Remove template from dir if it has any
if(HasTemplateModel::exists($path)) {
    print_r("Removing old template");
    HasTemplateModel::remove_template_from_path($path);
}
// Add new template to dir if such has been selected
if($_REQUEST["template_name"]!="Няма шаблон") {
    HasTemplateModel::insert($_REQUEST["template_name"], $path);
}

$path = explode('\\', $path);
unset($path[1]);
unset($path[2]);
unset($path[3]);
$path = implode('\\', $path);
$path = ".".$path;
header("Location: ".Config::SITE_URL."?route=folder_view&path=".$path);
?>