<?php

namespace App\Modules;

use DB, Message;


class User extends DB {

	private $password;
	private $time;

	public function __construct($id = null){
		if(is_null($id)) return;

		$user = $this->select('users', ['*'], ['id' => $id])->fetch();
		foreach ($user as $key => $value) {
			$this->$key = $value;
		}
	}

	public function created(){
		return date('d/m/y', strtotime($this->time));
	}

	public function get_full_name(){
		if(empty($this->name)) return 'Anonymous';

		return ucwords("{$this->name} {$this->surname}");
	}

	public function getInbox(){
		return $this->select('messages', ['*'], ['to_user' => $this->id], 'Message')->fetchAll();
	}

	public function getOutbox(){
		return $this->select('messages', ['*'], ['from_user' => $this->id], 'Message')->fetchAll();
	}

	public function sendMessage($to, $message){
		$msg = new Message($this->id, $to, $message);
		return $msg->save();
	}

}