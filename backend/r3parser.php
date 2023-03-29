<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    require_once('config.php');
    require_once('parser_config.php');

    $restaurant_1 = "Karloveská klubovňa";
    $restaurant_id = 1;
    $sql = 'SELECT html FROM restaurant WHERE name = :name ORDER BY date DESC LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $restaurant_1]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $html_data = $result['html'];

    $dom = new DOMDocument();
    $dom->loadHTML($html_data);

    $xpath = new DOMXPath($dom);
    $elements = $xpath->query('//div[@class="dailymenu-item"]');

    $day = 1;
    $insert_meal_sql = "INSERT INTO meals (name, price, menu, restaurant_id, day, src_image) VALUES (:name, :price, :menu, :restaurant_id, :day, :src_image)";
    foreach ($elements as $element) {

        // Get the class attribute
        foreach($element->childNodes as $item){
            if ($item->nodeType == XML_ELEMENT_NODE){
                /*echo $item->getElementsByTagName('h3')->item(0)->nodeValue;
                echo " ";
                echo $item->getElementsByTagName('span')->item(0)->nodeValue;
                echo " ";

                $itt = $item->getElementsByTagName('div')->item(5);
                echo $itt->textContent;*/

                $val_menu =  $item->getElementsByTagName('h3')->item(0)->nodeValue;
                $val_name =  $item->getElementsByTagName('span')->item(0)->nodeValue;
                $val_image_src =  NULL;
                if($val_menu == "Polievka"){
                    $val_price = "Zadarmo k menu*";
                }else{
                    $val_price = trim($item->getElementsByTagName('div')->item(5)->textContent);
                }
                

                /*echo "------------------";
                echo $val_menu;
                echo " ";
                echo trim($val_price);
                echo " ";
                echo $val_name;
                echo " ";*/

                if(!is_meal_in_database($pdo, $val_name, $restaurant_id, $day)){
                    insert_meal($pdo, $insert_meal_sql, $val_name, $val_price, $val_menu, $restaurant_id, $day, $val_image_src);
                }else{
                    //echo "Food is already inserted.";
                }
                
            }
        }
        $day++;
    }
      
    
   
?>