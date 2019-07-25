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
    $title = 'Студенты по запросу "' . htmlspecialchars($search) . '"';
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

#       REVERSE
if(isset($_GET['reverse'])) {
    $reverse = boolval($_GET['reverse']);
} else {
    $reverse = true;
}

#       PAGE
if(isset($_GET['page'])) {
    $page_num = intval($_GET['page']);
} else {
    $page_num = 1;
}
$items_per_page = 5;
$paginator = new Paginator($user_gateway->get_users_number(), $items_per_page, $page_num);




$users = $user_gateway->get_users(
    $sort_by, 
    $reverse, 
    $paginator->get_limit(), 
    $paginator->get_offset(),
    $search
);

$view->render('index.phtml', [
    'users' => $users,
    'notification' => $notification ?? '',
    'title' => $title,
    'current_page' => 'index',
    'paginator' => $paginator,
]);
