<?php
namespace App\Controllers;

use Controller, Request, View, Account;

class MainController extends Controller {

	use \MigrateTrait;

	// Main index view
	public function index(Request $data){
		return View::make('index');
	}



	
}
