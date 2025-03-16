<?php
class Database{
    public $hostname = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "web_project2";
    public $conn;

    function __construct(){
        try {
            $this->conn = new PDO("mysql:host=$this->hostname;dbname=$this->dbname", $this->username , $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
         }
         catch(PDOException $e){
            echo "Connection failed" . $e->getMessage();
         }
    }
    
   }
?>