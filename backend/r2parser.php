<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    require_once('config.php');
    require_once('parser_helper.php');

    $restaurant_1 = "Eat & Meet";
    $restaurant_id = 2;
    $sql = 'SELECT html FROM restaurants WHERE name = :name ORDER BY date DESC LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $restaurant_1]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $html_data = $result['html'];

    $dom = new DOMDocument();
    $dom->loadHTML($html_data);

    for($i = 1; $i <= 7; $i++){

        $day = $dom->getElementById('day-' . $i .'');
        
        foreach($day->childNodes as $menu){
            if ($menu->nodeType == XML_ELEMENT_NODE) {
                $val_menu =  $menu->getElementsByTagName('h4')->item(0)->nodeValue;
                $val_price =  $menu->getElementsByTagName('span')->item(0)->nodeValue;
                $val_name =  $menu->getElementsByTagName('p')->item(0)->nodeValue;
                if($val_name != null){
                    $val_image_src = $menu->getElementsByTagName('img')->item(0)->getAttribute('src');
                }
                

                if(!is_meal_in_database($pdo, $val_name, $restaurant_id, $i)){
                    insert_meal($pdo, $val_name, $val_price, $val_menu, $restaurant_id, $i, $val_image_src);
                }else{

                }
            }
        }
    }
    echo json_encode(['message' => 'Foods are already parsed and inserted.']);
?>