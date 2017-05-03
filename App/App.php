<?php
namespace App;

use RouteHandler, Cache, Config;

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
            
            // create a cahced version of the file if it exists
            if(isset($page->filter['cache']) && $page->filter['cache']) $cache->cache_file($page->data);
            
            if(gettype($page->data) == 'string'){
                echo $page->data;
            } else {
                header('Content-type: application/json');
                echo json_encode($page->data, JSON_UNESCAPED_UNICODE);
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
