<div id="navigation">
    <a href="<?php
    require_once(__DIR__ . "\\..\\config.php");
    echo Config::SITE_URL
        ?>">
        <button>Начало</button>
    </a>
    <?php
    include Config::ROOT_FOLDER . "\\views\\logout_view.php";
    ?>

    <a href="<?php
    require_once(__DIR__ . "\\..\\config.php");
    echo Config::SITE_URL . "?route=upload_file&path=" . (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "/")
        ?>">
        <button>Качи файл</button>
    </a>
    <a href="<?php
    require_once(__DIR__ . "\\..\\config.php");
    echo Config::SITE_URL . "?route=mkdir&path=" . (isset($_REQUEST["path"]) ? $_REQUEST["path"] : "/")
        ?>">
        <button>Създай Директория</button>
    </a>
    <a href="<?php
    require_once(__DIR__ . "\\..\\config.php");
    echo Config::SITE_URL . "?route=list_templates"
        ?>">
        <button>Шаблони</button>
    </a>
    <div id="name_display"><h2>
        <?php
        echo $_SESSION["user_full_data"]["full_name"]."\tИме";
        echo "<br>";
        echo $_SESSION["user_full_data"]["email"]."\tИмейл";
        echo "<br>";
        echo $_SESSION["user_full_data"]["username"]."\tПотр. име";
        ?> </h2></div>
    </a>
</div>