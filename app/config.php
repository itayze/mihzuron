<?php
 
$host="localhost";
$user="eavnicom_eavni";
$pass="5597284@ea";
$db="eavnicom_sadna";

$conn=new mysqli($host,$user,$pass,$db);
$conn->set_charset("utf8");
if ($conn->connect_error){
die("Connection failed: ".$conn->connect_error);}


?>