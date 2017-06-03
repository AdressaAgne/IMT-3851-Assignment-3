<?php
namespace App\Controllers;

use Controller, Request, View, Account;

class MainController extends Controller {

	// /migrate, to rebuild the database
	use \MigrateTrait;

	/**
	 * Main index view
	 * @method index
	 * @author [Agne Ødegaard]
	 * @param  Request $data [description]
	 * @return View
	 */
	public function index(Request $data){
		$itemController = new ItemController();
		$sql = $itemController->sql;

		return View::make('index', [
			'items' => $this->query($sql.' GROUP BY i.id', 'Item')->fetchAll(),
		]);
	}
}
