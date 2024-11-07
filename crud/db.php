<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$database = 'task_php';
$table = 'being';
$con = new mysqli($server, $user, $pass, $database );
if($con->connect_error){
    die('ok'. $con->connect_error);
}
else{
    // echo "success";
}
?>