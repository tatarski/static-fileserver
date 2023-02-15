<?php

function is_filename($str)
{
    return preg_match("/^.*\..*$/", $str);
}
if(!isset($_REQUEST["path"])) {
    $_REQUEST["path"] = ".";
}
require_once(__DIR__ . "\\..\\config.php");
require_once(__DIR__ . "\\templating_utils.php");
require_once(__DIR__ . "\\..\\controllers\\resource_controller.php");
require_once(__DIR__ . "\\..\\controllers\\template_check_controller.php");
require_once(__DIR__ . "\\..\\models\\TemplateModel.php");
require_once(__DIR__ . "\\..\\models\\HasTemplateModel.php");
// Construct html for folder view
// $names is array of file_paths
$cur_path = isset($_REQUEST["path"]) ? $_REQUEST["path"] . "\\" : "";
echo "<h2 id=\"directory_path\">Текущ път:  " . str_replace("/", "\\",$cur_path) . "</h2>";

echo "<div id=\"files\">";
echo "<div class=\"file\"><span>Име</span><span>Размер</span><span>Тип</span><span></span><span>Шаблон</span><span></span></div>";
foreach ($names as $str) {
    // Requested path in user tmp directory
    if ($str == ".") {
        // Redirect to current dir
        $img_url = Config::SITE_URL . "/views/icons/icur.png";
        echo ("<div class=\"file\">
                <a href=\"#\"><img src=\"$img_url\" style=\"width:30px;\">. (текуща дир.) </a>
            </div>");
    } elseif ($str == "..") {
        // Redirect to parent dir
        if (isset($_REQUEST["path"]) && strlen(dirname($_REQUEST["path"])) > 0) {
            // Parent dir exists
            $img_url = Config::SITE_URL . "/views/icons/iback.png";
            echo "<div class=\"file\"><a href=\"" . Config::SITE_URL . "?route=folder_view&path=" .
                dirname($_REQUEST["path"]) . "\"><img src=\"$img_url\" style=\"width:30px;\">.. (назад)</a></div>";
        } else {
            $img_url = Config::SITE_URL . "/views/icons/iback.png";
            // Parent dir does not exist
            echo "<div class=\"file\"><a href=\"" . Config::SITE_URL . "?route=folder_view\"><img src=\"$img_url\" style=\"width:30px;\">.. (назад)</a></div>";
        }
    } else {
        if (
            is_filename($str) ||
            !is_dir(
                Config::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
                (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . "\\" . $str
            )
        ) {
            // If cur path is file
            // Redirect to file_view
            $redirect_link = Config::SITE_URL . "?route=file_view&path=" . $cur_path . $str;
        } else {
            // If cur path is folder
            // Redirect to file_view
            $redirect_link = Config::SITE_URL . "?route=folder_view&path=" . $cur_path . $str;
        }
        $cur_p = Config::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
            (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . "\\" . $str;

        $is_dir = !is_dir(
            Config::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
            (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . "\\" . $str
        );


        // Select icon for cur file
        $icon_url = Config::SITE_URL."/views/icons/ifile.png";
        
        if(!$is_dir) {
            $icon_url = Config::SITE_URL."/views/icons/idir.png";
        }
        $ext = pathinfo($str, PATHINFO_EXTENSION);
        if($ext == "jpg" || $ext == "jpeg") {
            $icon_url = Config::SITE_URL."/views/icons/ijpg.png";
        }
        if($ext == "png") {
            $icon_url = Config::SITE_URL."/views/icons/ijpg.png";
        }
        if($ext == "pdf") {
            $icon_url = Config::SITE_URL."/views/icons/ipdf.png";
        }
        if($ext == "txt") {
            $icon_url = Config::SITE_URL."/views/icons/itxt.png";
        }
        $delete_url = Config::SITE_URL . "/controllers/delete.php?path=" .
                (strlen($cur_path) > 0?$cur_path:"") ."&name=" . $str;

        // Select folder template
        $select_template_form_url = Config::SITE_URL . "/controllers/add_template_controller.php?";
        $select_template_form = 
            "<form class=\"sel_temp\" action=\"$select_template_form_url\"><select name=\"template_name\" id=\"select_template\">";
        $template_data_list = TemplateModel::list();
        $select_template_form .= "<option value=\"Няма шаблон\">Няма шаблон</option>";

        // If any pattern on current dir present - selected by default in form
        $template_format_dir_path = "\\".$_SESSION["user_data"]["username"]."\\".$_REQUEST["path"]."\\".$str;
        $cur_template_name = "Няма шаблон";
        if(!$is_dir && HasTemplateModel::exists($template_format_dir_path)) {
            $cur_template_id = HasTemplateModel::get_template($template_format_dir_path)["template_id"];
            $cur_template_name = TemplateModel::get_all_matching_values_query("templates", array("id"=>$cur_template_id))[0]["template_name"];
        }
        // Construct template select form
        foreach($template_data_list as $template_data) {
            $select_template_form .= "<option ".
            ($cur_template_name == $template_data["template_name"]?"selected":"")
            ." value=\"".$template_data["template_name"]."\">".$template_data["template_name"]."</option>";
        }

        $select_template_form .= "<input style=\"display:none\" name=\"path\" value=\"".$cur_path . $str."\"/>";
        $select_template_form .= "</select><button type=\"Submit\">Go</button></form>";


        if ($cur_template_name != "Няма шаблон") {
            $cur_template = TemplateModel::select_template_by_name($cur_template_name);

            $json_str = stripcslashes(html_entity_decode($cur_template["template_json"]));
            $json_structure = json_decode($json_str, true);
            $cur_path_ = realpath(Config::ROOT_FOLDER ."\\tmp". $template_format_dir_path);
            // print_R($json_structure);
            $validation_res = validate_recursive($cur_path_, $json_structure);
            if($validation_res) {
                $select_template_form .= "<span id=\"pass\">ПАСВА</span>"  ;
            } else {
                $select_template_form .= "<span id=\"nopass\">НЕ ПАСВА</span>"  ;
            };
        } else {
            $select_template_form .= "<span></span>"  ;
        }
        // Current file/folder html representation
        echo ("<div class=\"file\">
                <a style=\"max-height:10px;\" href=\"$redirect_link\"><img src=\"$icon_url\" style=\"width:20px;\"><span style=\"display:inline-block;padding-botton:40px;\">$str</span></a>" .
                ($is_dir?"<span> Размер: ".filesize($cur_p)."B"."</span>":"<span></span>").
                ($is_dir?"<span> Тип: ".$ext."</span>":"<span></span>").
            ($is_dir ? ("<a href=\"" . Config::SITE_URL . "/controllers/download.php?path=./" .
                str_replace("\\", "/", $cur_path . $str)
                . "\"> Свали </a>") : "<span></span>") .
                (!$is_dir ? $select_template_form : "<span></span><span></span>").
                "<a id=\"delete\" href=\"$delete_url\">Изтрий</a>".
                "</div>");
    }
}

echo "</div>";
?>