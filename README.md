# revolut-laravel

* [revolut data](#revolut) 
* [install repository](#install) 
Laravel [project](https://github.com/borowicz/revolut-laravel/) for [Revolut.com](https://app.revolut.com/start) data browser with [Laravel 11](https://laravel.com/docs/11.x/) 

## <font color="darkred">Test project in development, may contain errors....</font>
work in progres, pork in wrongress :-D
 
## revolut
```
 
go to:
 - revolut.com app on your mobile
 - invest / crypto / commodities / robo / accounts
 - more (three dots button) 
    >> documents
    >> brokerage account
    >> account statement
        >>> Excel - select date range 
        >>> get statement button
        >>> save csv file
 
```
 
 
## install
 
```shell

git clone git@github.com:borowicz/revolut-laravel.git
cd revolut-laravel
ddev start 
ddev exec bash
composer install
./artisan migrate
./artisan db:seedphp artisan breeze:install
npm i
npm run build

```
 
 > *github://borowicz/revolut-laravel* - revolut.com data + laravel
 
