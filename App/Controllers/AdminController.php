<?php
namespace App\Controllers;

use Controller, Request, View;

class AdminController extends Controller {

    public function index(Request $data){
        return [$data];
    }

}
