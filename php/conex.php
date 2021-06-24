<?php
$servidor= 'localhost';
$user= 'root';
$password='';
$db='school';

$conn=new mysqli($servidor,$user,$password,$db);

if($conn->connect_error){
    die('Error de conexion: '. $conn->connect_error);
}
