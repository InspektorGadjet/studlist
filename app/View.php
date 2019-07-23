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

    public function get_sort_link($sort_by, $reverse) //генерация ссылок сортировки
    {
        $link =  "/index.php?".http_build_query(array_merge($_GET, [
            'sort_by' => $sort_by,
            'reverse' => $reverse,
        ]));

        return htmlspecialchars($link);
    }
}