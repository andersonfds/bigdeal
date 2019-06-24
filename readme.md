# BigDeal (v.1.0.0) - CRUD E-Bay

### System Requirements
| Software | Tested version |
| ------------ | ------------ |
| PHP | \>= 7.3.4 |
| Database | \>= 10.1.38-MariaDB (Or equivalent MySQL version) |
| Apache | \>= 2.4.39 |

| Technologies | Required |
| ------------ | ------------ |
| PHP PDO | TRUE |
| Mod Rewrite | TRUE |

> If you are using Xampp, you shouldn't worry about the requirements above, because they are there by default.

### Setup Apache Virtual Host
In order to get the system to work, you should [create a virtual host](https://ultimatefosters.com/hosting/setup-a-virtual-host-in-windows-with-xampp-server/). It must be pointing to the `public` folder inside the project root directory, like the example below:

    <VirtualHost *:80>
        ServerName bigdeal.com
        DocumentRoot "/srv/http/bigdeal/public"
        ...
    </VirtualHost>

> **NOTE:** After modifying that you should restart your apache server.

### Creating the database
The next thing you should do is to create a MySQL/MariaDB database. You can do that with the following code:

    CREATE DATABASE IF NOT EXISTS DATABASE_NAME DEFAULT CHARACTER SET UTF8 DEFAULT COLLATE utf8_general_ci;

> **NOTE:** You should replace `DATABASE_NAME` with the actual name of the database you want to create.

After that you should go into the main project folder and run the command (If it is not working, it might be because you don't have MySQL into your path variable):

    mysql -u root -p DATABASE_NAME < database.sql

> **NOTE:** You should replace `DATABASE_NAME` with the given name before.

### Config.php

There is a file called `config.example.php`. You should change the values properly and then rename it to `config.php`.

> By default the id #1 user will have full access to the system. If you want to change that, you'll have to do it manually by going into the database and playing with the `level` column.