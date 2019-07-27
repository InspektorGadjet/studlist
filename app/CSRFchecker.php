<?php

#
#   CSRF Checker Class
#

class CSRFexception extends Exception {};

class CSRFchecker {
    public $token;

    public function set_cookie_token()
    {
        $this->token = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,32);
        setcookie('CSRF_token', $this->token, time() + 3600*24, '/');
    }

    public function get_cookie_token($cookie)
    {
        $this->token = $cookie['CSRF_token'];
    }

    public function is_token_set($cookie)
    {
        return isset($cookie['CSRF_token']);
    }

    public function is_token_right($post, $cookie)
    {
        return ($post['CSRF_token'] == $cookie['CSRF_token']) ? true : false;
    }
}