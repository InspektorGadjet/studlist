<?php
#
#   MAIN PAGE CONTROLER
#

include_once "../bootstrap.php";

$users = $user_gateway->get_users('id');

$view->render('index.phtml', [
    'users' => $users,
]);
