<?php

#
#   User Table Gateway
#

class UserTableException extends Exception {}

class UserTableGateway {
    private $db;


    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }


    public function get_all_users() //возвращает массив объектов User всех пользователей
    {
        $query = "SELECT * FROM users ORDER BY id DESC";
        $users_array = $this->db->query($query)->fetchAll(PDO::FETCH_CLASS, "User");
        
        return $users_array;
    }

    public function create_new_user(User $user) { //запись пользователя в БД
        $query = "INSERT INTO users VALUE (NULL, :name, :surname, :gender, :group_number,
            :email, :exam_score, :birth_year, :place, :auth_key)"; //SQL запрос на добавление записи о пользователе
        $exec = $this->db->prepare($query); 
        $exec->execute([
            ':name' => $user->name,
            ':surname' => $user->surname,
            ':gender' => $user->gender,
            ':group_number' => $user->group_number,
            ':email' => $user->email,
            ':exam_score' => $user->exam_score,
            ':birth_year' => $user->birth_year,
            ':place' => $user->place,
            ':auth_key' => $user->auth_key,
        ]);
    }

    public function get_user_by_auth_key($auth_key) { //получить объект пользователя по коду авторизации
        $query = "SELECT * FROM users WHERE auth_key = :auth_key LIMIT 1";
        $exec = $this->db->prepare($query);
        $exec->execute([':auth_key' => $auth_key]);
        $exec->setFetchMode(PDO::FETCH_CLASS, 'User');
        $user = $exec->fetch();

        if(!$user) { //если пользователь найдет в бд
            return $user;
        } else {
            throw new UserTableException("Пользователь не найден по коду авторизации");
        }
    }

    public function update_user(User $user) {
        $query = "UPDATE users SET name = :name, surname = :surname, gender = :gender,
            group_number = :group_number, email = :email, exam_score = :exam_score,
            birth_year = :birth_year, place = :place, auth_key = :auth_key WHERE id = :id";

        $exec = $this->db->prepare($query); 
        $exec->execute([
            ':id' => $user->id,
            ':name' => $user->name,
            ':surname' => $user->surname,
            ':gender' => $user->gender,
            ':group_number' => $user->group_number,
            ':email' => $user->email,
            ':exam_score' => $user->exam_score,
            ':birth_year' => $user->birth_year,
            ':place' => $user->place,
            ':auth_key' => $user->auth_key,
        ]);
    }

}