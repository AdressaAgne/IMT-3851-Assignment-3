<?php

/**
*   Direct Setup
*   Direct::[get, post, put, patch, delete, debug](url, [controller@method, controller, callable])->[Auth(), Admin(), Mod(), Cache()]
*   Example:
*   Direct::get('/', 'MainController@index')
*   Direct::get('/profole', 'MainController@profole')->auth()
* 
*   url = /test/{var}/{optional?}
*   add a ? at the end of a variable to make it optional like {var?}
*
*   if you do not set a method, it will try to call the route as a method instead
*   Direct::get("/home", 'MainController');
*   this will try to call the home method in the MainController
*
*   Aditional you can do:
*   for GET, POST, PATCH, PUT, DELETE at the same time (does not include ERROR)
*   Direct::all(url, callable);
*   Or if you want more then one method but not all
*   Direct::on([GET, POST, PATCH, PUT, DELETE, ERROR], url, callable);
*/

// Direct::get('/test', function(){
//     return '<h1>This is supposed to be cached lol</h1>';
// })->Cache();


// Mainpage
Direct::get("/", 'MainController@index');


// Errors
Direct::error('404', function(Request $request){
    return '404 page does not exist';
});


// Debug routes
Direct::debug("/route", 'MainController');
Direct::debug("/migrate", 'MainController');