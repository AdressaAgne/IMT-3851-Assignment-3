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
		return View::make('index', [
			'items' => $this->query($this->sql.' GROUP BY i.id ORDER BY i.time DESC', 'Item')->fetchAll(),
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

		return View::make('item.create', ['item' => $item]);
	}

	// Item Categoriy View
	public function categories(Request $data){
		if(!isset($data->get->cat)) return ['error' => 'no category_id'];
		$sql = $this->sql;
		$sql .= ' WHERE c.name = :cat GROUP BY i.id  ORDER BY i.time DESC';
		$items = $this->query($sql, [
			'cat' => $data->get->cat,
		], 'Item')->fetchAll();

		return View::make('index', [
			'items' => $items,
			'page' => $data->get->cat,
		]);
	}

	// Create a new item
	public function put(Request $data){
		if(empty($data->post->title)) return ['toast' => 'Title is invalid', 'invalid' => 'title'];
		if(empty($data->post->description)) return ['toast' => 'Description is invalid', 'invalid' => 'description'];

		$id = $this->insert('items', [
			[
				'user_id' => Account::get_id(),
				'title' => $data->post->title,
				'description' => $data->post->description
			]
		]);

		if(isset($data->post->cats)){
			$cats = [];
			foreach ($data->post->cats as $cat) {
				$cats[] = [
					'category_id' => $cat,
					'item_id' => $id,
				];
			}

			$this->insert('item_category', $cats);
		}
		return ['toast' => 'Item '.$data->post->title.' added'];
	}

	// Edit an item
	public function patch(Request $data){
		if(!Account::isLoggedIn()) return ['toast' => 'You need to login to post and item'];

		$item = $this->select('items', ['user_id', 'id'], ['id' => $data->post->id], 'Item')->fetch();
		if($item->user_id !== $this->user->id) return ['toast' => 'You do not own this post'];

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


		return ['toast' => 'Item '.$data->post->title.' Updated'];
	}

	// Delete an item
	public function delete(Request $data){
		if(!Account::isLoggedIn()) return ['toast' => 'You need to login'];

		$item = $this->select('items', ['user_id', 'id', 'title'], ['id' => $data->post->id], 'Item')->fetch();

		if(empty($item)) return ['toast' => 'This item does not exist'];

		if($item->user_id !== $this->user->id) return ['toast' => 'You do not own this post...'];

		$this->deleteWhere('items', 'id', $data->post->id);

		return ['toast' => 'Item '.$item->title.' deleted'];
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
