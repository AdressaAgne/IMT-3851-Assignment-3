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
			new Varchar('username'),
			new Varchar('mail'),
			new Varchar('password'),
			new Boolean('admin', 0),
		])->unique('username', 'mail');

		$db->createTable('items', [
			new PID(),
			new Timestamp(),
			new Varchar('title'),
			new Integer('user_id'),
			new Varchar('description'),
			new Boolean('gone'),
		]);

		$db->createTable('item_category', [
			new PID(),
			new Integer('item_id'),
			new Integer('category_id'),
		])->unique('item_id', 'category_id');

		$db->createTable('categories', [
			new PID(),
			new Varchar('name'),
		])->unique('name');

		$db->createTable('messages', [
			new PID(),
			new Timestamp(),
			new Integer('from_user'),
			new Integer('to_user'),
			new Row('message', 'text'),
		]);


		self::populate();


		return [$db::$tableStatus];
	}

	public static function populate(){
		$db = new DB();
		$pw = bcrypt('123');

		$db->insert('users', [
			[
				'name' => 'Agne',
				'surname' => 'Ødegaard',
				'username' => 'agneo',
				'password' => $pw,
			],
			[
				'name' => 'Audun',
				'surname' => 'Meek Olsen',
				'username' => 'amo',
				'password' => $pw,
			],
			[
				'name' => 'Minh',
				'surname' => 'n',
				'username' => 'minh',
				'password' => $pw,
			],
		]);

		$db->insert('categories', [
			[
				'name' => 'Sport',
			],
			[
				'name' => 'Hentai',
			],
			[
				'name' => 'Octopuslove',
			],
			[
				'name' => 'Clothing',
			],
			[
				'name' => 'Minh',
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
			],
			[
				'title' => 'Rotten fisk',
				'user_id' => 2,
				'description' => 'vil ikke ha den lenger, katta spiste den aldri, kanskje din katt liker den?',
			],
			[
				'title' => 'Matpakke fra i fjor',
				'user_id' => 1,
				'description' => 'Fant en matpakke fra i fjor under senga, hvis noen vil ha den er det helt greit. jeg trenger den ikke lenger.',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
			[
				'title' => 'Hamster gis bort',
				'user_id' => 3,
				'description' => 'Vi har fått katt og da må hamstern bort. han har mistet ett øre pga katten allerede så fort dere! HENT HAN!',
			],
		]);

		$db->insert('item_category', [
			[
				'item_id' => 1,
				'category_id' => 1,
			],
			[
				'item_id' => 1,
				'category_id' => 5,
			],
			[
				'item_id' => 2,
				'category_id' => 5,
			],
			[
				'item_id' => 2,
				'category_id' => 2,
			],
			[
				'item_id' => 3,
				'category_id' => 3,
			],
			[
				'item_id' => 3,
				'category_id' => 4,
			],
			[
				'item_id' => 3,
				'category_id' => 8,
			],
			[
				'item_id' => 4,
				'category_id' => 10,
			],
		]);

	}
}
