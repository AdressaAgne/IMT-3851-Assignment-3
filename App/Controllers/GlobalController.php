<?php

namespace App\Controllers;

class GlobalController {
    public function __construct($db){
        $this->db = $db;
    }

    public function categories(){
        return array_column($this->db->all('categories'), 'name');
    }

}
