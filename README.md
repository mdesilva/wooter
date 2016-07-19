#Attention!
Please keep all clean and organized, thanks! :)

### Front end Dev Docs Readme 
#### [Link to front end dev docs](FRONT_END_README.md)
## Requirements
PHP > 5.5
MySQL 5.6
Redis
Node
Socket.io

PHP Modules required:

- Redis


### Set up
After cloning install [Composer](..https://getcomposer.org/doc/00-intro.md)
cd into the root wooter folder (example /var/www/wooter/) and run "composer install" without the quotes

After, you will need to create the database in your local machine and run the migrations.

## Environment
You should have a .env file in your / path, that will be use to have all the configuration variables for the whole application.
This .env file is specific for you, you do not need to commit it, that is why it is included in the .gitignore

Here you have further information about the idea of the .env file:
https://github.com/motdotla/dotenv

## Database
You should create a database in MySQL and set up the credentials inside your .env file, in order to be reachable by Laravel.

## Migrations
To get the database state as the rest of developers, you will need to run the migrations every time you make pull.

php artisan migrate

## Redis
Install Redis.

Create a password for it. Read about security on Redis.

Add the variable 'REDIS_PASSWORD' to your .env file in order to provide your Redis password.

### Setting up Socket.io


In order to set up the Socket system, we will need to install the following:

## Requirements on the Backend side:
- PHP + Laravel
- Node.js (Backend. Javascript server-side)
- Redis (Backend. Demon running in server)
- ioredis (Backend, As a required module for Node)
- Socket.io (Backend. As a require module for Node)
- predis/predis Laravel Package (Backend. Package for Laravel)

## Requirements on the Frontend side:
- Socket.io (Frontend, Javascript, library that we will import from the client)
- AngularJS


##How it will work:

From the client, we will send HTTP requests to the server. Those requests will be handled by Laravel in the backend.
The will do with the request what they need to do, and at some point, one or more events will be called.
Those events, will extends from the ShouldBroadcast interface. This means, that they will be broadcasted until the fetch the Frontend.
In order to this occur, PHP will publish and event in a channel in Redis. Redis will emit this event on the server. Redis will be also
listening for events from Node. In Node, we will have or more Redis channel opened, that will be listening to the events sent to Redis from PHP (Laravel).
Once those channels are created and the communication is working between Redis in PHP and Redis in Node, they are able to communicate each other.
This communication works via channels. Once we fetch an event in Redis in Node, there will be also Socket.io, who will receive those 
events from Redis in Node. Once a event is gotten from Socket.io in Node, we will emit it to the Frontend. This is the main point here, since
Socket.io will do the most important work, send the event from the backend to all the connections that are listening in the Frontend.
Socket.io will emit in a concrete connection as well as concrete channels. We can have multiple channels, and from one single event, we can 
emit to multiple channels also.
So everybody in the Frontend that is connected to Socket.io, that receive and event in the correct channel, will do the work the need to.

##How to set each all up.

#####1 Install NodeJS

You can download it from the website, from port, brew, apt-get, or your desired way. Once you have installed Node, make sure you can do:

$ npm -v
2.14.2

#####2 Install Redis

Again, you can download it from their website and set it up. Once you have it, you should be able to do:

$ redis-cli -v
redis-cli 3.0.3

#####3 Install the Socket.io moduel for Node

$ npm install --save socket.io

#####4 Install the ioredis module for Node

$ npm install --save ioredis

#####5 For the client, we need the Angular Library, what we have in

/public/js/vendors/angular/angular.js

#####6 Finally, we also need Socket.io in the client side:

/public/js/vendors/socketio/index.js

####7 Run php composer install to pull the predis/predis Library for Laravel

What we need?

We need a server written in node, we already have it in /socket.js

You can take a look at it, what it does, is create a http server, and required the ioredis and socket.io modules

We can modify this Node server in order to augment all the channels we need to provide.

From the backend in Laravel, we will need to create one event for everything we want to send to the frontend, this is done with:

php artisan make:event NameOfTheEvent

When we go to the event class, we need to make sure that this class extends the ShouldBroadcast interface, this will tell Laravel that
he should send this event to the Frontend

How is sent to the Frontend?

We need Redis for that. We need in the file /config/broadcasting.php, we should put:

'default' => env('BROADCAST_DRIVER', 'redis'),

Which means, in our .env file, we should have:

BROADCAST_DRIVER=redis




First thing you will need to download Node. You can download it from their site:
https://nodejs.org/en/

### Install gulp for elixir (compile sass, create scripts)
type in console npm install -g gulp, after type npm install (for windows users type npm install --no-bin-links)

### To start Elixir
Just type "gulp" for run task or "gulp watch" for tasks and watch (without quotes)

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
