<?php
    function insert_meal($pdo, $insert_meal_sql, $val_name, $val_price, $val_menu, $restaurant_id, $day, $val_image_src){
        $insert_meal_sql = "INSERT INTO meals (name, price, menu, restaurant_id, day, src_image) VALUES (:name, :price, :menu, :restaurant_id, :day, :src_image)";
        $insert_meal_stmt = $pdo->prepare($insert_meal_sql);

        $insert_meal_stmt->bindParam(':name', $val_name);
        $insert_meal_stmt->bindParam(':price', $val_price);
        $insert_meal_stmt->bindParam(':menu', $val_menu);
        //$stmt->bindParam(':allergens', $allergens);
        $insert_meal_stmt->bindParam(':restaurant_id', $restaurant_id);
        $insert_meal_stmt->bindParam(':day', $day);
        $insert_meal_stmt->bindParam(':src_image', $val_image_src);

        if ($insert_meal_stmt->execute()) {
            echo "Meal inserted successfully";
        } else {
            echo "Error inserting meal: " . $insert_meal_stmt->errorInfo()[2];
        }
    }

    function is_meal_in_database($pdo, $name, $restaurant_id, $day){

        $sql = "SELECT COUNT(*) FROM meals WHERE name = :name AND restaurant_id = :restaurant_id AND day = :day";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':restaurant_id', $restaurant_id);
        $stmt->bindParam(':day', $day);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return ($count > 0);

    }
?>