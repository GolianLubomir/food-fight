<?php
 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');
require_once('config.php');

$restaurants = array(
    array('name' => 'Karloveská klubovňa', 'url' => 'https://www.nasaklubovna.sk/klubovne/karloveska/menu/denne-menu/'),
    array('name' => 'Eat & Meet', 'url' => 'http://eatandmeet.sk/tyzdenne-menu'),
    array('name' => 'Venza', 'url' => 'https://www.novavenza.sk/tyzdenne-menu'),
    
);

foreach ($restaurants as $restaurant){
    $curl = curl_init($restaurant['url']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($curl);
    curl_close($curl);
    //$name = "Venza";

    $stmt = $pdo->prepare("UPDATE `restaurant` SET html = :html WHERE name = :name");
    //$stmt = $pdo->prepare("INSERT INTO `restaurant` (`name`, `url`, `html`) VALUES (:name, :url, :html)");
    $stmt->bindParam(":name", $restaurant['name']);
    //$stmt->bindParam(":url", $restaurant['url']);
    $stmt->bindParam(":html", $html);
    $stmt->execute();
    echo json_encode(['message' => 'Restaurant data downloaded.']);
}


echo "HTML code saved to database!";

?>