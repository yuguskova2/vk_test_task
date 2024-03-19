1. Клонируйте репозиторий в корневую директорию.
2. Разверните дамп базы данных из файла vk_test_task.sql.
3. В файле classes/Database.php в полях username и password добавьте логин и пароль от базы данных.

Запросы:
1. Чтобы создать пользователя, выполните POST запрос users/create с json данными name и balance.
Например: http://localhost/vk_test_task/users/create
JSON: {"name":"Ann", "balance": "0.00"}
2. Чтобы создать задание, выполните POST запрос users/create с json данными name и balance.
Например: http://localhost/vk_test_task/quests/create 
JSON: {"name":"Quest 17", "cost": "100.00"}
3. Чтобы засчитать пользователю задание, выполните POST запрос users/set_complete с данными user_id и quest_id.
Например: http://localhost/vk_test_task/users/set_complete?user_id=8&quest_id=16 
4. Чтобы получить историю выполненных заданий пользователя и его баланс,  выполните GET запрос users/get_history с данными user_id.
Например: http://localhost/vk_test_task/users/get_history?user_id=8 
