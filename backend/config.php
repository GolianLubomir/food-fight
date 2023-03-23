<?php 
    $host = "localhost";
    $dbname = "zadanie2";
    $username = "root";
    $password = "";
    
    // create a PDO object and connect to the database
    $dsn = "mysql:host=$host;dbname=$dbname";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    try{
        $pdo = new PDO($dsn, $username, $password, $options);
        echo 'Connection successful ';
    } catch(PDOException $e){
        echo 'Connection failed: ' . $e->getMessage();
    }
?>