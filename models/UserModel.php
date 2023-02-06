<?php
require_once(__DIR__ . "\\DBMS.php");
require_once(__DIR__ . "\\AnyModel.php");
class UserModel extends AnyModel
{
    // Inset user into db
    public static function insert(string $username, string $email, string $full_name, string $hashed_password) {
        DBMS::$pdo->exec(
            'INSERT INTO user (username, email, full_name, hashed_password)' .
            "VALUES(\"$username\", \"$email\", \"$full_name\", \"$hashed_password\")"
        );
        // Create user directory
        mkdir(Config::ROOT_FOLDER . "\\tmp\\" . $username);
    }
    // Select user bu given field value array
    public static function select($field_value_arr){
        return parent::get_all_matching_values_query("USER", $field_value_arr);
    }
    // List all users
    public static function list() {
        return parent::get_all("USER");
    }
}
?>