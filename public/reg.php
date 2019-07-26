<?php

#
# Registration page controller
#

include_once "../bootstrap.php";


if($_SERVER['REQUEST_METHOD'] == 'POST') { //запрос на регистрацию или обновление
    $user = new User(); //объект с данными пользователя из формы
    $validator = new UserValidation();

    $user->fill_from_post($_POST);


    if($validator->is_user_valid($user)) { //если нет ошибок в форме

        if(isset($_COOKIE['auth_key'])) { //если есть кука, то редактируем пользователя
            $current_user = $user_gateway->get_user_by_auth_key($_COOKIE['auth_key']);
            $user_gateway->update_user($current_user, $user); //заменяем данные текущего пользователя на данные из формы в $user
            header('location: /index.php?note=updated');

        } else { //если куки нет, то создаем нового пользователя
            $user->auth_key = User::get_random_auth_key();
            $user_gateway->create_new_user($user);
            setcookie('auth_key', $user->auth_key, time() + 3600*24*365*10, '/');
            header('location: /index.php?note=registred');
        }

    } else { //если форма с ошибками, то снова выводим её

        $view->render('reg.phtml', [
            'title' => 'Форма регистрации студента',
            'errors' => $validator->errors,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'group_number' => $user->group_number,
            'birth_year' => $user->birth_year,
            'gender' => $user->gender,
            'exam_score' => $user->exam_score,
            'place' => $user->place,
            'current_page' => 'reg',
        ]);
    }
    die();
}


if(isset($_COOKIE['auth_key'])) { //если пользователь авторизован
    $current_user = $user_gateway->get_user_by_auth_key($_COOKIE['auth_key']); //выводим форму редактировния
    $view->render('reg.phtml', [ //выводим форму редактировния
        'title' => 'Форма редактирования студента', 
        'errors' => [],
        'name' => $current_user->name,
        'surname' => $current_user->surname,
        'email' => $current_user->email,
        'group_number' => $current_user->group_number,
        'birth_year' => $current_user->birth_year,
        'gender' => $current_user->gender,
        'exam_score' => $current_user->exam_score,
        'place' => $current_user->place,
        'current_page' => 'reg'
    ]);
    
} else {
    $view->render('reg.phtml', [ //если не авторизован, выводим форму регистрации
        'title' => 'Форма регистрации студента',
        'errors' => [],
        'name' => '',
        'surname' => '',
        'email' => '',
        'group_number' => '',
        'birth_year' => '2000',
        'gender' => User::GENDER_MALE,
        'exam_score' => '',
        'place' => 'local',
        'current_page' => 'reg'
    ]);
}