<?php

require_once(__DIR__."\\..\config.php");
class DBMS
{
    public static PDO $pdo;
    public static function init()
    {
        $dsn = "mysql:host=" . Config::DB_SERVERNAME . ";dbname=" . Config::DB_NAME;
        try {
            DBMS::$pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASS);

            // Error logging for DBMS connection
            DBMS::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            // echo "SUCCESS CONNECT TO DB\n";
        } catch (PDOException $e) {
            // echo "Failed Connect to DB: " . $e->getMessage() . "\n";
            exit();
        }
    }
}
DBMS::init();
?>