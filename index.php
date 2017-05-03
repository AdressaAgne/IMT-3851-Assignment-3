<?php

use \App\Config as Config;

// Start a session if it does not exist
if(!isset($_SESSION)) session_start();

// Generate a new PHP Session ID to prevent session hijacking.
session_regenerate_id();

/**
 * SPL autoloader, so we dont need to include files everywhere
 * @author Agne *degaard
 * @param function function($class)
 */
spl_autoload_register(function($class){
    $file = str_replace('\\', '/', "{$class}.php");
    if(file_exists($file)){
        require_once($file);
    }
});

// Setting up aliases
foreach(Config::$aliases as $key => $value){
    class_alias($key, $value);
}

// Define constants
foreach (Config::$constants as $key => $value) {
    define($key, $value);
}

function dd(...$param){
    @header('Content-type: application/json');
    die(print_r($param, true));
}

// Adding routing
require_once('App/RouteSetup.php');

// require the application
require_once("App/App.php");

// Run App constrcut everything
new App\App();