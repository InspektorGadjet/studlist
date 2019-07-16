<?php

#
# APP INIT FILE
#

try {
    global $pdo;
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
?>