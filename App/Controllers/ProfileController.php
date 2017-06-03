<?php
namespace App\Controllers;

use Controller, Request, View, Account;

class ProfileController extends Controller {

	// Profile view
	public function index(Request $data){
		$user = $this->user;
		if(isset($data->get->username))
			$user = $this->select('users', ['*'], ['username' => $data->get->username], 'User')->fetch();

		return View::make('profile.index', [
			'profile' => $user,
		]);
	}

	// Edit profile View
	public function edit(Request $data){
		if(!Account::isLoggedIn()) return $this->index();

		return View::make('profile.edit', [
			'profile' => $this->user,
		]);
	}

	// Edit profile api
	public function store(Request $data){
		if(!Account::isLoggedIn()) return ['toast' => 'You need to be logged in'];

		// using @ to get false instead of error Exeption, if false username or mail already exists
		$update = @$this->updateWhere('users', [
			'mail'     => $data->post->mail,
			'username' => $data->post->username,
		], ['id' => Account::get_id()]);

		if(!empty($data->post->password) && !empty($data->post->password_again) && !empty($data->post->password_old)){
			$msg = Account::changePassword($this->user, $data->post->password, $data->post->password_again, $data->post->password_old);
			if(!is_string($msg)) return ['toast' => 'Password updated And Profile Updated'];
			return ['toast' => $msg];
		}

		if($update) return ['toast' => 'Profile Updated'];
		if(!$update) return ['toast' => 'That username or mail already exists'];
		return ['toast' => 'Something happend, try again later'];
	}

	public function patch(Request $data){
		return Account::changePassword(parent::$site_wide_vars['user'], $data->post->old_pw, $data->post->new_pw, $data->post->new_pw2);
	}
}
