<?php
require_once(__DIR__ . "\..\config.php");
require_once(__DIR__ . "\DBMS.php");
require_once(__DIR__ . "\AnyModel.php");
require_once(__DIR__ . "\TemplateModel.php");

class HasTemplateModel extends AnyModel
{
    public static function exists(string $path) {

        return count(parent::get_all_matching_values_query("has_template", array("dir_path" => str_replace("\\", "\\\\", $path)))) > 0;
    }
    public static function remove_template_from_path(string $path) {
        DBMS::$pdo->exec(
            "DELETE from has_template WHERE dir_path = '".str_replace("\\", "\\\\", $path)."'"
        );
    }
    public static function insert(string $template_name, string $dir_path) {
        $template_id = TemplateModel::select_template_by_name($template_name)["id"];
        DBMS::$pdo->exec(
            'INSERT INTO has_template (dir_path, template_id) ' .
            ' VALUES( \''.str_replace("\\", "\\\\", $dir_path) .'\', \''.$template_id.'\')'
        );
    }
    public static function get_template($path) {
        return parent::get_all_matching_values_query("has_template", array("dir_path"=>str_replace("\\", "\\\\", $path)))[0];
    }

}
?>