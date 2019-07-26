<?php

#
# APP INIT FILE
#

spl_autoload_register(function ($class) {  //автозагрузка классов
    $path = '../app/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});


$dbconfig = parse_ini_file('dbconfig.ini'); //парсим конфиг базы данных
if(!$dbconfig) {
    throw new Exception("Неверный путь к dbconfig.ini");
}


try { //подключаемся к бд
    $pdo = new PDO('mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['database'],
        $dbconfig['user'],
        $dbconfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch(PDOException $e) {
    die("Нет соединения с базой данных <pre>" . $e->getMessage() . "</pre");
}

$user_gateway = new UserTableGateway($pdo);
$view = new View();