<?php
require_once(__DIR__ . "\..\config.php");
require_once(__DIR__ . "\DBMS.php");
require_once(__DIR__ . "\AnyModel.php");
class ResourceModel extends AnyModel
{
    // List dir contents
    public static function list_dir(string $username, string $path_for_user) {
        return scandir(Config::ROOT_FOLDER . "\\tmp\\" . $username . $path_for_user);
    }
    public static function file_exists(string $username, string $local_path) {
        return file_exists(Config::ROOT_FOLDER . "\\tmp\\" . $username . $local_path);
    }
}
?>