<?php

#
# User Data Validation Class
#

class ValidatorException extends Exception {}

class DataValidator {
    public $errors = [];


    private function valid_name($name) 
    {
        if(mb_strlen($name) >= 50) {
            $this->errors[] = "Слишком длинное имя. Должно быть не более 50 символов, а вы ввели " . mb_strlen($name);
        }

        if(mb_strlen($name) < 1) {
            $this->errors[] = "Слишком короткое имя. Должен быть как минимум 1 символ, а вы ввели " . mb_strlen($name);
        }

        if(!preg_match('/^[а-яёa-z\-\'[:space:]]+$/uis', $name)) {
            $this->errors[] = "Недопустимые символы в имени. Допустимы буквы.";
        }
    }

    private function valid_surname($surname)
    {
        if(mb_strlen($surname) >= 50) {
            $this->errors[] = "Слишком длинная фамилия. Должно быть не более 50 символов, а вы ввели " . mb_strlen($surname);
        }

        if(mb_strlen($surname) < 1) {
            $this->errors[] = "Слишком короткая фамилия. Должен быть как минимум 1 символ, а вы ввели " . mb_strlen($surname);
        }

        if(!preg_match('/^[а-яёa-z\-\'[:space:]]+$/uis', $surname)) {
            $this->errors[] = "Недопустимые символы в фамилии. Допустимы буквы.";
        }
    }
    
    private function valid_gender($gender) 
    {
        if(!in_array($gender, [User::GENDER_MALE, User::GENDER_FEMALE])) {
            $this->errors[] = "Неверный пол";
        }
    }

    private function valid_group_number($num)
    {
        if(mb_strlen($num) < 2) {
            $this->errors[] = "Короткий номер группы. Должно быть не менее 2 символов, а вы ввели " . mb_strlen($num);
        }

        if(mb_strlen($num) > 5) {
            $this->errors[] = "Длинный номер группы. Должно быть не более 5 символов, а вы ввели " . mb_strlen($num);
        }

        if(!preg_match('/^[а-яёa-z0-9]+$/uis', $num)) {
            $this->errors[] = "Недопустимые символы в номере группы. Можно ввести только буквы и цифры";
        }
    }

    private function valid_email($email) 
    {
        if(mb_strlen($email) > 60) {
            $this->errors[] = "Длинный email. Допустимо не более 60 символов, а вы ввели " . mb_strlen($email);
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Неверный формат e-mail адреса";
        }
    }

    private function valid_exam_score($score) 
    {
        if(ctype_digit($score)) {
            if($score < 1) {
                $this->errors[] = "Количество баллов не может быть меньше 0";
            } 

            if($score > 500) {
                $this->errors[] = "Количество баллов не может быть больше 500";
            }
        } else {
            $this->errors[] = "Количество баллов должно быть числом.";
        }
    }

    private function valid_birth_year($year)
    {
        if(ctype_digit($year)) {
            if($year < 1901) {
                $this->errors[] = "Год рождения должен быть не меньше 1901.";
            } 

            if($year > (int)date('Y')) {
                $this->errors[] = "Дата рождения не может быть больше чем ". date('Y');
            }
        } else {
            $this->errors[] = "Год рождения должен быть целым числом.";
        }
    }

    private function valid_place($place)
    {
        if(!in_array($place, [User::PLACE_LOCAL, User::PLACE_NONLOCAL])) {
            $this->errors[] = "Неверное место";
        }
    }

    public function is_user_valid(User $user)
    {
        $this->valid_name($user->name);
        $this->valid_surname($user->surname);
        $this->valid_gender($user->gender);
        $this->valid_group_number($user->group_number);
        $this->valid_email($user->email);
        $this->valid_exam_score($user->exam_score);
        $this->valid_birth_year($user->birth_year);
        $this->valid_place($user->place);

        return empty($this->errors);
    }

}