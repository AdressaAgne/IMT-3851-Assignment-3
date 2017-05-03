<?php
namespace App\Controllers;

use View, Config, Direct, Request;

class MainController extends Controller {

    use \MigrateTrait;
    
    public function index(Request $data){

        return View::make('index', [
            'data' => $data,
        ]);
    }
    
    
    public function route(){
        return Direct::lists();
    }
    
    
    
}
