<?php
class Db
{
    private static $instance;
    private static $servername = "";
    private static $username = "";
    private static $password = "";
    private static $dbname  = "";

    protected static function getInstance()
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . self::$servername . ";dbname=" . self::$dbname,
                    self::$username,
                    self::$password
                );
                // self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }
        return self::$instance;
    }

    protected static function disconnect()
    {
        self::$instance = null;
    }
}
