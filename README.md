## Instalation

Set the public folder as your document root. if you choose to not do this, go public/.htaccess and edit your path there.
To access the MySQL database, go to App/Container/Config.php and edit your database settings. You do not need to make the database in PhpMyAdmin, the framework should handle that by its own.

You can also to go https://oblig3.agne.no to see the website.

# Programming for the Web II (IMT3851)

In our team, we have Agne Ødegaard, Audun Olsen and Minh Nguyen.
Each member had different strength and weaknesses in the group, therefore we decided to divide the group into different roles that were suitable for each member.

Agne was assigned as our team leader, due to reason that
he is very skilled with php. His focus was to build the backend on a homemade framework (https://github.com/OrangeeWeb/Teapug). This framework works as any other MVC framework.

Audun is our second in command, he wanted to get hands on with both javascript and php.
Minh worked with the frontend, and had her hands on sass and pug.

## THE MEETINGS
Our group managed to session three meetings, before completing the project.
During our first meeting, we divided our group into different roles and task, and discussed about how we were supposed to put up the backend and implement our own framework.
In our second and third meetings, we had long sessions. Meaning, we would execute the work together as a team. While using git as a collaborative tool.

## THE TOOLS
In order for us to complete this project with efficiency, everyone agreed on collaborating on GIT. Meaning each member could work remotely, and easily change the code without any fuss and just push up the new changes whenever we wanted. For our communication we used Messenger.

## THE DESIGN AND IMPLEMENTATION CHOICES
The planning phase of this project was a collaborative effort among all group members. Deciding how we would semantically partition the database data into different tables was a key starting point. We have 5 tables, users, messages, item, categories, and item_category.

 * Users contains all the information about a user. A user has username and mail as unique keys
 * Messages are the messages sent by a user to an other user, it would be silly to set from_user and to_user as uniques, because that means a user can only send a message once.
 * items are the items a user can post and give away.
 * categories as all the categories an item can be in.
 * item_category is a connection table between categories and items, since we have a Many to Many relationship, we need an other table to connect them. item_category has item_id and category_id and unique together, so an item can not have the same category twice.

## security

We have prevented sql-injection, 2nd sql-injection, XSS-injection and we have CSRF token we use to handle ajax requests so our page is the only page that can get the info from the ajax request. If you dont have the csrf token or its wrong the framework will send back a 418 code. (418, I'm a Teapot easteregg from google in 1998.)


# Bugs

## Priority levels
1. Blocker ☠️
1. Critical 😵
1. Major 😭
1. Minor 😰
1. Trivial 😤

* [x] 😵 **Register duplicate**
	* Layout duplicates when register is accessed from navigation.
* [x] 😭 **Toast greets failed login**
	* Toast greets with username input from login form even when login fails.
* [x] 😤 **Navigation dropdown shenanigans**
	* Login and categories dropdown menus do not cancel out each other correctly.
* [x] 😭 **Mobile nav drawer fixed hopping**
	* Content behind expanded mobile drawer perform large hops when scrolling.
* [x] 😭 **Can't cancel mobile login modal**
	* Unable to cancel login modal on small viewport widths.