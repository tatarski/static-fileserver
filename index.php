<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filemeup</title>
    <link rel="stylesheet" href="./views/css/styles.css">
</head>
<body>
<?php
require_once(__DIR__ . "\config.php");
require_once(__DIR__ . "\models\\UserModel.php");
echo "<h1><a href=\"" . Config::SITE_URL . "\">Filemeup</a></h1>";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (array_key_exists("user_data", $_SESSION)) {
    // User is logged in
    if(!array_key_exists("user_full_data", $_SESSION)) {
        $_SESSION["user_full_data"] = UserModel::select(array("username" => $_SESSION["user_data"]["username"]))[0];
    }

        include Config::ROOT_FOLDER . "\\views\\navigation.php";
    // If no route - folder view by default
    if (!isset($_REQUEST["route"])) {
        header("Location: " . Config::SITE_URL . "?route=folder_view");
        exit();
    } else {
        if ($_REQUEST["route"] == "folder_view") {
            // Folder view
            include "./views/folder_view.php";
        } elseif ($_REQUEST["route"] == "file_view") {
            // FIlve view
            include "./views/file_view.php";
        } elseif ($_REQUEST["route"] == "upload_file") {
            // FIlve view
            include "./views/upload_view.php";
        } elseif ($_REQUEST["route"] == "mkdir") {
            include "./views/mkdir_view.php";
        } elseif ($_REQUEST["route"] == "list_templates") {
            include "./views/templates_list.php";
        } elseif ($_REQUEST["route"] == "view_template") {
            include "./views/templates_view.php";
        } elseif ($_REQUEST["route"] == "create_template") {
            include "./views/create_template_view.php";
        }
    }
} else {
    // Register controller
    if (isset($_REQUEST["route"]) && $_REQUEST["route"] == "register") {
        include "./views/register_view.php";
        exit();
    }
    // Login controller
    if (isset($_REQUEST["route"]) && $_REQUEST["route"] == "login") {
        include "./views/login_view.php";
        exit();
    }
    // Homepage - register or login
    if (!isset($_REQUEST["route"]) || ($_REQUEST["route"] != "login" && $_REQUEST["route"] != "register")) {
        include "./views/register_view.php";
        include "./views/login_view.php";
    }
}
?>
</body>
</html>