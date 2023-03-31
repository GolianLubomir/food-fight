<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE');

    require_once('config.php');


    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(isset($_GET['id'])) {
                // Validate the ID parameter for the get_meal function
                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id === false) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid ID parameter']);
                } else {
                    get_meal($pdo, $id);
                }
            } else {
                get_meals($pdo);
            }
            break;
        case 'POST':
            if (!empty($_POST)) {
                // Validate the data in $_POST
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
                $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
                $menu = filter_input(INPUT_POST, 'menu', FILTER_SANITIZE_SPECIAL_CHARS);
                $restaurant_id = filter_input(INPUT_POST, 'restaurant_id', FILTER_VALIDATE_INT);
                $day = filter_input(INPUT_POST, 'description', FILTER_VALIDATE_INT);
                
        
                if (!$name || !$price || !$menu || !$restaurant_id || !$day) {
                    // Return an error response if any required data is missing or invalid
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid request data']);
                } else {
                    // Call the create_meal function with the validated data
                    $mealId = create_meal($pdo, [
                        'name' => $name,
                        'price' => $price,
                        'menu' => $menu,
                        'restaurant_id' => $restaurant_id,
                        'day' => $day
                    ]);
        
                    if ($mealId) {
                        // Return a success response if the meal was created successfully
                        http_response_code(201);
                        echo json_encode(['message' => 'Meal created', 'id' => $mealId]);
                    } else {
                        // Return an error response if the meal could not be created
                        http_response_code(500);
                        echo json_encode(['message' => 'Error creating meal']);
                    }
                }
            } else {
                // Return an error response if the request is empty
                //delete_meals($pdo);
            }
            break;
        /*case 'PUT':
            parse_str(file_get_contents('php://input'), $_PUT);
            update_meal($db, $_GET['id'], $_PUT);
            break;*/
        case 'DELETE':
            if (isset($_GET['id'])) {
                // Validate the ID parameter for the delete_meal function
                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id === false) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid ID parameter']);
                } else {
                    delete_meal($pdo, $id);
                }
            } else {
                delete_meals($pdo);
                /*http_response_code(400);
                echo json_encode(['message' => 'Missing ID parameter']);*/
                echo json_encode(['message' => 'All meals were deleted']);
            }
            break;
    }

    /**
     * READ from Meals
     * @param $db
     * @return void
     */
    function get_meals($db)
    {
        $stmt = $db->query('SELECT m.menu, m.name, m.price, r.name AS restaurant_name, m.day, m.src_image FROM meals AS m INNER JOIN restaurant AS r ON m.restaurant_id = r.id');
        $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($meals);
    }

    function get_meal($db, $id) {
        $query = 'SELECT m.menu, m.name, m.price, r.name AS restaurant_name, m.day, m.src_image FROM meals AS m INNER JOIN restaurant AS r ON m.restaurant_id = r.id  WHERE m.id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $meal = $stmt->fetch(PDO::FETCH_ASSOC);
        if($meal) {
            echo json_encode($meal);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Meal not found']);
        }
    }

    function create_meal($db, $data){
        $stmt = $db->prepare('INSERT INTO meals (name, price, menu, restaurant_id, day) VALUES (:name, :price, :menu, :restaurant_id, :day);');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':menu', $data['menu']);
        $stmt->bindParam(':restaurant_id', $data['restaurant_id']);
        $stmt->bindParam(':day', $data['day']);
        $stmt->execute();
        echo json_encode(array('success' => 'Data created successfully'));
    }

    function delete_meal($db, $id) {
        $stmt = $db->prepare('DELETE FROM meals WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo json_encode(array('success' => 'Data deleted successfully'));
    }

    function delete_meals($db) {
        $stmt = $db->prepare('DELETE FROM meals ');
        $stmt->execute();
        echo json_encode(array('success' => 'Data deleted successfully'));
    }
?>  