
## Laravel Restful API Project with Docker &  Sanctum


@ **What is a REST API?**

**Overview**

A REST API (also known as RESTful API) is an application programming interface (API or web API) that conforms to the constraints of REST architectural style and allows for interaction with RESTful web services. REST stands for representational state transfer and was created by computer scientist Roy Fielding.

## Why you use this project
 This project create for saving development. anyone can use develop Restfull API using this repo
 
 1. **Docker container V-3.3**
 2. **Laravel V-8**
 3. **PHP V-8**
 4. **MySql v- 8.0.29**
 5. **PhpMyAdmin** 
 6. **Redis** for caching 

## Download Docker

Please check your pc docker setup has or not. if you forgot to give setup docker then you should setup docker based on your operating system.
Docker official site [download](https://www.docker.com/).


## Docker config

First of all, you need to clone this project then go to local fonder to run

After enter your folder you may run some command to run laravel project.

1. open your terminal and run below command 

```
docker-compose build

docker-compose up -d

```
2. if you want to go  docker bash then below command will be help you 

```$xslt

docker-compose php bash

```
you can run here all artisan command:

ex: php artisan migrate, php artisan migrate:status


##
## Design pattern

- **Repository design pattern**




##
## Restful API Authentication
Authentication system has been develop implement **Laravel Sanctum**

you will find documentation as wall in the [laravel](https://laravel.com/docs/8.x/sanctum#main-content) official site

- **Repository design pattern**

- **Database creating**

This will create a database called laravel_repository. Next we have to add the database credentials to the .env file.

```

DB_DATABASE=your database name
DB_USERNAME=root
DB_PASSWORD=secret

```

After you have changed the .env file we have to clear the configuration cache

```$xslt
php artisan config:clear
```
If you want to clear all cache then you should try below command 

```$xslt
php artisan optimize:clear

```
**Run the migration**

Now that we have setup the database we can run the migration:
```

php artisan migrate

```
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.


## License

The Laravel framework is open-sourced software licensed under the 

## Develop By Md Ahsan Habib
**Email: habib.cst@gmail.com** 
