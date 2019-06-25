Bought product
=========
This is PHP CLI command which is intended for buying products from a machine.

##### Till start using the command make sure that you have installed:
* GIT
* Composer
* PHP 7.1

Installation
-----
Just run the commands from the root project folder:
```
$ git git@github.com:evgeniispirin/machine.git
$ composer install
$ composer dump -o

How to use:
-----
The command takes a few arguments: limangorec:machine(main command), purchase(action), -p(product name), -a amount(amount of product), -m(money) 
```
$ php console.php limangorec:machine purchase -p cigarette -a 1 -m 10
```

