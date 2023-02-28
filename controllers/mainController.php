<?php
    include_once __DIR__.'/../config/database.php';
    include_once __DIR__.'/../models/city.php';
    include_once __DIR__.'/../models/user.php';

    class MainController {
        static function getCity() {
            $database = new Database();
            $db = $database->getConnection();
            $city = new City($db);
            $stmt = $city->get();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $city_arr = array();
                $city_arr["items"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // извлекаем строку
                    extract($row);

                    $city_item = array(
                        "id" => $id,
                        "name" => $name,
                    );
                    $city_arr["items"][] = $city_item;
                }
                http_response_code(200);
                echo json_encode($city_arr);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Города не найдены.'], JSON_UNESCAPED_UNICODE);
            }
        }
        static function createCity($body) {
            $database = new Database();
            $db = $database->getConnection();
            $city = new City($db);
    
            $name = json_decode($body)->name;
    
            if ($name) {
                $city->name = $name;
                if ($city->create()) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Город был создан'], JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(503);
                    echo json_encode(['message' => 'Невозможно создать город'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Невозможно создать город, данные неполные'], JSON_UNESCAPED_UNICODE);
            }
        }
        static function deleteCity($id) {
            if ($id) {
                $database = new Database();
                $db = $database->getConnection();
                $city = new City($db);
                $city->id = $id;
                if ($city->delete()) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Город удалён'], JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(503);
                    echo json_encode(['message' => 'Невозможно удалить город'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Невозможно удалить город, не указан id'], JSON_UNESCAPED_UNICODE);
            }
        }
        static function updateCity($id, $body) {
            if ($body) {
                $database = new Database();
                $db = $database->getConnection();
                $city = new City($db);
                $city->id = $id;
                $name = json_decode($body)->name;
                $city->name = $name;

                if ($city->update()) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Город был обновлён'], JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(503);
                    echo json_encode(['message' => 'Невозможно обновить город'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Невозможно обновить город, не указан id'], JSON_UNESCAPED_UNICODE);
            }
        }

        static function createUser($body) {
            $data = json_decode($body);

            if (
                !empty($data->name) &&
                !empty($data->city) &&
                !empty($data->username)
            ) {
                $database = new Database();
                $db = $database->getConnection();

                $city = new City($db);
                $city->name = $data->city;
                $city_id = $city->getId();

                $user = new User($db);
                $user->name = $data->name;
                $user->city = $city_id;
                $user->username = $data->username;
                if ($user->create()) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Пользователь был создан'], JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(503);
                    echo json_encode(['message' => 'Невозможно создать пользователя'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Невозможно создать пользователя, данные неполные'], JSON_UNESCAPED_UNICODE);
            }
        }

        static function getUser() {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);
            $stmt = $user->get();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $users_arr = array();
                $users_arr["items"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $user_item = array(
                        "id" => $id,
                        "name" => $name,
                        "username" => $username,
                        "city" => $city,
                    );
                    $users_arr["items"][] = $user_item;
                }
                http_response_code(200);
                echo json_encode($users_arr);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Пользователи не найдены.'], JSON_UNESCAPED_UNICODE);
            }
        }
        static function deleteUser($id) {
            if ($id) {
                $database = new Database();
                $db = $database->getConnection();

                $user = new User($db);
                $user->id = $id;
                if ($user->delete()) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Пользователь удалён'], JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(503);
                    echo json_encode(['message' => 'Невозможно удалить пользователя'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Невозможно удалить пользователя, не указан id'], JSON_UNESCAPED_UNICODE);
            }
        }
        static function updateUser($id, $body) {
            $data = json_decode($body);
            if ($body) {
                $database = new Database();
                $db = $database->getConnection();

                $city = new City($db);
                $city->name = $data->city;
                $city_id = $city->getId();

                $user = new User($db);
                $user->id = $id;
                $user->name = $data->name;
                $user->username = $data->username;
                $user->city = $city_id;

                if ($user->update()) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Пользователь был обновлён'], JSON_UNESCAPED_UNICODE);
                } else {
                    http_response_code(503);
                    echo json_encode(['message' => 'Невозможно обновить пользователя'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Невозможно обновить пользователя, не указан id'], JSON_UNESCAPED_UNICODE);
            }
        }
    }
?>