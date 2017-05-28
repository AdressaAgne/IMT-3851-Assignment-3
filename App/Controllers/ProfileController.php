<?php
namespace App\Controllers;

use Controller, Request, View;

class ProfileController extends Controller {

    // Profile view
    public function index(Request $data){
        return View::make('profile.index');
    }

    // Edit profile View
    public function edit(Request $data){
        return View::make('profile.edit');
    }

    // Edit profile api
    public function store(Request $data){
        return [$data];
    }

}
