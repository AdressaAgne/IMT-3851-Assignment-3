<?php

namespace App\Modules;

use DB, Module;


class Category extends DB implements Module {

    function __construct(){

    }


    public function delete(){
        $this->deleteWhere('category', 'id', $this->id);
    }

}
