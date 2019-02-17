
# Password Checker

The project was build using [Laravel]  5.7 Framework which is the framework of my choice and using it the past 3 years developing projects for my work. It offers great tools out of the box and also it's offering great extensibility with many libraries making a laravel version.

## Installation

The Project needs the following requirements to run :

* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* BCMath PHP Extension
* Composer Dependency Manager

Install the dependencies by issuing issuing the Composer command in your terminal in the project folder:

```sh
composer install
```

Rename the .env.example to .env and input your own database settings where password table exist.

The rules.yaml file exist in the root folder of the project you can add new rules by following the same format and those rules will be used to validate the passwords.

To use the password checker and validate the database passwords use the following command :
 ```sh
 php artisan password:check
 ```
 
 User can validate a password by passing it as a command argument like this :
 ```sh
  php artisan password:check password321
  ```