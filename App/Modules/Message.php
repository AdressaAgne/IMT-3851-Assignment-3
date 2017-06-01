<?php

namespace App\Modules;

use DB;

class Message extends DB {

	public $id;
	public $from_user;
	public $to_user;
	public $message;

	public $time;

	public function __construct(){
		$this->time = $this->created();
	}

	public function from(){
		return $this->select('users', ['*'], ['id' => $this->from_user], 'User')->fetch();
	}

	public function to(){
		return $this->select('users', ['*'], ['id' => $this->to_user], 'User')->fetch();
	}

	public function save($to, $from, $msg){
		if(is_string($to)){
			$to = $this->select('users', ['id'], ['username' => $to])->fetch()['id'];
			if(is_null($to)) return false;
		}
		$this->id = $this->insert('messages', [
			[
				'from_user' => $from,
				'to_user'   => $to,
				'message' => $msg,
			],
		]);

		$this->time = time();
		return $this;
	}

	public function created(){
		return date('d/m/y', strtotime($this->time));
	}

	public function delete(){
		$this->deleteWhere('message', 'id', $this->id);
		return $this;
	}

}