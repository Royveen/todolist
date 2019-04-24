

## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

### Prerequisites

Install the Vue CLI.
https://cli.vuejs.org/guide/installation.html

Laravel Requirements. https://laravel.com/docs/5.8#installing-laravel

### Installing

Clone this repository

```
git clone https://github.com/Royveen/todolist.git.git vue-todo
```

Create a MySQL database

```
mysql> CREATE DATABASE laraapp;
```

Go to the project directory
```
cd vue-todo
```

Run composer install
```
composer install
```

Rename .env.example to .env
```
mv .env.example .env
```

Replace these values in .env
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=laraapp
DB_USERNAME=*************
DB_PASSWORD=*************
```

Generate an application key
```
php artisan key:generate
```

Run migrations
```
php artisan migrate
```

Go to the Vue CLI project


Run npm install
```
npm install
```

Run the server
```
I used XAMPP Server to run this project. I prefer you all to use that one. Its amazing and easy to configure.
```

use "npm run watch" to continous build with live changes

That's it!

## Built With

* [Laravel](https://laravel.com/) - PHP framework
* [Vue.js](https://vuejs.org/) - Javascript framework
* View package.json and composer.json for a complete list of packages used.

## Authors

Ramanpreet Singh (https://github.com/Royveen/todolist)

## License

This project is licensed under the MIT License

## Acknowledgments

* [Laravel real-world app](https://github.com/gothinkster/laravel-realworld-example-app)
* [Vue real-world app](https://github.com/gothinkster/vue-realworld-example-app)
