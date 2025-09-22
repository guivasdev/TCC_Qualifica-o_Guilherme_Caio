<?php
 define('HOST', 'localhost');
    define('DB', 'testetcc');
    define('USER', 'root');
    define('PASS', '');
    $banco = new MySql();
    $banco->connect();
    
class MySql {
    private static $pdo;
   
    public static function connect() {
        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . HOST . ';dbname=' . DB, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo 'Erro ao conectar: ' . $e->getMessage();
            }
        }

        return self::$pdo;
    }
}
?>
