<div id="login">
<h2>Създай шаблон</h2>
<form id="create_template_form" method="POST" action="
<?php 
// Load url from config 
require_once(__DIR__."\\..\\config.php");
echo Config::SITE_URL."/controllers/create_template_controller.php"; 
?>">
    <?php
    require_once(__DIR__."\\..\\config.php");
    require_once(__DIR__."\\templating_utils.php");

    $errors = array();
    $prev_values = array();
    // Load previous errors/ values from request
    if (isset($_REQUEST["errors"])) {
        $errors = unserialize($_REQUEST["errors"]);
    }
    if (isset($_REQUEST["prev_values"])) {
        $prev_values = unserialize($_REQUEST["prev_values"]);
    }
    // Data for form creation
    $fields_data = array(
        "template_name" => array("label" => "Име на шаблона", "type" => "text", "required" => True),
        "template_json" => array("label" => "JSON структура на шаблона", "type" => "textarea", "required" => True),
    );
    // Create form
    append_form_html($fields_data, $errors, $prev_values);
    ?>
    <button type="submit">Създай Шаблон</button>
</form>
</div>