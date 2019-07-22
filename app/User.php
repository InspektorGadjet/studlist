<?php

#
#   USER ENTITY
#

class UserExeption extends Exception {}


class User {
    public $id;
    public $name;
    public $surname;
    public $gender;
    public $group_number;
    public $email;
    public $exam_score;
    public $birth_year;
    public $place;
    public $auth_key;

    public static function get_random_auth_key() 
    {
        return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,32);
    }

    public function fill_from_post($request) 
    {
        $this->name = trim(strval($request['name'])) ?? '';
        $this->surname = trim(strval($request['surname'])) ?? '';
        $this->email = trim(strval($request['email'])) ?? '';
        $this->group_number = trim(strval($request['group_number'])) ?? '';
        $this->birth_year = trim(intval($request['birth_year'])) ?? '0';
        $this->gender = trim(strval($request['gender'])) ?? '';
        $this->exam_score = trim(intval($request['exam_score'])) ?? '0';
        $this->place = trim(strval($request['place'])) ?? '';
    }
}