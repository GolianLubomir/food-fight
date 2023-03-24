<?php
    header('Content-Type: application/json');
    require_once('config.php');
    require_once('parser_config.php');

    $restaurant_name = "Venza";
    $restaurant_id = 3;
    $sql = 'SELECT html FROM restaurant WHERE name = :name ORDER BY date DESC LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $restaurant_name]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $html_data = $result['html'];

    //echo $html_data;


    $dom = new DOMDocument();
    $dom->loadHTML($html_data);
    $insert_meal_sql = "INSERT INTO meals (name, price, menu, restaurant_id, day, src_image) VALUES (:name, :price, :menu, :restaurant_id, :day, :src_image)";
    $val_image_src = NULL;
    for($i = 1; $i <= 5; $i++){
        $counter_h5 = 0;
        $counter_p = 0;
        $day = $dom->getElementById('day_' . $i .'');
        //echo "------------------";
        //echo "Den :" . $i ;
        
        while($day->getElementsByTagName('h5')->item($counter_h5) != null){
            if ($day->nodeType == XML_ELEMENT_NODE) {
                if($counter_h5 == 3 ){
                    $val_menu =  $day->getElementsByTagName('h5')->item(0)->nodeValue;
                    $val_name =  $day->getElementsByTagName('h5')->item(3)->nodeValue;
                    $val_price =  $day->getElementsByTagName('h5')->item(4)->nodeValue;
                    $val_aler = $day->getElementsByTagName('p')->item($counter_p)->nodeValue;
                    $counter_h5 = 5;
                    $counter_p += 1;
                }else{
                    $val_menu =  $day->getElementsByTagName('h5')->item($counter_h5)->nodeValue;
                    $val_name =  $day->getElementsByTagName('h5')->item($counter_h5+1)->nodeValue;
                    $val_price =  $day->getElementsByTagName('h5')->item($counter_h5+2)->nodeValue;
                    $val_aler = $day->getElementsByTagName('p')->item($counter_p)->nodeValue;
                    $counter_h5 += 3;
                    $counter_p += 1;
                }
                $val_name_aler = $val_name . " " . $val_aler;
                /*echo "--//--";
                echo $val_name_aler;
                echo " ";
                echo $val_menu;
                echo " ";
                echo $val_price;
                echo " ";*/

                if(!is_meal_in_database($pdo, $val_name_aler, $restaurant_id, $i)){
                    insert_meal($pdo, $insert_meal_sql, $val_name_aler, $val_price, $val_menu, $restaurant_id, $i, $val_image_src);
                }else{
                    //http_response_code(200);
                    //echo json_encode(['message' => 'Food is already inserted.']);
                   // echo "Food is already inserted.";
                }
            }
        }
    }
    echo json_encode(['message' => 'Meals are already parsed and inserted.']);
?>