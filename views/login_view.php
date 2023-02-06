<div id="login">
<h2>Логин</h2>
<form id="login_form" method="POST" action="
    <?php 

// Load url from config 
        require_once(__DIR__."\\..\\config.php");
        echo Config::SITE_URL."/controllers/login_controller.php" 
        ?>">
    <?php 
    require_once(__DIR__."\\..\\config.php");
    require_once(__DIR__."\\templating_utils.php");

    // Load previous errors/ values from request
    $errors = array();
    $prev_values = array();
    if (isset($_REQUEST["errors"])) {
        $errors = unserialize($_REQUEST["errors"]);
    }
    if (isset($_REQUEST["prev_values"])) {
        $prev_values = unserialize($_REQUEST["prev_values"]);
    }
    // Data for form creation
    $fields_data = array(
        "username" => array("label" => "Потребителско име", "type" => "text", "required" => True),
        "password" => array("label" => "Парола", "type" => "password", "required" => True),
    );
    // Create form
    append_form_html($fields_data, $prev_values, $errors);
    ?>
    <button type="submit">Login</button>
</form>
</div>