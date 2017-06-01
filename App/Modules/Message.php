<?php

namespace App\Modules;

use DB;

class Message extends DB {

	public $id;
	public $from;
	public $to;
	public $message;

	private $time;

	public function __construct($from, $to, $msg){
		$this->from = $from;
		$this->to = $to;
		$this->message = $msg;
	}

	public function from(){
		return $this->select('users', ['*'], ['id' => $this->from], 'User')->fetch();
	}

	public function to(){
		return $this->select('users', ['*'], ['id' => $this->to], 'User')->fetch();
	}

	public function save(){
		$this->id = $this->insert('message', [
			[
				'from' => $this->from,
				'to'   => $this->to,
				'message' => $this->message,
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