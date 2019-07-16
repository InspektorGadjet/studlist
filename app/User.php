<?php

#
#   USER ENTITY
#

class UserExeption extends Exception {}


class User {
    private $id;
    private $name;
    private $surname;
    private $gender;
    private $group_number;
    private $email;
    private $exam_score;
    private $birth_year;
    private $place;
    private $auth_key;

    function __construct($data) //принимает массив данных для заполнения свойств объекта
    {
        $available_keys = ['id', 'name', 'surname', 'gender', 'group_number', 
            'email', 'exam_score', 'birth_year', 'place', 'auth_key']; //доступные ключи для массива аргументов, они пойдут в свойства объекта

        if(array_keys($data) != $available_keys) {
            throw new UserExeption("Неверные данные для создания экземляра User");
        }

        foreach($data as $key => $value) { //заполняем свойства объекта
            $this->$key = $value;
        }
    }

    public function get_id()
    {
        return (int) $this->id;
    }

    public function get_name() 
    {
        return $this->name;
    }

    public function get_surname() 
    {
        return $this->surname;
    }

    public function get_gender() 
    {
        return $this->gender;
    }

    public function get_group_number()
    {
        return $this->group_number;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function get_exam_score() 
    {
        return (int)$this->exam_score;
    }

    public function get_birth_year() 
    {
        return (int)$this->birth_year;
    }

    public function get_place()
    {
        return $this->place;
    }

    public function get_auth_key() 
    {
        return $this->auth_key;
    }
}