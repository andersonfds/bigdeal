# About BigDeal
The BigDeal project is a simple web system based, which allows users to interact each other and create advertisements to sell/buy or do whatever they want with their old stuff. The goal of this project is to show the source code. You definitely can **not** clone it into a working server for commercial purposes for two main reasons:
1. **It is not safe:** there could be security issues that could be exploited by hackers, since it's a work in progress.
2. **License:** I won't allow you to use this code for commercial purposes.

## How It Works?
This is a route-based system where the main file is the [routes.php](https://github.com/andersonfds/bigdeal/blob/master/routes.php) which basically finds the Controller's method and call it. For instance when the user calls the `/` route, it will find the class `AnuncioController` at the method `index()`, and call it only if it's authenticated with the required level, in this specific case the level required is 0, so anyone should be able to reach the `/` route.

# Installation
This section covers the whole installation process of the system. If you already have, you might wanna go to to the [configuration](#configuration) section.

## Server requirements
The system is a simple project that was made requiring as minimum "technologies" as possible, so there is only a few things that you should have installed:
* PHP >= 7.3.4 (Could work in 7.1.3)
* PHP PDO Extension
* MySQL/MariaDB database with InnoDB support
* mod_rewrite allowed on Apache settings

## Cloning the repository
First make sure that you are inside your server folder, for example purposes I'm gonna assume that your server folder is `srv/http`, but you should replace properly all the settings with your actual setup. Alternatively you could download and unzip the folder into the server folder. Let us clone it:

    git clone https://github.com/andersonfds/bigdeal.git

## Setup the apache Virtual Host
This system doesn't allow to be configured in sub folders of a domain, which means that if you have a domain `example.com` it should be exclusively used to host this project. When [Creating the VHost](https://ultimatefosters.com/hosting/setup-a-virtual-host-in-windows-with-xampp-server/) you should point it to a folder inside the root project folder, called `public`:

    <VirtualHost *:80>
        ServerName bigdeal.com
        DocumentRoot "/srv/http/bigdeal/public"
        [...]
    </VirtualHost>

## Creating the Database
You should create manually the database which should use the charset UTF-8 and the `UTF8_GENERAL_CI` collate:

    CREATE DATABASE $DB_NAME DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

## Creating the tables
Inside the main project folder you should find a file called [database.sql](https://github.com/andersonfds/bigdeal/blob/master/database.sql) (assuming that you have `mysql` in your PATH) you should open a terminal there and type:

    mysql -u $DB_USER -p $DB_NAME < database.sql

# Configuration
Pretty much done! You should only follow a few more steps in order to get the project to work. First, still inside the root directory you should open the file [config.example.php](https://github.com/andersonfds/bigdeal/blob/master/config.example.php) and edit the values accordingly to the comments. After that you should rename the file to `config.php`. Now you can open the browser and test if it's working.

## Administrator
The **first user** by default will get administrator privileges level 9. Administrators have different levels from 0 to 9, in which "0" means a "guest" login, and "9" is the highest level, which can create categories, manage users, etc.
