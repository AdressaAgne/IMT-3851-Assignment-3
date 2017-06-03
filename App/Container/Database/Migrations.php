<?php

namespace App\Container\Database;

use DB, Account, Config, Direct;

class Migrations{

	public static function install(){
		//$name, $type, $default = null, $not_null = true, $auto_increment = false)
		Account::logout();
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
		])->unique('username')->unique('mail');

		$db->createTable('items', [
			new PID(),
			new Timestamp(),
			new Varchar('title'),
			new Integer('user_id'),
			new Row('description', 'text'),
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
				'mail' => 'agne@agne.agne',
				'password' => $pw,
				'admin' => 0,
			],
			[
				'name' => 'Audun',
				'surname' => 'Meek Olsen',
				'username' => 'amo',
				'mail' => 'audun@audun.audun',
				'password' => $pw,
				'admin' => 0,
			],
			[
				'name' => 'Minh',
				'surname' => 'n',
				'username' => 'minh',
				'main' => 'minh@minh.minh',
				'password' => $pw,
				'admin' => 0,
			],
			[
				'name' => 'admin',
				'surname' => 'adminsen',
				'username' => 'admin',
				'main' => 'admin@admin.admin',
				'password' => bcrypt('admin'),
				'admin' => 1,
			],
		]);

		$db->insert('categories', [
			[
				'name' => 'Sports',
			],
			[
				'name' => 'Clothing',
			],
			[
				'name' => 'Outdoors',
			],
			[
				'name' => 'Livingroom',
			],
			[
				'name' => 'Kitchen',
			],
			[
				'name' => 'Toys',
			],
			[
				'name' => 'Nature',
			],
			[
				'name' => 'Electronics',
			],
		]);

		$db->insert('items', [
			[
				'gone' => 1,
				'title' => 'My broken heart for giveaway',
				'user_id' => 3,
				'description' => 'My exgirlfriend cheated on me for 6 months, and I finally found out by finding her lover in our bed naked. But my crazy girlfriend tried to deny it, and just ignored the white elephant in the room.
I was feed up with her attitude, and broke up with her. But she didn’t want to go away, I had to go to court to get a restraining order on her. But she didn’t want to keep her hands of me, to make a long  story short…After 6 months of in a on and off relationship, I am finally free from this crazy girl
But my heart and spirit is completely broken. Therefore I will donate my heart, to anyone who wants to tend for it.',
			],
			[
				'gone' => 0,
				'title' => 'Children clothes in great condition. ',
				'user_id' => 2,
				'description' => 'Hey there, we have a daughter around 4 years old, and she has grown out of her clothes.
We have a lot of cute dresses, t shirts and pants that we would like to give away to the next family.
The clothes are in good condition, I also want to mention that we do have some kids shoes to give away in the brand Nike, Air Jordan and Adidas our little girl has already outgrown them as well.
The shoes are almost brand new, and has only been used a few times during children parties.',
			],
			[
				'gone' => 0,
				'title' => 'Garden furniture, giveaway asap.',
				'user_id' => 1,
				'description' => 'We have sofa, and a party tent we would like to give away as soon as possible.
Due to the reason, that my dad just won the lottery and he wants to be a millionaire by moving to LA and start his career at silicon valley and become best friends with Mike Zuckerberg.
Therefore we have to giveaway most of our furnitures and move away from Dalas within next week.

The outdoor sofa and party tent is in good condition.
We can’t deliver it for you, but if you pick it up by we will help you to reassemble it.
The tent is quite heavy, its around 20 kg. The sofa is around 45 kg as well, included with pillows.
',
			],
			[
				'gone' => 0,
				'title' => 'Giving away 1/2 Kayak',
				'user_id' => 3,
				'description' => 'Giving away my whole kayak. The reason I’m writing 1/2 is because, it has some holes at the bottom of the kayak. It is fully functional, but might leak in water. It needs a little love and maintenance, if there is someone out who is a professional kayak repairer this would be a great project for you.
This kayak is in great condition except the holes as mention. But this model is a Kayak level 5000BMW, meaning its one of a kind. This baby has a smooth ocean glide, and is very easy to navigate but this level of a kayak is more for professionals.',
			],
			[
				'gone' => 0,
				'title' => 'MINH ROBOT 2.0',
				'user_id' => 2,
				'description' => 'Giving away a homemade robot under the name Minh 2.0.
The robot is made out of scraps, found at home. Right now, the robot cannot do much.
It can halfway sweep dust, but it might lose an arm during the cleaning session. Because it is easily detachable, and to heavy for the robots body. If there is a genius out there who wants to work on the robot and further improve the Minh 2.0 to maybe a 2.6 version I would gladly give it away.

Another feature the Minh 2.0 can do, is to stand still for decades and not move or blink.
Minh 2.0 is a little bit heavy, it weights around 150kg. It has wheels so its easily to bring home, by foot or car. You just need to push it.',
			],
			[
				'gone' => 0,
				'title' => 'Giving away an antique stove',
				'user_id' => 1,
				'description' => 'This stove has been through my family generation for ages.
It seems like it dates back to 1800. Unfortunately, it has been dusting away in the last decade, due to lack of space. Therefore we would like to give it away, to someone who wants this as a collective item or maybe put it in a museum. We welcome antique collectors to take a look!',
			],
			[
				'gone' => 0,
				'title' => 'Outdoor clothes needs a new home',
				'user_id' => 2,
				'description' => 'Im giving some of my sons outdoor clothes.
My teenage boy is growing up fast, and we have a lot sport clothes we want to give away.
We have a set of snowboard pants, and jacket from the brand Nordstrom, the clothes are in great condition, only used three times during easter. Size M.
We have 2 pair of waterproof fishing pants in size XL also from Nordstrom,
the pants are little bit long. Therefore we recommend it for someone of the height 180cm or taller.
Also giving away one snowboard helmet at the 15, male. Has blue stripes on the side, looks really cool. In good condition, never fell with them.',
			],
			[
				'gone' => 0,
				'title' => 'Letting go of Lego',
				'user_id' => 3,
				'description' => 'Our children has now moved on to college, and we have a whole lego collection we want to give away to a family who has children and are in need of toys.
We have also a brio train collection suitable for children in the age of 2-5.

Some of the collection we have is :
The Death Star Lego set
Lego Classic
Lego movie collection
Lego city
Lego Batman

These pieces are in great condition, and we hope you will find joy in these toys.',
			],
			[
				'gone' => 0,
				'title' => 'BIG SMART TV GIVE AWAY',
				'user_id' => 1,
				'description' => 'Giving away my husbands big Samsung smart TV.
I dont know which model it is, but we got it 6 months ago, and it costed us almost a leg and an arm.
After we got the new TV into our house, it has been a war zone everyday.
My husband stopped caring for me or my children, all he does is just sit in front of of the DAMN TV all day,’errday!

He has totally ignored all family duties, and just loves to sip beer in front of the TV and talk to that damn smart TV.

I’m giving this TV away this week, while my husband is on his business trip.
I recommend this TV for single ladies or men, this is not a family oriented TV.
It will suck away your husbands soul, so be warned. Who ever wants this demon, please PM as soon as possible within this week.
 Have a lovely day.',
			],
			[
				'gone' => 0,
				'title' => 'I never became a wizard',
				'user_id' => 3,
				'description' => 'To my fellow nerds, I once read on the Internet that if you stay a virgin until you’re 30, you become a wizard. I waited and waited, and now I’m 40 years old and virgin, but I still have no magic powers.
I can’t talk animals, nor can I summon elves. I haven’t been able to contact Mordor or sent a white magic cast signal to Frodo on the other side of the valley.

After doing a crazy research on the Internet, it seems like I have to think pure and be pure to become a wizard. Therefore, I will now giveaway my dirty hentai collection, pillow and games.
I want my hentai to be given away to people who appreciate and has a love and understanding of my love for hentai.

My list of give aways :
I have the Hatsune Miko exclusive pillow collection.
In good condition, has some stains here and there. Just wash it of with omo.

I have my Best of hentai dvd collection from amazone, where I waited 5 hours in line outside of Outland on the day of release.

I also have a lot of hentai manga :
- Hatsune Miku sings hentai
- Hatsune Miku dance hentai
- Hatsune Miku walks hentai
- Hatsune Miku showers hentai
- Hatsune Miku eats hentai
- Hatsune Miku exclusive Level 9000.

Only serious PM!
This is not to be taken lightly of.
This is my sacred collection and I want to give away to the right person.',
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
			[
				'item_id' => 4,
				'category_id' => 4,
			],
			[
				'item_id' => 5,
				'category_id' => 2,
			],
			[
				'item_id' => 6,
				'category_id' => 4,
			],
			[
				'item_id' => 7,
				'category_id' => 10,
			],
			[
				'item_id' => 7,
				'category_id' => 8,
			],
			[
				'item_id' => 8,
				'category_id' => 3,
			],
			[
				'item_id' => 9,
				'category_id' => 1,
			],
			[
				'item_id' => 10,
				'category_id' => 1,
			],
			[
				'item_id' => 10,
				'category_id' => 2,
			],
			[
				'item_id' => 10,
				'category_id' => 3,
			],
			[
				'item_id' => 10,
				'category_id' => 4,
			],
		]);

	}
}
