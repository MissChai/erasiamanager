# ErasiaManager Project
A simple project to allow users to manage their different characters of [Érasia-RPG](http://erasia-rpg.forum-actif.net/forum) online.
Developed and maintained by MissChai (Kaé).

## What's it made of?
This website is composed of two completely seperate projects:

* `server`: in this folder is the backend of the project. It's an RESTful API developed using [Silex](https://silex.sensiolabs.org/).

* `client`: in this folder is the frontend of the project. It's developed using [Angular2](https://angular.io/).

## What do I need to run it?
You will need at least:

* PHP 7.1 or higher

* [Composer](https://getcomposer.org/doc/00-intro.md)

* [Node.js and npm](https://nodejs.org/en/download/)

* Typescript (`npm install -g typescript` once npm is installed)

* Angular CLI (`npm install -g @angular/cli` once npm is installed)

You can also use these libraries to help you install and run the project:

* SQLite extension

Then, of course, you must download or clone the latest release of the project.

## Backend
### Install
In the `server` folder, run the following commands to install the PHP dependencies.

	composer install

If you have SQLite, you can import some data by running these commands, always in the `server` folder. If you don't, you can execute them directly in your database administrator (such as phpMyAdmin).

	sqlite3 app.db < app/db/database.sql
	sqlite3 app.db < app/db/structure.sql
	sqlite3 app.db < app/db/content.sql

### Run local PHP server
To run a local php server, you just have to run this command in the root folder.

	php -S 0:9001 -t server/web/

The API is now available at http://localhost:9001/v1.

### MAMP
You can also use an application to localy run a Apache and MySQL server, like MAMP on MacOS.

To do that your sources must be copied or linked into `/Applications/MAMP/htdocs/`, and make sure MAMP is using 80 and 3306 ports.
You must then modify `/Applications/MAMP/conf/apache/extras/httpd-vhosts.conf` by adding these lines at the end of the file:

	#
	# Localhost
	#
	<VirtualHost *:80>
    	DocumentRoot "/Applications/MAMP/htdocs"
    	ServerName localhost
   		<Directory /Applications/MAMP/htdocs >
       		AllowOverride All
       		Allow from All
   		</Directory>
	</VirtualHost>

	#
	# Erasia Manager API
	#
	<VirtualHost *:80>
	    DocumentRoot "/Users/clemy/Sites/ErasiaManager/server/web"
	    ServerName dev.api.erasiamanager
	   <Directory /Users/clemy/Sites/ErasiaManager/server/web >
	       AllowOverride All
	       Allow from All
	   </Directory>
	</VirtualHost>

You need to check that in `Applications/MAMP/conf/apache/httpd.conf` the line that enables to include `httpd-vhosts.conf` is not commented.

	# Virtual hosts
	Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf

In order to take these changes into account, you must restart your Apache server.

To finish, you need to edit `/private/etc/host` to add your host.

	# virtual hosts
	127.0.0.1      dev.api.erasiamanager

The API is now available at http://dev.api.erasiamanager.

### Request
You can use `curl` to create different request to the API.

	#GET (collection)
	curl http://dev.api.erasiamanager/v1.0/characters -H 'Content-Type: application/json' -w "\n"

	#GET (single item with id 1)
	curl http://dev.api.erasiamanager/v1.0/characters/1 -H 'Content-Type: application/json' -w "\n"

	#POST (insert)
	curl -X POST http://dev.api.erasiamanager/v1.0/characters -d '{ "name":"Ayme" }' -H 'Content-Type: application/json' -w "\n"

	#PUT (update)
	curl -X PUT http://dev.api.erasiamanager/v1.0/characters/1 -d '{ "name":"Ayme" }' -H 'Content-Type: application/json' -w "\n"

	#DELETE
	curl -X DELETE http://dev.api.erasiamanager/v1.0/characters/1 -H 'Content-Type: application/json' -w "\n"

You can also use modules on your favorite browser to send elaborate HTTP requests such as *HTTPRequester* on Firefox.

Here is the global scheme of the response you can get from the API.

	#SUCCESS
	{
		'apiVersion': '1.0',
		'data': [
			{
				'id': 1,
				'name': 'Kaé'
			},
		],
	}

	#FAILURE
	{
		'apiVersion': '1.0',
		'errors': [
			{
				'code': 404,
				'domain': 'CharacterRepository',
				'type': 'InvalidArgumentException',
				'message': 'Character not found: the identifier "7" does not match any known character.'
			}
		],
	}

## Frontend
To run Angular2, you just have to run this command in the `client` folder.

	ng serve

The app is now available at http://localhost:4200.

## Logs
Logs can be found in the following files.

* Silex: `erasiamanager/server/storage/logs/`

If you are using MAMP.

* Apache: `Applications/MAMP/logs/apache_error.log`

* PHP: `Applications/MAMP/logs/php_error.log`

## Author
Clémence Faure

## License
See Licence