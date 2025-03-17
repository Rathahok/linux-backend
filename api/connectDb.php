<?php
$host = "localhost";
$user = "root";
$pass ="";
$db = "linux-project";
$conn = new mysqli($host,$user,$pass,$db);
if($conn -> connect_error){
    die(json_encode(["error"=>"Database connection failed:" .$conn->connect_error]));
}
?>