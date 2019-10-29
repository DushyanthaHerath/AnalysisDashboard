# README [![Highchart Analysis Dashboard]]

## Requirements
- PHP7.2
- NPM

> Setup Instructions

## Setup
> Backend
- Clone: __git clone git@github.com:DushyanthaHerath/AnalysisDashboard.git__
- cd __DIRECTORY__
- Copy __.env.example__ file to __.env__ and edit database credentials and APP_URL
- Run __composer install__
- Run __composer dump-autoload__
- Run __php artisan key:generate__
- Run __php artisan migrate__
- Run __php artisan db:seed__ Might take time. You can reduce number of records using constant provided in Seeder
- Run __php artisan passport:keys__
- Run __php artisan serve__

> Frontend
- Run __npm install__
- Run __npm run dev__

## Included
- Vue 2.5 Frontend
- Laravel 5.7 Backend

## Main Libraries Used

- Highchart
- Highchart-vue wrapper
- Laraspace-vue

![](Peek.gif)
