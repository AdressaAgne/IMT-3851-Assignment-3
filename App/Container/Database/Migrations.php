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
			new Integer('user_id'),
			new Varchar('description'),
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
			new Timestamp(),
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


		$db->insert('categories', [
			[
				'name' => 'Sport',
			],
			[
				'name' => 'Hage',
			],
			[
				'name' => 'Stue',
			],
			[
				'name' => 'Kjøkken',
			],
			[
				'name' => 'Barn',
			],
			[
				'name' => 'Natur',
			],
		]);

		$db->insert('items', [
			[
				'title' => 'Sykkel gis bort',
				'user_id' => 1,
				'description' => 'Jeg vil gjerne gi bort min shitty sykkel...',
			]
		]);

		$db->insert('item_category', [
			[
				'item_id' => 1,
				'category_id' => 1,
			],
			[
				'item_id' => 1,
				'category_id' => 6,
			],
		]);

	}
}
