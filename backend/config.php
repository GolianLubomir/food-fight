<?php 
    $host = "localhost";
    $dbname = "food_fight";
    $username = "root";
    $password = "";
    
    try{
        $pdo = new PDO("mysql:host=$host", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
        
        $pdo->exec("USE `$dbname`");

    } catch(PDOException $e){
        echo 'Connection failed: ' . $e->getMessage();
    }
?>
