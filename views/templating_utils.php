<?php
// Html error template
function construct_errors_html($field_name, $errors)
{
    if (array_key_exists($field_name, $errors)) {
        $str = "";
        foreach ($errors[$field_name] as $err) {
            $str .= "<div class=\"error\">$err</div>";
        }
        return $str;
    } else {
        return "";
    }
}
// Creates html form based on $fields data assoc array
// Include errors and prev values in html
function append_form_html($fields_data, $prev_values, $errors)
{
    if (isset($_REQUEST["errors"])) {
        $errors = unserialize($_REQUEST["errors"]);
    }
    if (isset($_REQUEST["prev_values"])) {
        $prev_values = unserialize($_REQUEST["prev_values"]);
    }
    foreach ($fields_data as $field => $params) {
        echo "<div>" .
            "<label for=\"$field\">" . $params["label"] . "</label>" .
            "<input 
                    type=" . $params["type"] . " 
                    id=\"$field\" 
                    name=\"$field\" 
                    placeholder=\"" . $params["label"] . "\"" .
            "value = \"" . (array_key_exists($field, $prev_values) ? $prev_values[$field] : "") . "\"" .
            ($params["required"] ? " required" : "") .
            ">" .
            construct_errors_html($field, $errors) .
            "</div>";
    }
}
?>