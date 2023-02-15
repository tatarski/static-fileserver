<?php
require_once(__DIR__ . "\\.\\..\\config.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}

if (isset($_REQUEST['path']) || isset($_REQUEST['name'])) {
    if(is_file(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . $_REQUEST['name'])) {
            unlink(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . $_REQUEST['name']);
        }
    rrmdir(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . $_REQUEST['name']);

        print_r(CONFIG::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
        (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . $_REQUEST['name']);
    header("Location: ".Config::SITE_URL."?route=folder_view&path=".(isset($_REQUEST["path"]) ? $_REQUEST["path"] : ""));
    exit();
} else {
    echo "Filename is not defined.";
}
?>