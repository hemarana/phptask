<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = 'localhost';
$user = 'yourdatabasename';
$pass = 'password if';
$database = 'yourdatabasename';
$table = 'tablename';

// Create connection
$con = new mysqli($server, $user, $pass, $database);

// Check connection
if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
} else {
    echo "Connected successfully";
}
?>
