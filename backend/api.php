<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE');

    require_once('config.php');

    handle_request($_SERVER['REQUEST_METHOD'], $pdo);

    function handle_request($method, $pdo) {
        switch($method) {
            case 'GET':
                handle_get($pdo);
                break;
            case 'POST':
                handle_post($pdo);
                break;
            case 'DELETE':
                handle_delete($pdo);
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method not allowed']);
        }
    }
    
    function handle_get($pdo) {
        if(isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $id = validate_id($id);
            get_meal($pdo, $id);
        } else {
            get_meals($pdo);
        }
    }
    
    function handle_post($pdo) {
        if (!empty($_POST)) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
            $menu = filter_input(INPUT_POST, 'menu', FILTER_SANITIZE_SPECIAL_CHARS);
            $restaurant_id = filter_input(INPUT_POST, 'restaurant_id', FILTER_VALIDATE_INT);
            $day = filter_input(INPUT_POST, 'day', FILTER_VALIDATE_INT);
    
            validate_post_data([$name, $price, $menu, $restaurant_id, $day]);
            
            $mealId = create_meal($pdo, [
                'name' => $name,
                'price' => $price,
                'menu' => $menu,
                'restaurant_id' => $restaurant_id,
                'day' => $day
            ]);
    
            send_response($mealId, 'Meal created', 'Error creating meal');
        }
    }
    
    function handle_delete($pdo) {
        if (isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            $id = validate_id($id);
            delete_meal($pdo, $id);
        } else {
            delete_meals($pdo);
            echo json_encode(['message' => 'All meals were deleted']);
        }
    }

    function validate_id($id) {
        if ($id === false) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid ID parameter']);
            exit();
        }
        return $id;
    }
    
    function validate_post_data($data) {
        foreach($data as $value) {
            if(!$value) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid request data']);
                exit();
            }
        }
    }
    
    function send_response($result, $successMessage, $errorMessage) {
        if ($result) {
            http_response_code(201);
            echo json_encode(['message' => $successMessage, 'id' => $result]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => $errorMessage]);
        }
    }

    /**
     * READ from Meals
     * @param PDO $db
     * @return void
     */
    function get_meals(PDO $db)
    {
        try {
            $stmt = $db->query('SELECT m.menu, m.name, m.price, r.name AS restaurant_name, m.day, m.src_image FROM foods AS m INNER JOIN restaurants AS r ON m.restaurant_id = r.id');
            $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(empty($meals)){
                http_response_code(404);
                echo json_encode(['message' => 'No meals found']);
                return;
            }

            echo json_encode($meals);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'An error occurred while fetching meals']);
        }
    }

    /**
     * READ specific Meal by ID
     * @param PDO $db
     * @param int $id
     * @return void
     */
    function get_meal(PDO $db, $id) {
        try {
            $query = 'SELECT m.menu, m.name, m.price, r.name AS restaurant_name, m.day, m.src_image FROM foods AS m INNER JOIN restaurants AS r ON m.restaurant_id = r.id  WHERE m.id = :id';
            $stmt = $db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $meal = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$meal) {
                http_response_code(404);
                echo json_encode(['message' => 'Meal not found']);
                return;
            }

            echo json_encode($meal);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'An error occurred while fetching the meal']);
        }
    }


    /**
     * CREATE a new meal
     * @param PDO $db
     * @param array $data
     * @return void
     */
    function create_meal(PDO $db, array $data) {
        try {
            $stmt = $db->prepare('INSERT INTO foods (name, price, menu, restaurant_id, day) VALUES (:name, :price, :menu, :restaurant_id, :day);');
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':menu', $data['menu']);
            $stmt->bindParam(':restaurant_id', $data['restaurant_id'], PDO::PARAM_INT);
            $stmt->bindParam(':day', $data['day'], PDO::PARAM_INT);

            $stmt->execute();
            
            http_response_code(201);
            echo json_encode(array('message' => 'Data created successfully'));
            
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array('error' => 'Data creation failed: ' . $e->getMessage()));
        }
    }


    /**
     * DELETE a specific meal by ID
     * @param PDO $db
     * @param int $id
     * @return void
     */
    function delete_meal(PDO $db, $id) {
        try {
            $stmt = $db->prepare('DELETE FROM foods WHERE id = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('message' => 'Meal deleted successfully'));
            } else {
                http_response_code(404);
                echo json_encode(array('message' => 'Meal not found'));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array('error' => 'Error occurred: ' . $e->getMessage()));
        }
    }


    /**
     * DELETE all meals
     * @param PDO $db
     * @return void
     */
    function delete_meals(PDO $db) {
        try {
            $stmt = $db->prepare('DELETE FROM foods');
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                echo json_encode(array('message' => 'All meals deleted successfully'));
            } else {
                http_response_code(204);
                echo json_encode(array('message' => 'No meals to delete'));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array('error' => 'Error occurred: ' . $e->getMessage()));
        }
    }

?>  