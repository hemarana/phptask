<?php
$sesrver = 'localhost';
$user = 'root';
$pass = '';
$db = 'task_php';
$table = 'being';

$con = new mysqli($sesrver, $user, $pass, $db);
if($con->connect_error){
    die('connection failed ' . $con->connect_error);
}
else {
    echo "<h1>my babe you are growing keep work hard</h1>";
}






$sql = "SELECT * FROM $table";

?>