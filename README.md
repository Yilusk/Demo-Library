## Demo Library App

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Demo Library with Vue 3 and Inertia

This project is done for study puposes to learn more about the Laravel Ecosystem and Vue 3. Made with Larastarters windmill template, TailwindCSS and PrimeVue

## Prerequisites

 * PHP 8.2
 * Laravel 11.29
 * Node 20.12.2

## Tech Stack

**Client:** Vue 3, TailwindCSS, PrimeVue

**Server:** PHP, Laravel


## Installation

Install the npm dependencies:

```bash
npm install
```
## Important

* Create a .env file and copy all from **.env.example**

Generate a new key application

```bash
php artisan key:generate
```

Use the command to make the default sqlite database or change the .env values to use the one you want [ MySql, Postgres, Etc.. ]

```bash
php artisan migrate:install
```

Run the migrations

```bash
php artisan migrate
```


Create the symbolic links to make use of images

```bash
php artisan storage:link
```


## Run Locally

Run the project using the followings commands on different terminals

```bash
php artisan serve
npm run dev
```