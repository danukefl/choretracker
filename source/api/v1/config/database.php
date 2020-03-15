<?php
class Database{
 
    // specify your own database credentials
    private $host = "192.168.25.80";
    private $db_name = "dashboarddbv2";
    private $username = "chores_user";
    private $password = "chores_password";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }


}
?>