<?php

#
# APP INIT FILE
#

include_once "../app/User.php";
include_once "../app/UserTableGateway.php";
include_once "../app/UserValidation.php";
include_once "../app/View.php";
include_once "../app/Paginator.php";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=students',
    'root',
    '123',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} 

catch(PDOException $e) {
    die("Нет соединения с базой данных <pre>".$e."</pre");
}

$user_gateway = new UserTableGateway($pdo);
$view = new View();