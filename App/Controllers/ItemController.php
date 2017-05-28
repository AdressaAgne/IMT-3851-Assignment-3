<?php
namespace App\Controllers;

use Controller, Request, View;

class ItemController extends Controller {

    // Multiple items view
    public function index(Request $data){
        return View::make('item.index');
    }

    // Single item view
    public function item(Request $data){
        return View::make('item.item');
    }

    // Edit item view
    public function edit(Request $data){
        return View::make('item.edit');
    }

    // Create a new item
    public function put(Request $data){
        return [$data];
    }

    // Edit an item
    public function patch(Request $data){
        return [$data];
    }

    // Delete an item
    public function delete(Request $data){
        return [$data];
    }

}
