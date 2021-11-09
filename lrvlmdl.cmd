@echo off

echo Creating Model and Migration ...
php artisan make:model %1 -m

echo Creating Model Observer ...
php artisan make:observer %1Observer --model=%1

echo Creating API Controller ...
php artisan make:controller %1Controller --api --model=%1

echo Creating Resource ...
php artisan make:resource %1Resource

echo Creating Form Requests ...
php artisan make:request %1/%1IndexRequest
php artisan make:request %1/%1StoreRequest
php artisan make:request %1/%1ShowRequest
php artisan make:request %1/%1UpdateRequest
php artisan make:request %1/%1DestroyRequest

echo Creating Factory ...
php artisan make:factory %1Factory --model=%1

echo Creating Test ...
php artisan make:test %1Test
