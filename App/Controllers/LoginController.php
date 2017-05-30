<?php
namespace App\Controllers;

use Controller, Request, View;

class LoginController extends Controller {

	// Login View
	public function login(Request $data){
		return View::make('login');
	}

	public function login_action(Request $data){

		$msg = Account::login($data->post->username, $data->post->password);

		return View::make('login', [
			'msg' => $msg
		]);
	}

	public function register(){

		return View::make('register');
	}

	// Logout function
	public function logout(Request $data){
		Account::logout();
		return View::make('index');
	}

}
