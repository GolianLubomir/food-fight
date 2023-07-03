<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    require_once('config.php');
    require_once('parser_helper.php');

    $restaurant_1 = "Karloveská klubovňa";
    $restaurant_id = 1;
    $sql = 'SELECT html FROM restaurants WHERE name = :name ORDER BY date DESC LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $restaurant_1]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $html_data = $result['html'];

    $dom = new DOMDocument();
    $dom->loadHTML($html_data);

    $xpath = new DOMXPath($dom);
    $elements = $xpath->query('//div[@class="dailymenu-item"]');

    $day = 1;
   
    foreach ($elements as $element) {

        foreach($element->childNodes as $item){
            if ($item->nodeType == XML_ELEMENT_NODE){
                
                $h3elements = $item->getElementsByTagName('h3');
                $val_menu = $h3elements->length > 0 ? $h3elements->item(0)->nodeValue : '';
        
                $spanelements = $item->getElementsByTagName('span');
                $val_name = $spanelements->length > 0 ? $spanelements->item(0)->nodeValue : '';
        
                $val_image_src =  NULL;
        
                if($val_menu == "Polievka"){
                    $val_price = "Zadarmo k menu*";
                } else {
                    $divelements = $item->getElementsByTagName('div');
                    $val_price = $divelements->length > 5 ? trim($divelements->item(5)->textContent) : '';
                }
        
                if(!is_meal_in_database($pdo, $val_name, $restaurant_id, $day)){
                    insert_meal($pdo, $val_name, $val_price, $val_menu, $restaurant_id, $day, $val_image_src);
                }
            }
        }
        $day++;
    }
?>