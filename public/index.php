<?php
#
#   MAIN PAGE CONTROLER
#

include_once "../bootstrap.php";

if(isset($_GET['note'])) { //вывод уведомлений в шаблон
    switch($_GET['note'])
    {
        case 'registred':
            $notification = "Вы успешно зарегистрировались";
            break;
        case 'updated':
            $notification = "Ваши данные успешно обновлены";
            break;
    }
}

#
#   Разбираем параметры запроса
#


#       SEARCH
if(isset($_GET['search'])) { //запрос на поиск
    $search = $_GET['search'];
    $title = 'Студенты по запросу "' . $search . '"';
} else {
    $search = NULL;
    $title = "Список студентов";
}


#       SORT_BY
if(isset($_GET['sort_by'])) {
    $sort_by = $_GET['sort_by'];
} else {
    $sort_by = 'id';
}


$users = $user_gateway->get_users($sort_by, true, $search);
$view->render('index.phtml', [
    'users' => $users,
    'notification' => $notification ?? '',
    'title' => $title,
    'current_page' => 'index',
]);
