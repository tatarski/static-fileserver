<?php
require_once(__DIR__."\\..\\config.php");
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
// Redirect to index.php
header("Location: ".Config::SITE_URL);
exit();
?>