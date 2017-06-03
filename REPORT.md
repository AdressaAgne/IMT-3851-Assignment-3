# Assignment-3
## Programming for the Web II (IMT3851)

* Group members:
	* Agne Ødegaard (140699)
	* Audun Olsen (140689)
	* Minh Nguyen (471296)

## Instalation
*prerequisites: PHP 7.1*
Set the public folder as your document root. if you choose to not do this, go public/.htaccess and edit your path there.
To access the MySQL database, go to App/Container/Config.php and edit your database settings. You do not need to make the database in PhpMyAdmin, the framework should handle that by its own. To populate the database with some dummydata, go to localhost/migrate. The browser will output Json showing the executed SQL, confirming the step worked. You can now go to e.g. localhost/ and be greeted with the index page.

You can also to go https://oblig3.agne.no to see the website.

## Roles & the collaborative process

In our team, we have Agne Ødegaard, Audun Olsen and Minh Nguyen. Each member had different strength and weaknesses in the group we therefore decided to assign different roles to each group member. The different roles accommodated the different skill sets of each member.

Agne was assigned as our team leader, due to reason that he is very skilled with php. His focus was to build the backend on a framework which he had previously made himself (https://github.com/OrangeeWeb/Teapug). This framework works as any other MVC framework. The framework was also expanded on during this project Additionally, Agne supervised all aspects of the website during the development process. Audun is the group's second in command, he got to go hands on with both javascript and php. Minh worked with the frontend, and had her hands on sass and pug, she and Agne also together collaborated on how forms and php interacted together.

### THE MEETINGS
In addition to work done individually, all group members took part in four extended work sessions, before completing the project. During our first meeting, we divided our group into different roles and assigned different tasks to each member. We further discussed how we were supposed to implement Agne's framework. All later meetings consisted of coding while using git as a collaborative tool.

## THE TOOLS
In order for us to complete this project with efficiency, everyone agreed on collaborating on GIT. Meaning each member could work remotely, and easily change the code without any fuss and just push and pull new changes on demand. We also used Codekit3, a tool letting us use popular "preprocessor" languages like sass for ease of frontend development. additionally, Agne's framework uses Tale jade as a plugin, which is a templating engine which replaces HTML, the fundamental difference between pug and html is the indent-oriented syntax. In .pug, you don't close tags, children of elements are rather determined by indentation. The code gets converted to HTML server-side, in addition to being minified, meaning the code is optimized for the end user. 

## THE DESIGN AND IMPLEMENTATION CHOICES
The planning phase of this project was a collaborative effort among all group members. Deciding how we would semantically partition the database data into different tables was a key starting point. We have 5 tables, users, messages, item, categories, and item_category.

 * Users contains all the information about a user. A user has username and mail as unique keys
 * Messages are the messages sent by a user to an other user, it would be silly to set from_user and to_user as uniques, because that means a user can only send a message once.
 * items are the items a user can post and give away.
 * categories as all the categories an item can be in.
 * item_category is a connection table between categories and items, since we have a Many to Many relationship, we need an other table to connect them. item_category has item_id and category_id and unique together, so an item can not have the same category twice.

## security

We have prevented sql-injection, 2nd sql-injection, XSS-injection and we have CSRF token we use to handle ajax requests so our page is the only page that can get the info from the ajax request. If you dont have the csrf token or its wrong the framework will send back a 418 code. (418, I'm a Teapot easteregg from google in 1998.)