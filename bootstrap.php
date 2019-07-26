<?php

#
# APP INIT FILE
#

include_once "../app/User.php";
include_once "../app/UserTableGateway.php";
include_once "../app/UserValidation.php";
include_once "../app/View.php";
include_once "../app/Paginator.php";

$dbconfig = parse_ini_file('dbconfig.ini');
if(!$dbconfig) {
    throw new Exception("Неверный путь к dbconfig.ini");
}


try {
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