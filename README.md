Requirements
===============================
PHP >= 7.4

Install
===============================
Via Composer:
```
composer install
```

Running app
===============================
Run:
```
php index.php owner/repo branch
```
 optional with `--service=` parameter:
 ```
 php index.php owner/repo branch --service=github
```
The order of the parameters does not matter.
  
Running unit tests
===============================
Run `./vendor/bin/phpunit tests` to execute the unit tests via PHP Unit:

Run ` ./vendor/bin/phpunit tests --coverage-text coverage` to execute the unit tests with coverage. 