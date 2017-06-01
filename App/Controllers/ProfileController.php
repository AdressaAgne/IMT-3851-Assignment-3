<?php
namespace App\Controllers;

use Controller, Request, View;

class ProfileController extends Controller {

	// Profile view
	public function index(Request $data){
		$user = parent::$site_wide_vars['user'];
		if(isset($data->get->username))
			$user = $this->select('users', ['*'], ['username' => $data->get->username], 'User')->fetch();

		return View::make('profile.index', [
			'profile' => $user,
		]);
	}

	// Edit profile View
	public function edit(Request $data){
		return View::make('profile.edit', [
			'profile' => parent::$site_wide_vars['user'],
		]);
	}

	// Edit profile api 
	public function store(Request $data){
		$update = $this->updateWhere('users', [
			'name'     => $data->post->name,
			'surname'  => $data->post->surname,
			'mail'     => $data->post->mail,
			'username' => $data->post->username,
		], ['id' => Account::get_id()]);

		if($update)
			return ['updated' => true];
		return ['updated' => false];
	}

	public function patch(Request $data){
		return Account::changePassword(parent::$site_wide_vars['user'], $data->post->old_pw, $data->post->new_pw, $data->post->new_pw2);
	}
}
