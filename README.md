<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

This repo is functionality complete — PRs and issues welcome!

---

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](https://github.com/gothinkster/laravel-realworld-example-app/blob/master/readme.md#docker).

Clone the repository

```
git clone https://github.com/Ripeplantain/Invoice-Api.git
```

Switch to the repo folder

```
cd Invoice-Api
```

Install all the dependencies using composer

```
composer install
```

Copy the example env file and make the required configuration changes in the .env file

```
cp .env.example .env
```

Generate a new application key

```
php artisan key:generate
```

Run the database migrations ( **Set the database connection in .env before migrating** )

```
php artisan migrate
```

Generate client key for laravel passport

```
php artisan passport:install

```

Start the local development server

```
php artisan serve
```

You can now access the server at [http://localhost:8000](http://localhost:8000/)

**TL;DR command list**

```
git clone git@github.com:gothinkster/laravel-realworld-example-app.git
cd laravel-realworld-example-app
composer install
cp .env.example .env
php artisan key:generate
php artisan passport:install
```

**Make sure you set the correct database connection information before running the migrations** [Environment variables](https://github.com/gothinkster/laravel-realworld-example-app/blob/master/readme.md#environment-variables)

```
php artisan migrate
php artisan serve
```

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Open the DummyDataSeeder and set the property values as per your requirement

Run the database seeder and you're done

```
php artisan db:seed
```

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

```
php artisan migrate:refresh
```

## Docker

To install with [Docker](https://www.docker.com/), run following commands:

```
git clone git@github.com:gothinkster/laravel-realworld-example-app.git
cd laravel-realworld-example-app
cp .env.example.docker .env
docker run -v $(pwd):/app composer install
cd ./docker
docker-compose up -d
docker-compose exec php php artisan key:generate
php artisan passport:install
docker-compose exec php php artisan migrate
docker-compose exec php php artisan db:seed
docker-compose exec php php artisan serve --host=0.0.0.0
```

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

## API Specification

A documentation to the api backend is provided. All routes aside login and register are authenticated are protected so do make sure to authenticate first

> [Api Documentation](https://documenter.getpostman.com/view/19442150/2s9Ye8hb9C)

---

# Code overview

## Dependencies

* Laravel Passport

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

---

# Testing API

Run the laravel development server

```
php artisan serve
```

The api can now be accessed at

```
http://localhost:8000/api/v1
```

Request headers

| **Required** | **Key**    | **Value**  |
| ------------------ | ---------------- | ---------------- |
| Yes                | Content-Type     | application/json |
| Yes                | X-Requested-With | XMLHttpRequest   |
| Optional           | Authorization    | Token {JWT}      |

Refer the [api specification](https://github.com/gothinkster/laravel-realworld-example-app/blob/master/readme.md#api-specification) for more info.


## Folders

**Contollers/Api - Contains all api controllers**

Models - Contains eloquent models

Factories - Contain blueprint for seeding database with data

tests/Features - Contains test for all features on this application

Migration - Contains table migration

route/api.php - Contains endpoints for api

.env.testing - Contains credentials for running tests. Please check before running tests
