<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once "../classes/Database.php";
include_once "../classes/Quest.php";

$database = new Database();
$db = $database->getConnection();
$quest = new Quest($db);
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->cost)) {
    $quest->name = $data->name;
    $quest->cost = $data->cost;

    if ($quest->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Задание создано."], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Что-то пошло не так, задание не было создано."], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(422);
    echo json_encode(["message" => "Ошибка валидации данных."], JSON_UNESCAPED_UNICODE);
}