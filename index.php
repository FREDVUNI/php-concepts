<?php

#db connection 
$server = "localhost";
$user ="root";
$password="";
$database="database_name";

$conn = new mysqli($server,$user,$password,$database);

if($conn->connect_error){
    echo "There was a connection error " . $conn->connect_error;
}

#select all
require_once("./database.php");

$todo_list = [];

$sql = "SELECT * FROM todos";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        array_push($todo_list,$row['task'])
    }
}

$conn->close();

#inserting
require_once("./database.php");
if(isset($_POST["submit"])):
    $todo = $_POST["todo"];
    $sql = $conn->prepare("INSERT INTO todos (`todo`) VALUES(?)");
    $sql->bind_param("s",$todo);
    $sql->execute();
    $sql->close();
endif;


#oop
class DatabaseConnection{
    private $server;
    private $host;
    private $user;
    private $password;
    private $db;
    private $conn;

    public function __construct($server,$host,$user,$password,$db){
        $this->server = $server;
        $this->user = $user;
        $this->host = $host;
        $this->password = $password;
        $this->db = $db;

        $this->conn = new mysqli($server,$user,$password,$db);

        if($this->conn->connect_error):
            die("connection error ". $this->conn->connect_error );
        endif;

    }

    public function connectDB(){
        return $this->conn;
    }
}
$database = new DatabaseConnection("localhost","root","","todos");
$conn = $database->connectDB();

class DB{
    private $conn;

    public function __construct($server,$user,$password,$db){
         $this->conn = new mysqli($server,$user,$password,$db);

         if($this->conn->connect_error){
            die("connection error " . $this->conn->connect_error)
         }
    }
    public function connectDB(){
        return $this->conn;
    }
}
$db = new DB('localhost', 'root', '','task_management');

#usage
$db = new Database();
$conn = $db->connectDB();


#get item by id
require_once("database.php");

$id = isset($_GET['id']);
$sql = $conn->prepare("SELECT * FROM todos WHERE id = $id");
$sql->bibd_param("i",$id);
$sql->execute();
$result = $sql->get_result();

$sql->close();
$conn->close();

#ajax calls
$(document).ready(function(){
    $("#submitForm").submit(function(e){
        $.ajax({
            method:"",
            url:"",
            success:function(respoense){}
            error:function(error){}
        })
    })
})
<ul>
    <?php if($result->num_rows > 0):  ?>
        <?php while($result->fetch_assoc()): ?>
            <li><?php echo $row['task'];?></li>
        <?php endwhile; ?>
    <?php  endif;?>
</ul>


?>
