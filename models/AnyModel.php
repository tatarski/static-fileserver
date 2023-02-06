<?php
require_once(__DIR__."\\DBMS.php");
class AnyModel
{
    public static function query_to_array(string $query) {
        // Query DBMS
        $q = DBMS::$pdo->query($query);
        $list = array();

        // Create list of assoc arrays for each row
        for ($i = 0; $row = $q->fetch(PDO::FETCH_ASSOC); $i++) {
            foreach($row as $key => $value) {
                // echo $key . "         " . $value . " \n";
                $list[$i][$key] = $value;
            }
        }

        return $list;

    }

    // Build and execute query that returns all rows from table=$table_name
    // with conditions that column "$field" is equal to $field_value_arr[$field]
    public static function get_all_matching_values_query(string $table_name, $field_value_arr) {
        // Build query string
        $q_str = "SELECT * FROM $table_name WHERE";
        foreach($field_value_arr as $field => $val) {
            $q_str .= " $field = \"$val\" AND ";
        }
        $q_str .= "TRUE";
        // Query the DBMS
        return AnyModel::query_to_array($q_str);
    }
    public static function get_all(string $table_name) {
        return AnyModel::query_to_array(
            "SELECT * FROM $table_name"
        );
    }
}
?>