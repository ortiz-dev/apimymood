<?php
namespace Core;

class Database
{
    private $driver;
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private static $connection = null;

    public function __construct()
    {
        require_once '../config/config.php';
        $this->driver = DB_DRIVER;
        $this->host = DB_HOST;
        $this->dbname = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASSWORD;
        $this->charset = DB_CHARSET;

        try{
            self::$connection = new \PDO("$this->driver:host=$this->host;dbname=$this->dbname;charset=$this->charset", $this->username, $this->password);
        }catch(\PDOException $e){
            
            die(Response::getJson('Error de conexion a Base de datos: '.$e->getMessage(),400));
        }
    }

    public static function getConnection()
    {
        if(is_null(self::$connection)){
            new Database();
        }
        return self::$connection;
    }
}