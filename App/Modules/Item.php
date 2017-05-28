<?php

namespace App\Modules;

use DB, Module;


class Item extends DB implements Module {

    private $time;

    public function __construct(){


    }

    public function get_categories(){
        return explode(',', $this->categories);
    }

    public function user(){
        return new user($this->user_id);
    }

    public function created(){
        return date('d/m/y', strtotime($this->time));
    }

}