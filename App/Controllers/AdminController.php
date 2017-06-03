<?php
namespace App\Controllers;

use Controller, Request, View, Account, Direct;

class AdminController extends Controller {

	// Admin View
	public function index(Request $data){
		if(!Account::isLoggedIn() && $this->user->isAdmin()) return Direct::re('/');

		return View::make('admin.index', [
			'users' => $this->select('users', ['*'], null, 'User')->fetchAll(),
		]);
	}

	public function delete_cat(Request $data){
		if(!Account::isLoggedIn() && $this->user->isAdmin()) ['toast' => 'You need to be an Admin to do that'];
		if(empty($data->post->id)) return ['toast' => 'Hidden value id can not be empty'];

		$this->deleteWhere('categories', 'id', $data->post->id);
		return ['toast' => 'Category Deleted'];
	}

	public function delete_user(Request $data){
		if(!Account::isLoggedIn() && $this->user->isAdmin()) ['toast' => 'You need to be an Admin to do that'];
		if(empty($data->post->id)) return ['toast' => 'Hidden value id can not be empty'];

		$this->deleteWhere('users', 'id', $data->post->id);
		return ['toast' => 'User Deleted'];
	}

	public function put_cat(Request $data){
		if(!Account::isLoggedIn() && $this->user->isAdmin()) ['toast' => 'You need to be an Admin to do that'];
		if(empty($data->post->name)) return ['toast' => 'Please enter a category name'];

		$msg = @$this->insert('categories',[
			[
				'name' => $data->post->name
			]
		]);
		if(!$msg) return ['toast' => 'A category names '.$data->post->name.' already exist'];
		return ['toast' => 'You added category '.$data->post->name, 'status' => true, 'name' => $data->post->name];
	}



}
