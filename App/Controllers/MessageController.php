<?php
namespace App\Controllers;

use Controller, Request, View, Account;

class MessageController extends Controller {

	// index / recived messages
	public function index(){
		if(Account::isLoggedIn())
			return View::make('message.inbox', [
				'inbox' => $this->user->getInbox(),
			]);
	}

	// Inbox / recived messages
	public function inbox(Request $data){
		if(Account::isLoggedIn())
			return $this->user->getInbox();
	}

	// Outbox / sent messages
	public function outbox(Request $data){
		if(Account::isLoggedIn())
			return $this->user->getOutbox();
	}

	// GET: new message ui
	public function new(Request $data){
		if(Account::isLoggedIn())
			return View::make('message.create', [
				'users' => $this->select('users', ['*'], null, 'User')->fetchAll(),
			]);
	}

	// Post: send new msg
	public function store(Request $data){
		if(Account::isLoggedIn()) {
			$this->user->sendMessage($data->post->to_user, $data->post->msg);
			return $this->index();
		}
	}
}
