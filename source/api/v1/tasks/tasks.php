<?php
class Task{
 
    // database connection and table name
    private $conn;
    private $table_name = "Task";
 
    // object properties
    public $id;
    public $name;
    public $time;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
    
        // select all query
        $query = "SELECT Task.name, Task_Events.time, Task.id 
                From Task 
                INNER JOIN (
                    select max(time) as Time, Task_ID
                    from Task_Events 
                    group by Task_ID) events ON Task.id = events.Task_ID
                INNER JOIN Task_Events on Task.id = Task_Events.Task_ID AND Task_Events.Time = events.Time
                ORDER BY Task.name";
    

        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

// update the product
    function updatetime(){
    
        // update query
        $query = "INSERT INTO Task_Events (Task_ID) VALUES ( :id );";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':id', $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
}