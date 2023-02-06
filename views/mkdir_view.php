<form id="login" method="POST" action="

    <?php 

// Load url from config 
        require_once(__DIR__."\\..\\config.php");
        echo Config::SITE_URL."/controllers/mkdir_controller.php?path=".
        (isset($_REQUEST["path"])?$_REQUEST["path"]:"/")
        ?>">

    <h2>Създай Директория</h2>
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
        "dirname" => array("label" => "Име на директорията", "type" => "text", "required" => True),
    );
    // Create form
    append_form_html($fields_data, $prev_values, $errors);
    ?>
    <button type="submit">Създай директорията</button>
</form>