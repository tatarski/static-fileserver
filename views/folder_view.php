<?php

function is_filename($str)
{
    return preg_match("/^.*\..*$/", $str);
}
require_once(__DIR__ . "\\..\\config.php");
require_once(__DIR__ . "\\templating_utils.php");
require_once(__DIR__ . "\\..\\controllers\\resource_controller.php");
// Construct html for folder view
// $names is array of file_paths
$cur_path = isset($_REQUEST["path"]) ? $_REQUEST["path"] . "\\" : "";
echo "<h2 id=\"directory_path\">Текущ път:  " . str_replace("/", "\\",$cur_path) . "</h2>";

echo "<div id=\"files\">";
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
        // Download button and redirect link
        $is_dir = !is_dir(
            Config::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" .
            (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "") . "\\" . $str
        );

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
        echo ("<div class=\"file\">
                <a href=\"$redirect_link\"><img src=\"$icon_url\" style=\"width:30px;\">$str</a>" .
            ($is_dir ? ("<a href=\"" . Config::SITE_URL . "/controllers/download.php?path=./" .
                str_replace("\\", "/", $cur_path . $str)
                . "\"> Свали </a>") : "") . "</div>");


    }
}

echo "</div>";
?>