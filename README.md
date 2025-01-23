# Real Estate

This is a vanilla PHP implementation of a platform for trading real estate. It's built on PHP 8.1 and MySQL.

You can visit it at [estates.andrija.rs](https://estates.andrija.rs)

## Features
TBD.  
## Framework
This is a custom backend framework that I built to make it easier to manage this project. It supports both MVC and Web 
API applications. It also has built-in dependency injection.

## Docker
In order to enable permission for the docker container to write files in `/uploads` you need to execute these commands:  
* `sudo chown -R www-data:www-data uploads`
* `find uploads -type d -exec chmod 775 {} \;`
* `find uploads -type f -exec chmod 664 {} \;`
* `sudo usermod -aG www-data $USER`
