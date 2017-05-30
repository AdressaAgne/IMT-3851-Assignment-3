<?php
namespace App\Controllers;

use Controller, Request, View, Account;

class MainController extends Controller {

	use \MigrateTrait;

	// Main index view
	public function index(Request $data){
		return View::make('index');
	}

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

	// Logout function
	public function logout(Request $data){
		Account::logout();
		return View::make('index');
	}
}
