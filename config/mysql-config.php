<?php
$host = 'localhost';
$user = 'root';
$pass = 'hedudeho';
$db   = 'Freebuild';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
    //echo "You are connected";
}
catch(PDOException $e){
    //echo $e -> getMessage();
}
?>