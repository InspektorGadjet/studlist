<?php

#
# Paginator Class
#

class PaginatorException extends Exception {}

class Paginator {
    public $enabled;
    public $current_page;

    private $total_items;
    private $items_per_page;

    public function __construct($total_items, $items_per_page, $current_page)
    {
        $this->total_items = $total_items;
        $this->items_per_page = $items_per_page;
        $this->current_page = $current_page;

        if($total_items <= $items_per_page) { //выключаем пагинацию, если все элементы умещаются на одной странице
            $this->enabled = false; 
        } else {
            $this->enabled = true;
        }
    }

    public function get_total_pages_array() 
    {
        $total_pages = ceil($this->total_items / $this->items_per_page);
        return range(1, $total_pages);
    }

    public function get_limit()
    {
        return $this->items_per_page;
    }


    public function get_offset()
    {
        return $this->items_per_page * ($this->current_page - 1);
    }
}