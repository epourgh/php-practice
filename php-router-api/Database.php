<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}/config.php");

final class Database
{
    private static $instance;
    private static $host = DB_HOST;
    private static $user = DB_USER;
    private static $pass = DB_PASS;
    private static $dbname = DB_NAME;

    private static $dbh;
    private static $error;

    private $stmt;

    private function __construct()
    {
    }
    
    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();

            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname;
            $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

            try {
                self::$dbh = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                self::$error = $e->getMessage();
                echo self::$error;
            }
        }
        return self::$instance;
    }

    public function query($sql)
    {
        $this->stmt = self::$dbh->prepare($sql);
    }

    public function bind($param, $value, $type = null)
    {

        $type = is_int($value) == true ? PDO::PARAM_INT : (is_bool($value) == true ? PDO::PARAM_BOOL : (is_null($value) == true ? PDO::PARAM_NULL : PDO::PARAM_STR));

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function fetchAll()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetch()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
