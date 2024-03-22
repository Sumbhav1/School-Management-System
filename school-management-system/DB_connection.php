<?php 

$sName = "localhost";
$Uname = "root";
$Upass = "";
$db_name = "studentms";

try {
	$conn = new PDO("mysql:host=$sName;dbname=$db_name", $Uname, $Upass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Connection failed:  ". $e->getMessage();
    exit;
}


















