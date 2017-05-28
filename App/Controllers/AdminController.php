<?php
namespace App\Controllers;

use Controller, Request, View;

class AdminController extends Controller {

    // Admin View
    public function index(Request $data){
        return View::make('admin.index');
    }

}
