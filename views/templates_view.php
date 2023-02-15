<div id="login" class="template_view">
    <?php
    require_once(__DIR__ . "\\..\\config.php");
    require_once(__DIR__ . "\\templating_utils.php");
    require_once(__DIR__ . "\\..\\models\\TemplateModel.php");

    function displayJsonAsHtml($json)
    {
        if (is_string($json)) {
            return $json;
        }
        if (is_null($json)) {
            return;
        }
        echo '<div>';
        foreach ($json as $key => $value) {
            $key_ = "<b>" . $key . "</b>";
            if (isset($value[0]) && !is_string($value)) {
                // echo '<div>' . $key_ . ': <b class=\"json_type\">(array)</b> </div>';
            } else {
                if (!is_numeric($key)) {
                    echo '<div>' . $value . ' </div>';
                } else {
                    echo '<div>' . ' </div>';
                }
            }
            if (is_array($value)) {
                displayJsonAsHtml($value);
            }
        }
        echo '</div>';
    }

    $cur_template = TemplateModel::select_template_by_name($_REQUEST["name"]);
    echo "<h2>Име на шаблон: " . $cur_template["template_name"] . "</h2>";
    echo "<h2>Структура: </h2>";

    displayJsonAsHtml(json_decode(stripslashes($cur_template["template_json"]), true));
    $url = Config::SITE_URL . "?route=list_templates";
    echo "<a href =\"$url\"> <button>Назад</button> </a>";
    ?>
</div>
<div id="login">
<?php
echo "<h2>Съдържание:</h2>";
echo "<textarea disabled id=\"template_view_field\">".$cur_template["template_json"]."</textarea>";
?>

</div>
