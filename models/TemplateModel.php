<?php
require_once(__DIR__ . "\..\config.php");
require_once(__DIR__ . "\DBMS.php");
require_once(__DIR__ . "\AnyModel.php");

class TemplateModel extends AnyModel
{
    // Check if template with name exists
    public static function exists(string $name) {
        return count(parent::get_all_matching_values_query("TEMPLATES", array("template_name" => $name))) > 0;
    }
    public static function select_template_by_name(string $name) {
        return (parent::get_all_matching_values_query("TEMPLATES", array("template_name" => $name)))[0];
    }
    // Insert template into db
    public static function insert($template_json, string $template_name, int $creator_id) {
        $json_str = json_encode($template_json);
        DBMS::$pdo->exec(
            'INSERT INTO templates (template_json, template_name, template_creator) ' .
            ' VALUES( \''.$json_str.'\', \''.$template_name.'\', '.$creator_id.')'
        );
    }
    public static function list() {
        return parent::get_all_matching_values_query("TEMPLATES", array());
    }

}
?>