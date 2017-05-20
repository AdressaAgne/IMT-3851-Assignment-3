<?php
namespace App;

use RouteHandler, Cache, Config, Protocol;

class App extends RouteHandler{

    public function __construct(){
        
        // CSRF token - Cross-site Request Forgery
        $this->set_csrf();
        
        $cache = new Cache();
        
        if($cache->has_cached_file()){
            
            //load chached file if it exists
            echo $cache->get_cached_file();
            
        } else {
            $page = $this->get_page_data();
            
            if(gettype($page) == 'string'){
                echo $page;
            } else {
                header('Content-type: application/json');
                echo json_encode($page, JSON_UNESCAPED_UNICODE);
                return;
            }
        }
    }
    
    private function set_csrf(){
        if (!isset($_SESSION['_token'])){
            $_SESSION['_token'] = uniqid();
            Config::$form_token = $_SESSION['_token'];
        }
    }
}
