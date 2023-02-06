<form id="login" method="POST" enctype="multipart/form-data" action="
    <?php 

// Load url from config 
        require_once(__DIR__."\\..\\config.php");
        echo Config::SITE_URL."/controllers/upload_controller.php?path=".
        (isset($_REQUEST["path"])?$_REQUEST["path"]:"")
        ?>">
        <h2>Качи файл</h2>
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
        "filename" => array("label" => "Изберете име на файла:", "type" => "text", "required" => False),
        "fileToUpload" => array("label" => "Изберете файл за качване:", "type" => "file", "required" => True ),
    );
    // Create form
    append_form_html($fields_data, $prev_values, $errors);
    ?>
    <button type="submit">Upload File</button>
</form>