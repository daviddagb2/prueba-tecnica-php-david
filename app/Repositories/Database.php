<?php 
namespace App\Repositories;
use Symfony\Component\Dotenv\Dotenv;
use PDO;
use mysqli;

class Database
{        
    private $pdo;
    private static $_instance; //The single instance
    private $_host;
    private $_username;
    private $_password;
    private $_database;
 
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if(!self::$_instance) // If no instance then make one
        { 
            self::$_instance = new self();
        }
        return self::$_instance;
    }
 
    // Constructor
    private function __construct()
    {
        $dotenv = new Dotenv();
        echo(__DIR__);
        $dotenv->load(__DIR__ . '/../../.env');

        $_host = $_ENV['DATABASE_HOST'];
        $_username = $_ENV['DATABASE_USER'];
        $_password = $_ENV['DATABASE_PASSWD'];
        $_database = $_ENV['DATABASE_NAME'];

        //print_r(__DIR__ . '/../../.env');
        print_r($_password);

        //$this->pdo = new PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_username, $this->_password);

            $dsn = "mysql:host=localhost;dbname=pruebaphp;charset=UTF8";

        try {
            $this->pdo = new PDO($dsn, $_username, $_password);

            if ($this->pdo) {
                print_r("Connected to the $_database database successfully!");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }


//        $this->pdo = new mysqli($this->_host, $this->_username,$this->_password, $this->_database);
        // Error handling
    //    if(mysqli_connect_error())
      //  {
      //      trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),E_USER_ERROR);
    //    }
    }
 
    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }
 
    // Get mysqli connection
    public function getConnection()
    {
        return $this->pdo;
    }
     
    public function get_data($sql)
    {
        $ret = array('STATUS'=>'ERROR','ERROR'=>'','DATA'=>array());
         
        $mysqli = $this->getConnection();
        $res = $mysqli->query($sql);
         
        if($res)
            $ret['STATUS'] = "OK";
        else
            $ret['ERROR'] = mysqli_error();            
         
        while($row = $res->fetch_array(MYSQLI_ASSOC))
        {
            $ret['DATA'][] = $row;
        }
        return $ret;
    }
     
    public function exec($sql)
    {
       /* $ret = array('STATUS'=>'ERROR','ERROR'=>'');
 
        $mysqli = $this->getConnection();
        $res = $mysqli->query($sql);
         
        if($res)
            $ret['STATUS'] = "OK";
        else
            $ret['ERROR'] = mysqli_error();
         
        return $ret;*/

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':name' => $name
        ]);

    }
 
}