<?php

namespace App\Container\Helpers;

use Protocol, Cache;

class FilterHandler {
    
    public static function filter($filter, $data){

        if(isset($filter['cache'])){
            $cache = new Cache();
            $cache->cache_file($data);    
        }
        
        if(isset($filter['http_code'])){
            Protocol::send($filter['http_code']);
        }
        
    }
    
}