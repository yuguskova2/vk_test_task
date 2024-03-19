<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../classes/Database.php";
include_once "../classes/User.php";
include_once "../classes/Quest.php";

$database = new Database();
$db = $database->getConnection();
$result = [];

if (!empty($_REQUEST['user_id'])) {
    $user = new User($db);
    $user_data = $user->getUserData($_REQUEST['user_id']);
    
    if (!empty($user_data->rowCount())) {
        $result = $user_data->fetch(PDO::FETCH_ASSOC);

        $quest = new Quest($db);
        $completed_quests = $quest->getCompletedQuestsByUserId($_REQUEST['user_id']);

        if (!empty($completed_quests->rowCount())) {
            $result['completed_quests'] = $completed_quests->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $result['completed_quests'] = '';
        }

        http_response_code(200);
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Пользователь не найден."], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(422);
    echo json_encode(["message" => "Не хватает данных о пользователе."], JSON_UNESCAPED_UNICODE);
}