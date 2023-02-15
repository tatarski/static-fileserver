<?php

function validate_recursive($path, $substructure_json) {
    // print_r($path);
    // echo "\n";
    // print_r($substructure_json);
    // echo "\n";
    if(!file_exists($path)) {
        return false;
    }
    $cur_regex = "/" . $substructure_json["regex"] . "/";
    $cur_basename = pathinfo($path, PATHINFO_BASENAME);
    if(!is_dir($path)) {
        // print_r("FILE VALIDATION, RES:");
        // print_r(preg_match($cur_regex, $cur_basename)?"YES":"NO");
        // echo "\n";
        return preg_match($cur_regex, $cur_basename);
    }
    $cur_dir_files = scandir($path);
    array_shift($cur_dir_files);
    array_shift($cur_dir_files);
    if (!preg_match($cur_regex, $cur_basename)) {
        return false;
    }
    if (!isset($substructure_json["children"])) {
        return true;
    }
    foreach ($cur_dir_files as $fname) {
        $passes_any = false;
        foreach ($substructure_json["children"] as $child_json) {
            $passes_any = $passes_any || validate_recursive($path . "\\" . $fname, $child_json);
        }
        if (!$passes_any) {
            return false;
        }
    }
    return true;
}
function validateDirectoryTree($mode = "Some", $root_path, $structure_json) {

}


// $json_str = TemplateModel::select_template_by_name("basic_template")["template_json"];
// $json_str = stripslashes(html_entity_decode($json_str));
// $json = json_decode($json_str, true);
// print_r($json);
// // print_r($json_str);
// print_r(validate_recursive(realpath("..\\tmp\\ADMIN\\basedir"), $json));
?>