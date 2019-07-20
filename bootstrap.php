<?php

#
# APP INIT FILE
#

include_once $_SERVER['DOCUMENT_ROOT']."/app/User.php";
include_once $_SERVER['DOCUMENT_ROOT']."/app/UserTableGateway.php";
include_once $_SERVER['DOCUMENT_ROOT']."/app/UserValidation.php";

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