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

        foreach($table_data as $row) { //создаем новый объект из данных строки в бд
            $data = []; //массив данных для создания объекта user
            $data['name'] = $row['name'];
            $data['surname'] = $row['surname'];
            $data['gender'] = $row['gender'];
            $data['group_number'] = $row['group_number'];
            $data['email'] = $row['email'];
            $data['exam_score'] = $row['exam_score'];
            $data['birth_year'] = $row['birth_year'];
            $data['place'] = $row['place'];
            $data['auth_key'] = $row['auth_key'];
            
            $user = new User($data);
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
        var_dump($data);
        foreach($data as $key=>$value) { //заполняем запрос параметрами из данных $data
            $exec->bindValue(':'.$key, $value); 
        }
        $exec->execute();
    }

}