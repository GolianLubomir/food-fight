<?php
    /**
     * Inserts a meal into the database
     * @param PDO $pdo
     * @param string $val_name
     * @param string $val_price
     * @param string $val_menu
     * @param int $restaurant_id
     * @param int $day
     * @param string $val_image_src
     * @return void
     */
    function insert_meal($pdo, $val_name, $val_price, $val_menu, $restaurant_id, $day, $val_image_src){
        if($val_name != null && $val_price != null && $val_menu != null && $restaurant_id != null && $day != null){
            $insert_meal_sql = "INSERT INTO foods (name, price, menu, restaurant_id, day, src_image) VALUES (:name, :price, :menu, :restaurant_id, :day, :src_image)";
            $insert_meal_stmt = $pdo->prepare($insert_meal_sql);

            $insert_meal_stmt->bindParam(':name', $val_name, PDO::PARAM_STR);
            $insert_meal_stmt->bindParam(':price', $val_price, PDO::PARAM_STR);
            $insert_meal_stmt->bindParam(':menu', $val_menu, PDO::PARAM_STR);
            $insert_meal_stmt->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
            $insert_meal_stmt->bindParam(':day', $day, PDO::PARAM_INT);
            $insert_meal_stmt->bindParam(':src_image', $val_image_src, PDO::PARAM_STR);

            try {
                $insert_meal_stmt->execute();
            } catch(PDOException $e) {
                echo "Error inserting meal: " . $e->getMessage();
            }
        } else {
            echo "Missing data for the meal.";
        }
    }


    /**
     * Checks if a meal already exists in the database.
     * @param PDO $pdo
     * @param string $name
     * @param int $restaurant_id
     * @param int $day
     * @return bool
     */
    function is_meal_in_database(PDO $pdo, $name, $restaurant_id, $day){
        $sql = "SELECT COUNT(*) FROM foods WHERE name = :name AND restaurant_id = :restaurant_id AND day = :day";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
        $stmt->bindParam(':day', $day, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return ($count > 0);
        } catch(PDOException $e) {
            echo "Error occurred in query: " . $e->getMessage();
            return false;
        }
    }
?>