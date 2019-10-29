# README [![Ecommerce Vue Laravel Sample](https://github.com/DushyanthaHerath/)]
> Setup Instructions

## Setup
> Backend
- Clone: __git clone git@github.com:DushyanthaHerath/e-commerce-sample.git__
- cd __DIRECTORY__
- Copy __.env.example__ file to __.env__ and edit database credentials and APP_URL
- Run __composer install__
- Run __composer dump-autoload__
- Run __php artisan key:generate__
- Run __php artisan migrate__
- Run __php artisan storage:link__
- Run __php artisan db:seed__
- Run __php artisan passport:keys__
- Run __php artisan passport:client --personal__ (For issue personal access tokens)
- Run __php artisan serve__

> Frontend
- Run __npm install__
- Run __npm run dev__

## Included
- Vue 2.5 Frontend
- Laravel 5.7 Backend

## Main Libraries Used
- Laraspace-vue
- kalnoy/nestedset
- Vue product grid

![](Peek 2019-10-01 22-39.gif)
