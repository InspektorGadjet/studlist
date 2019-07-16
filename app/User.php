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
}