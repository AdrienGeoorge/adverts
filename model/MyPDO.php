<?php

class MyPDO
{

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=php_adverts';
    private static $user = 'root';
    private static $mdp = 'root';
    private static $myPdo;
    private static $onePdo = null;

    private function __construct()
    {
        MyPDO::$onePdo = new PDO(self::$serveur . ';' . self::$bdd, self::$user, self::$mdp);
        MyPDO::$onePdo->query("SET CHARACTER SET utf8");
        MyPDO::$onePdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct()
    {
        MyPDO::$onePdo = null;
    }

    public static function getInstance()
    {
        if (self::$onePdo == null) {
            self::$myPdo = new MyPDO();
        }
        return self::$onePdo;
    }

}
