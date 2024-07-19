<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "saturday_flex";

$con = mysqli_connect($host, $user, $pass, $db);
if($con->connect_error){
    echo "Connection Faild";
}


?>