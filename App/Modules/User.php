<?php

namespace App\Modules;

use DB, Message;


class User extends DB {

	public function __construct($id = null){
		if(is_null($id)) return;

		$user = $this->select('users', ['*'], ['id' => $id])->fetch();
		if($user){
			foreach ($user as $key => $value) {
				$this->$key = $value;
			}
		} else {
			$this->username = '';
		}
	}

	public function created(){
		return date('d/m/y', strtotime($this->time));
	}

	public function get_full_name(){
		if(empty($this->name)) return '[DELETED]';

		return ucwords("{$this->name} {$this->surname}");
	}

	public function getInbox(){
		$sql = 'SELECT m.message, u_from.username AS from_user, u_to.username AS to_user, m.time as time
		FROM messages AS m
		LEFT JOIN users AS u_from ON u_from.id = m.from_user
		LEFT JOIN users AS u_to ON u_to.id = m.to_user

		WHERE m.to_user = :id

		GROUP BY m.id';

		return $this->query($sql, ['id' => $this->id], 'Message')->fetchAll();
	}

	public function getOutbox(){
		$sql = 'SELECT m.message, u_from.username AS from_user, u_to.username AS to_user, m.time as time
		FROM messages AS m
		LEFT JOIN users AS u_from ON u_from.id = m.from_user
		LEFT JOIN users AS u_to ON u_to.id = m.to_user

		WHERE m.from_user = :id

		GROUP BY m.id';

		return $this->query($sql,['id' => $this->id], 'Message')->fetchAll();
	}

	public function getItems(){
		$itemController = new \App\Controllers\ItemController();
		$sql = $itemController->sql;
		return $this->query($sql.'  WHERE i.user_id = :id GROUP BY i.id ORDER BY i.time DESC', ['id' => $this->id], 'Item')->fetchAll();
	}

	public function isAdmin(){
		return $this->admin == 1;
	}

	public function sendMessage($to, $message){
		$msg = new Message();
		return $msg->save($to, $this->id, $message);
	}

}