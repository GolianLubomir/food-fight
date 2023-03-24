<?php
    header('Content-Type: application/json');
    //header('Access-Control-Allow-Origin: *');

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
                    get_restaurant($pdo, $id);
                }
            } else {
                get_restaurants($pdo);
            }
            break;
        case 'POST':
            
            break;
        /*case 'PUT':
            parse_str(file_get_contents('php://input'), $_PUT);
            update_meal($db, $_GET['id'], $_PUT);
            break;*/
        case 'DELETE':
            
            break;
    }

    /**
     * READ from Meals
     * @param $db
     * @return void
     */
    function get_restaurants($db)
    {
        $stmt = $db->query('SELECT id, name, url, date FROM restaurant');
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($restaurants) {
            echo json_encode($restaurants);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Restaurants not found']);
        }
    }

    function get_restaurant($db, $id) {
        $query = 'SELECT id, name, url, date FROM restaurant WHERE id = ?';
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
        if($restaurant) {
            echo json_encode($restaurant);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Restaurant not found']);
        }
    }

    
?>  