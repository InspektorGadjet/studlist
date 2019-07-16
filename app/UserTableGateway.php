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
        $table_data = $this->db->query($query)->fetchAll();
        
        $users_data = []; //массив для объектов User

        foreach($table_data as $row) { 
            $user = new User($row); //создаем новый объект из данных строки в бд
            $users_data[] = $user; //записываем наш объект в полный массив всех пользователей
        }
    
        return $users_data;
    }

    public function create_new_user($data) { //создание нового пользователя из массива его данных

        $available_keys = ['name', 'surname', 'gender', 'group_number', 
        'email', 'exam_score', 'birth_year', 'place', 'auth_key']; //доступные ключи для массива аргументов

        if(array_keys($data) != $available_keys) {
            throw new UserTalbeExeption("Неверные данные для создания нового пользователя");
        }

        $query = "INSERT INTO users VALUE (NULL, :name, :surname, :gender, :group_number,
            :email, :exam_score, :birth_year, :place, :auth_key)"; //SQL запрос на добавление записи о пользователе
        $exec = $this->db->prepare($query); 

        foreach($data as $key=>$value) { //заполняем запрос параметрами из данных $data
            $exec->bindValue(':'.$key, $value); 
        }
        $exec->execute();
    }

    public function get_user_by_auth_key($auth_key) {
        $query = "SELECT * FROM users WHERE auth_key = :auth_key LIMIT 1";
        $exec = $this->db->prepare($query);
        $exec->execute([':auth_key' => $auth_key]);
        $data = $exec->fetch();

        if($data != FALSE) { //если пользователь найден в бд, то создаем его экземпляр
            $user = new User($data);
            return $user;
        } else {
            throw new UserTableException("Неверный код авторизации");
        }
    }

}