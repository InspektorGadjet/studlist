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


    public function get_users($order_by, $reverse = FALSE, $search = NULL) //возвращает массив объектов User всех пользователей по критериям
    {
        $query = "SELECT * FROM users"; //начало запроса

        $bind_values = []; //массив для параметров запроса

        if(!is_null($search)) { //если есть поиск, то добавляем к запросу
            $search = strval(htmlspecialchars(trim($search))); 
            $query .= " WHERE CONCAT(name, ' ', surname, ' ', group_number) LIKE :str";
            $bind_values[':str'] = '%'.$search.'%';
        }


        if(in_array($order_by, ['id', 'name', 'surname', 'group_number', 'exam_score'])) { //допустимые поля для сортировки
            $query .= " ORDER BY ".$order_by; //добавляем сортировку к запросу
        } else {
            throw new UserTableException("Недопустимый параметр сортировки");
        }

        if($reverse) {
            $query .= " ASC";
        } else {
            $query .= " DESC";
        }

        $exec = $this->db->prepare($query);
        $exec->execute($bind_values); 
        $users_array = $exec->fetchAll(PDO::FETCH_CLASS, "User");
       
        return $users_array; 
    }

    public function get_users_number()
    {
        $query = "SELECT COUNT(*) FROM users";
        $exec = $this->db->query($query);
        return $exec->fetch();
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

        if($user) { //если пользователь найден в бд
            return $user;
        } else {
            throw new UserTableException("Пользователь не найден по коду авторизации");
        }
    }


    public function update_user(User $olduser, User $newuser) { //обновление данных пользователя
        $query = "UPDATE users SET name = :name, surname = :surname, gender = :gender,
            group_number = :group_number, email = :email, exam_score = :exam_score,
            birth_year = :birth_year, place = :place, auth_key = :auth_key WHERE id = :id LIMIT 1";

        $exec = $this->db->prepare($query); 
        $exec->execute([ //обновляем все данные кроме id и authkey
            ':id' => $olduser->id,
            ':name' => $newuser->name,
            ':surname' => $newuser->surname,
            ':gender' => $newuser->gender,
            ':group_number' => $newuser->group_number,
            ':email' => $newuser->email,
            ':exam_score' => $newuser->exam_score,
            ':birth_year' => $newuser->birth_year,
            ':place' => $newuser->place,
            ':auth_key' => $olduser->auth_key,
        ]);
    }
}