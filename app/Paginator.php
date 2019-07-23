<?php

#
# Paginator Class
#

class PaginatorException extends Exception {}

class Paginator {
    public $total_items;
    public $items_per_page;
    public $current_page;

    public function __construct($total_items, $items_per_page, $current_page)
    {
        $this->total_items = $total_items;
        $this->items_per_page = $items_per_page;
        $this->current_page = $current_page;
    }
}