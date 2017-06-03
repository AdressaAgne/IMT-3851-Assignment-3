<?php
namespace App\Controllers;

use Controller, Request, View, Account, Direct;

class MessageController extends Controller {

	/**
	 * index / recived messages
	 * @method index
	 * @author [Agne Ødegaard]
	 * @return View
	 */
	public function index(){
		if(!Account::isLoggedIn()) return Direct::re('/');

		return View::make('message.inbox', [
			'inbox' => $this->user->getInbox(),
		]);
	}

	/**
	 * AJAX: Inbox / recived messages
	 * @method inbox
	 * @author [Agne Ødegaard]
	 * @param  Request $data [description]
	 * @return JSON
	 */
	public function inbox(Request $data){
		if(!Account::isLoggedIn()) return Direct::re('/');

		return $this->user->getInbox();
	}

	/**
	 * AJAX: Outbox / sent messages
	 * @method outbox
	 * @author [Agne Ødegaard]
	 * @param  Request $data [description]
	 * @return JSON
	 */
	public function outbox(Request $data){
		if(!Account::isLoggedIn()) return Direct::re('/');

		return $this->user->getOutbox();
	}

	/**
	 * Create new message view
	 * @method new
	 * @author [Agne Ødegaard]
	 * @param  Request $data [description]
	 * @return View
	 */
	public function new(Request $data){
		if(!Account::isLoggedIn()) return Direct::re('/');

		return View::make('message.create', [
			'users' => $this->select('users', ['*'], null, 'User')->fetchAll(),
		]);
	}

	/**
	 * Ajax: Send the message
	 * @method store
	 * @author [Agne Ødegaard]
	 * @param  Request $data [description]
	 * @return JSON
	 */
	public function store(Request $data){
		if(!Account::isLoggedIn()) return Direct::re('/');

		if(empty($data->post->to_user)) return ['toast' => 'Fill inn a user'];
		if(empty($data->post->msg)) return ['toast' => 'Please write a message'];
		if(Account::isLoggedIn()) {
			$msg = $this->user->sendMessage($data->post->to_user, $data->post->msg);
			return $msg;
		}
	}
}
