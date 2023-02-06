<div id="register">
<h2>Регистрация</h2>
<form id="registration_form" method="POST" action="
<?php 
// Load url from config 
require_once(__DIR__."\\..\\config.php");
echo Config::SITE_URL."/controllers/register_controller.php"; 
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
        "username" => array("label" => "Потребителско име", "type" => "text", "required" => True),
        "email" => array("label" => "Имейл", "type" => "email", "required" => True),
        "full_name" => array("label" => "Имена", "type" => "text", "required" => True),
        "password" => array("label" => "Парола", "type" => "password", "required" => True),
        "password_repeat" => array("label" => "Повторете паролата", "type" => "password", "required" => True),
    );
    // Create form
    append_form_html($fields_data, $errors, $prev_values);
    ?>
    <button type="submit">Register</button>
</form>
</div>