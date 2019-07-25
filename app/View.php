<?php

#
#   View Class
#

class View {

    const TPL_DIR = "../tpl/";

    public function render($template, $params = []) //отрисовка шаблона
    {
        extract($params);
        include_once(self::TPL_DIR.$template);
    }

    public static function get_sort_link($sort_by, $reverse) //генерация ссылок сортировки
    {
        $link =  "/index.php?".http_build_query(array_merge($_GET, [
            'sort_by' => $sort_by,
            'reverse' => $reverse,
        ]));

        return htmlspecialchars($link);
    }

    
    public static function get_page_link($page) //генерация ссылок на страницы
    {
        $link =  "/index.php?".http_build_query(array_merge($_GET, [
            'page' => $page,
        ]));

        return htmlspecialchars($link);
    }
}