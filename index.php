<?php
    include_once './controllers/mainController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $query = $_SERVER['REQUEST_URI'];
    $params = explode('/', $query);
    $method = $_SERVER['REQUEST_METHOD'];
    $body = file_get_contents('php://input');

    if ($params[1] == 'city') {
        if ($method == 'GET') {
            MainController::getCity();
        } else if ($method == 'POST') {
            MainController::createCity($body);
        } else if ($method == 'PUT') {
            MainController::updateCity($params[2], $body);
        } else if ($method == 'DELETE') {
            MainController::deleteCity($params[2]);
        }
    } else if ($params[1] == 'user') {
        if ($method == 'GET') {
            MainController::getUser();
        } else if ($method == 'POST') {
            MainController::createUser($body);
        } else if ($method == 'PUT') {
            MainController::updateUser($params[2], $body);
        } else if ($method == 'DELETE') {
            MainController::deleteUser($params[2]);
        }
    }
?>