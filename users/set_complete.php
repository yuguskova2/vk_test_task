<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../classes/Database.php";
include_once "../classes/User.php";
include_once "../classes/Quest.php";

$database = new Database();
$db = $database->getConnection();
$result = [];

$user = new User($db);

if (!empty($_REQUEST['user_id']) && !empty($_REQUEST['quest_id'])) {
    $user = new User($db);
    $user_data = $user->getUserData($_REQUEST['user_id']);
    
    if (!empty($user_data->rowCount())) {
        $result = $user_data->fetch(PDO::FETCH_ASSOC);

        $quest = new Quest($db);
        $quest_data = $quest->getQuestData($_REQUEST['quest_id']);
        
        if (!empty($quest_data->rowCount())) {
            $data = $quest_data->fetch(PDO::FETCH_ASSOC);
            $completed_quests = $quest->getCompletedQuestsByUserId($_REQUEST['user_id']);

            if (!empty($completed_quests->rowCount())) {
                $completed_quest_ids = $completed_quests->fetchAll(PDO::FETCH_COLUMN);
                if (in_array($_REQUEST['quest_id'], $completed_quest_ids)) {
                    http_response_code(422);
                    echo json_encode(["message" => "Данный пользователь уже выполнил это задание, баланс не изменен."], JSON_UNESCAPED_UNICODE);

                    return;
                }
            }

            $quest->setCompletedQuestByUserId($_REQUEST['user_id'], $_REQUEST['quest_id']);
            $user->updateUserBalance($_REQUEST['user_id'], $result['balance'] + $data['cost']);

            http_response_code(200);
            echo json_encode(["message" => "Задание выполнено, баланс пользователя обновлен."], JSON_UNESCAPED_UNICODE);

        } else {
            http_response_code(404);
            echo json_encode(["message" => "Задание не найдено."], JSON_UNESCAPED_UNICODE);
        }
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Пользователь не найден."], JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(422);
    echo json_encode(["message" => "Не хватает данных о пользователе или задании."], JSON_UNESCAPED_UNICODE);
}