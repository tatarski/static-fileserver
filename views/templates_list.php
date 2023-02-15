<ol class="templates_list" id="login">
    <h2>Списък от шаблони:</h2>
<?php
require_once(__DIR__ . "\\..\\config.php");
require_once(__DIR__ . "\\templating_utils.php");
require_once(__DIR__ . "\\..\\models\\TemplateModel.php");

$templates = TemplateModel::list();
foreach ($templates as $t) {
    $template_view_url = Config::SITE_URL . "?route=view_template&name=" . $t["template_name"];
    echo "<a href=\"$template_view_url\"> <li>" . $t["template_name"] . "</li></a>";
}

$url = Config::SITE_URL . "?route=create_template";
echo "<a href =\"$url\"> <button>Създай шаблон</button> </a>";

?>
</ol>
