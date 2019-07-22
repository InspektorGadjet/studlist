<?php

#
#   View Class
#

class View {

    const TPL_DIR = "../tpl/";

    public function render($template, $params = [])
    {
        extract($params);
        include_once(self::TPL_DIR.$template);
    }
}