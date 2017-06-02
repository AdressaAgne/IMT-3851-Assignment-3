<?php
namespace App\Controllers;

use Controller, Request, View, Account;

class LoginController extends Controller {

	// Login View
	public function login(Request $data){
		return View::make('login');
	}

	public function login_action(Request $data){

		$msg = Account::login($data->post->username, $data->post->password);

		return ['status' => $msg];
	}

	public function register(){

		return View::make('register');
	}

	// Logout function
	public function logout(Request $data){
		Account::logout();
		return View::make('index');
	}
	//Register function
	public function save(Request $data){
		if(!isset($data->post->username)) return ['status' => 'Username missing'];
		if(!isset($data->post->password)) return ['status' => 'Password missing'];
		if(!isset($data->post->password_again)) return ['status' => 'Confirm Password missing'];
		if(!isset($data->post->mail)) return ['status' => 'Mail missing'];


		$user = Account::register($data->post->username, $data->post->password, $data->post->password_again, $data->post->mail);
		if(is_numeric($user) && $user > 0)
			return ['status' => 'ok'];
		return ['status' => $user];
	}
}
