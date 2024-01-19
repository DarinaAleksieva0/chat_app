<?php

#serve rname
$sName = "localhost";
# username
$uName = "root";
#password
$pass = "";

#db name
$db_name = "chat_app_db";

#creating db connection
try{
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch(PDOException $e){
    echo "Connection failed : ". $e->getMessage();
}