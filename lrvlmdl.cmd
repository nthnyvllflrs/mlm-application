@echo off

echo Creating Model and Migration ...
php artisan make:model %1 -m

echo Creating Model Observer ...
php artisan make:observer %1Observer --model=%1

echo Creating API Controller ...
php artisan make:controller %1Controller --api --model=%1

echo Creating Resource ...
php artisan make:resource %1Resource

echo Creating Policy ...
php artisan make:policy %1Policy --model=%1

echo Creating Form Requests ...
php artisan make:request %1/Index%1Request
php artisan make:request %1/Store%1Request
php artisan make:request %1/Show%1Request
php artisan make:request %1/Update%1Request
php artisan make:request %1/Destroy%1Request

echo Creating Factory ...
php artisan make:factory %1Factory --model=%1

echo Creating Test ...
php artisan make:test %1Test
