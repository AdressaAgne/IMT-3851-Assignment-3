<?php
namespace App\Controllers;

use Controller, Request, View, Account;

class MainController extends Controller {

	use \MigrateTrait;

	// Main index view
	public function index(Request $data){
		$itemController = new ItemController();
		$sql = $itemController->sql;

		return View::make('index', [
			'items' => $this->query($sql.' GROUP BY i.id', 'Item')->fetchAll(),
		]);
	}
}
