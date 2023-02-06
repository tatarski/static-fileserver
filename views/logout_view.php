
<form method="POST" action="
<?php

// Load url from config 
require_once(__DIR__ . "\\..\\config.php");
echo Config::SITE_URL . "/controllers/logout_controller.php";
?>">
    <button action="submit">Излез от профил</button>
</form>