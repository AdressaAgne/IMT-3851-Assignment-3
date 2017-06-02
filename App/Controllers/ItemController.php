<?php
namespace App\Controllers;

use Controller, Request, View, Account, Direct;

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

		$item = $this->get_single($data->get->id);
		if(is_object($item))
			return View::make('item.item', [
				'item' => $item,
			]);
		return $this->index();
	}

	public function create(){
		if(Account::isLoggedIn())
			return View::make('item.create');
	}

	// Edit item view
	public function edit(Request $data){
		if(!isset($data->get->id) || !Account::isLoggedIn()) return $this->index();

		$item = $this->get_single($data->get->id);
		if(Account::get_id() != $item->user_id) return $this->index();

		return View::make('item.edit', ['item' => $item]);
	}

	// Item Categoriy View
	public function categories(Request $data){
		if(!isset($data->get->cat)) return ['error' => 'no category_id'];
		$sql = $this->sql;
		$sql .= ' WHERE c.name = :cat GROUP BY i.id';
		$items = $this->query($sql, [
			'cat' => $data->get->cat,
		], 'Item')->fetchAll();

		return View::make('item.index', [
			'items' => $items,
		]);
	}

	// Create a new item
	public function put(Request $data){
		$id = $this->insert('items', [
			[
				'user_id' => Account::get_id(),
				'title' => $data->post->title,
				'description' => $data->post->description
			]
		]);

		$cats = [];
		foreach ($data->post->cats as $cat) {
			$cats[] = [
				'category_id' => $cat,
				'item_id' => $id,
			];
		}

		$this->insert('item_category', $cats);

		return Direct::re('item/'.$id);
	}

	// Edit an item
	public function patch(Request $data){
		if(!Account::isLoggedIn()) return ['status' => 'failed'];

		$item = $this->select('items', ['user_id', 'id'], ['id' => $data->post->id], 'Item')->fetch();
		if($item->user_id !== $this->user->id) return ['status' => 'failed'];

		$this->updateWhere('items', [
			'title' => $data->post->title,
			'description' => $data->post->description
		], ['id' => $item->id]);

		$this->deleteWhere('item_category', 'item_id', $item->id);
		$cats = [];
		foreach ($data->post->cats as $cat) {
			$cats[] = [
				'category_id' => $cat,
				'item_id' => $item->id,
			];
		}
		$this->insert('item_category', $cats);


		return Direct::re('item/'.$item->id);
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
