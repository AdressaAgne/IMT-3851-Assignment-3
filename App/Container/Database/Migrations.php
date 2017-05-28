<?php

namespace App\Container\Database;

use DB, Account, Config, Direct;

class Migrations{

	public static function install(){
		//$name, $type, $default = null, $not_null = true, $auto_increment = false)
		$db = new DB();

		$db->clearOut(); // delete database

		// (item, item_cats, cats, users, messages)
		$db->createTable('users', [
			new PID(),
			new Timestamp(),
			new Varchar('name'),
			new Varchar('surname'),
			new Row('username', 'varchar', null, true, false, 'UNIQUE'),
			new Varchar('mail'),
			new Varchar('password'),
		]);

		$db->createTable('items', [
			new PID(),
			new Timestamp(),
			new Varchar('title'),
			new Integer('from'),
			new Integer('to'),
		]);

		$db->createTable('item_category', [
			new PID(),
			new Integer('item_id'),
			new Integer('category_id'),
		]);

		$db->createTable('categories', [
			new PID(),
			new Varchar('name'),
		]);

		$db->createTable('messages', [
			new PID(),
			new Integer('from'),
			new Integer('to'),
			new Row('message', 'text'),
		]);


		self::populate();


		return [$db->tableStatus];
	}

	public static function populate(){
		$db = new DB();

		$adminId = Account::register('admin', 'admin', 'admin', 'admin@admin.admin');

	}
}
