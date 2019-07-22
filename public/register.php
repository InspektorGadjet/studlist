<?php

#
# Registration page controller
#

include_once "../bootstrap.php";


if($_SERVER['REQUEST_METHOD'] == 'POST') { //запрос на регистрацию
    $user = new User();
    $validator = new DataValidator();

    $user->fill_from_post($_POST);
    $user->auth_key = User::get_random_auth_key();

    if($validator->is_user_valid($user)) {
        $user_gateway->create_new_user($user);
        setcookie('auth_key', $user->auth_key, time() + 3600*24*365*10, '/');
        header('location: /');
    } else {
        $view->render('register.phtml', [
            'title' => 'Форма регистрации студента',
            'errors' => $validator->errors
            ]);
    }
    die();
}

$view->render('register.phtml', [
    'title' => 'Форма регистрации студента',
]);