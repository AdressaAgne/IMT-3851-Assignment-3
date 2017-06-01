<?php
namespace App\Controllers;

use Controller, Request, View;

class ItemController extends Controller {

	public $sql = "SELECT
		i.*,
		GROUP_CONCAT(c.name) AS categories,
		u.username AS username

		FROM items AS i

		LEFT JOIN item_category AS ic ON i.id = ic.item_id
		LEFT JOIN categories    AS c  ON c.id = ic.category_id
		LEFT JOIN users         AS u  ON u.id = i.user_id";

	// Multiple items view
	public function index(){
		return View::make('item.index', [
			'items' => $this->query($this->sql.' GROUP BY i.id', 'Item')->fetchAll(),
		]);
	}

	// Single item view
	public function item(Request $data){
		if(!isset($data->get->id)) return $this->index();

		return View::make('item.item', [
			'item' => $this->get_single($data->get->id),
		]);
	}

	// Edit item view
	public function edit(Request $data){
		if(!isset($data->get->id)) return $this->index();

		$item = $this->get_single($data->get->id);
		if(Account::get_id() != $item->user_id) return $this->index();

		return View::make('item.edit', ['item' => $item]);
	}

	// Item Categoriy View
	public function categories(Request $data){
		if(!isset($data->get->cat)) return $this->index();
		$sql = $this->sql;
		$sql .= ' WHERE c.name = :cat GROUP BY i.id';
		$items = $this->query($sql, [
			'cat' => $data->get->cat,
		], 'Item')->fetchAll();

		return View::make('item.index', ['items' => $items]);
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


	/*
	*  Functions
	*/

	// return a single Item
	private function get_single($id){
		$sql = $this->sql;
		$sql .= ' WHERE i.id = :id GROUP BY i.id';

		return $this->query($sql, [
			'id' => $id,
		],'Item')->fetch();
	}

}
