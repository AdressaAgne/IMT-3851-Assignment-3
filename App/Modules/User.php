<?php

namespace App\Modules;

use DB, Message;


class User extends DB {

    private $password;
    private $time;

    public function __construct($id = null){
        if(is_null($id)) return;

        $user = $db->select('users', ['*'], ['id' => $id])->fetch();
        foreach ($user as $key => $value) {
            $this->$key = $value;
        }
    }

    public function created(){
        return date('d/m/y', strtotime($this->time));
    }

    public function sendMessage($to, $message){
        $msg = new Message($this->id, $to, $message);
        return $msg->save();
    }

}