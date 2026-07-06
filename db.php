<?php
/* Registered Email : your_email@example.com */

$host="localhost";
$db="admin_dashboard";
$user="root";
$pass="";

try{

$pdo=new PDO(
"mysql:host=$host;dbname=$db;charset=utf8",
$user,
$pass
);

$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

die("Connection Failed : ".$e->getMessage());

}
?>