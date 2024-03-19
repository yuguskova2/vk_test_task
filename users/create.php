<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "../classes/Database.php";
include_once "../classes/User.php";

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->balance)) {
    $user->name = $data->name;
    $user->balance = $data->balance;

    if ($user->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Пользователь был создан."], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Что-то пошло не так, пользователь не был создан."], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(422);
    echo json_encode(["message" => "Ошибка валидации данных."], JSON_UNESCAPED_UNICODE);
}