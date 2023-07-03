<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE');

    require_once('config.php');


    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(isset($_GET['id'])) {
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
        case 'DELETE':
            if (isset($_GET['id'])) {
                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id === false) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid ID parameter']);
                } else {
                    delete_restaurant($pdo, $id);
                }
            } else {
                delete_restaurants($pdo);

                echo json_encode(['message' => 'All restaurants were deleted']);
            }
            break;
    }

    /**
     * Fetch all restaurants from the database
     *
     * @param PDO $db
     * @return void
     */
    function get_restaurants(PDO $db)
    {
        try {
            $stmt = $db->query('SELECT id, name, url, date FROM restaurants');
            $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            if(!empty($restaurants)) {
                send_response($restaurants, "Restaurants fetched successfully.", "Error fetching restaurants.");
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'No restaurants found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error occurred while fetching restaurants: ' . $e->getMessage()]);
        }
    }


    /**
     * Fetch a single restaurant by its ID
     * @param PDO $db
     * @param int $id
     * @return void
     */
    function get_restaurant(PDO $db, $id) {
        $id = validate_id($id);
        if (!$id) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid ID parameter']);
            return;
        }
    
        try {
            $query = 'SELECT id, name, url, date FROM restaurants WHERE id = ?';
            $stmt = $db->prepare($query);
            $stmt->execute([$id]);
            $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($restaurant) {
                send_response($restaurant, "Restaurant fetched successfully.", "Error fetching restaurant.");
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Restaurant not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error occurred while fetching restaurant: ' . $e->getMessage()]);
        }
    }
    

    /**
     * Delete a restaurant and associated meals
     * @param PDO $db
     * @param int $id
     * @return void
     */
    function delete_restaurant(PDO $db, $id) {
        try {
            $db->beginTransaction();
            
            $empty_html = '';
            $stmt = $db->prepare('UPDATE restaurants SET html = :html WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':html', $empty_html, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $db->prepare('DELETE FROM foods WHERE restaurant_id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $db->commit();

            http_response_code(201);
            echo json_encode(['message' => "Data deleted successfully."]);
        } catch(PDOException $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['message' => 'Error occurred while deleting restaurant: ' . $e->getMessage()]);
        }
    }



    /**
     * DELETE all Restaurants and Foods
     * @param PDO $db
     * @return void
     */
    function delete_restaurants(PDO $db) {
        try {
            $db->beginTransaction();
            
            $stmt = $db->prepare('UPDATE restaurants SET html = ""');
            $stmt->execute();

            $stmt = $db->prepare('DELETE FROM foods');
            $stmt->execute();
            
            $db->commit();
            http_response_code(201);
            echo json_encode(['message' => "Data deleted successfully."]);
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(['message' => 'Server error: ' . $e->getMessage()]);
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
?>  