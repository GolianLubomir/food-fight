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
            if (isset($_GET['id'])) {
                // Validate the ID parameter for the delete_meal function
                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id === false) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid ID parameter']);
                } else {
                    delete_restaurant($pdo, $id);
                }
            } else {
                delete_restaurants($pdo);
                /*http_response_code(400);
                echo json_encode(['message' => 'Missing ID parameter']);*/
                echo json_encode(['message' => 'All restaurants were deleted']);
            }
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

    function delete_restaurant($db, $id) {
        $empty_html = '';
        $stmt = $db->prepare('UPDATE restaurant SET html = :html WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':html', $empty_html);
        $stmt->execute();

        $stmt = $db->prepare('DELETE FROM meals WHERE restaurant_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo json_encode(array('success' => 'Data deleted successfully'));
    }

    function delete_restaurants($db) {
        $empty_html = '';
        $stmt = $db->prepare('UPDATE restaurant SET html = :html');
        $stmt->bindParam(':html', $empty_html);
        $stmt->execute();

        $stmt = $db->prepare('DELETE FROM meals');
        $stmt->execute();
        /*
        $stmt = $db->prepare('DELETE FROM restaurant WHERE id > 3');
        $stmt->execute();
        echo json_encode(array('success' => 'Data deleted successfully'));*/
    }

    
?>  