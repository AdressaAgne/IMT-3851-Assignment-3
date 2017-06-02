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

		return ['status' => $msg, 'toast' => 'Welcome ' . $data->post->username];
	}

	public function register(){

		return View::make('register');
	}

	// Logout function
	public function logout(Request $data){
		Account::logout();
		return ['toast' => 'You have logged out'];
	}
	//Register function
	public function save(Request $data){
		if(empty($data->post->username))
			return ['invalid' => 'username'];
		if(empty($data->post->password))
			return ['invalid' => 'password'];
		if(empty($data->post->password_again))
			return ['invalid' => 'password_again'];
		if(empty($data->post->mail))
			return ['invalid' => 'mail'];


		$user = Account::register($data->post->username, $data->post->password, $data->post->password_again, $data->post->mail);
		if(is_numeric($user) && $user > 0)
			return ['status' => 'ok'];
		return ['status' => $user];
	}

	public function menu(){
		return View::make('layout.menu');
	}
}
