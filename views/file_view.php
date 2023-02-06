<div class="file_preview">
    <?php
    require_once(__DIR__."\\..\\config.php");
    require_once(__DIR__."\\..\\controllers\\resource_controller.php");
    $file_name = $_REQUEST["path"];
    $file_type = pathinfo($_REQUEST["path"], PATHINFO_EXTENSION);

    // File metadata
    echo "<h3>Име: $file_name</h2>";
    echo "<h3>Тип: $file_type</h2>";


    // Go to parent dir button
    if (strlen(dirname($file_name)) > 0) {
        echo "<a href=\"".Config::SITE_URL."?route=folder_view&path=" .
            dirname($file_name) . "\"><button>Назад</button></a>";
    } else {
        // Parent dir does not exist
        echo "<a href=\"".Config::SITE_URL."?route=folder_view\">BACK</a>";
    }

    // Download button for cur path
    echo "<a href=\"" . Config::SITE_URL . "/controllers/download.php?path=./" .
        str_replace("\\", "/", $_REQUEST["path"])
        ."\"> <button>Свали </button></a>";

    $file_path = Config::ROOT_FOLDER . "\\tmp\\" . $_SESSION["user_data"]["username"] . "\\" . $_REQUEST["path"];


    if($file_type=="png" || $file_type=="jpg" || $file_type=="jpeg") {
        // Image visualization
        echo "<h3>Преглед:</h3><img class=\"text_preview\"
            src=\"".get_data_uri($file_path)."\"/>;";
    } elseif($file_type == "pdf") {
        echo "<h3>Преглед:</h3><iframe type=\"appliication/pdf\" fileborder=\"0\" id=\"pdf\" src=\"".get_pdf_uri(str_replace("/", "", $file_path))."\"></iframe>";
    } else {
        // Text file visualization
        echo "<h3>Преглед:</h3><textarea cols=\"200\" rows=\"20\" class=\"text_preview\" readonly>";
        echo htmlspecialchars(file_get_contents($file_path));
        echo "</textarea>";
    }
    
    ?>
</div>