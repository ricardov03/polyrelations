<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Explaining Many To Many Polymorphic Relationship

This repository has the main purpose to respond to the following asked question from Stack Overflow:
https://stackoverflow.com/questions/68073778/laravel-polymorphic-many-to-many-relationship-pivot-table-with-relationship-to-a?noredirect=1#comment120387610_68073778

## The Problem
- The user needs to establish a relation between tree models using Polymorphic relations to attach resources and avoid duplication.
- The user wants to add some custom fields to the relation table and load this content when retrieving the assets.

## The Answer
- Check the [README.md](https://github.com/ricardov03/polyrelations/tree/main/app/Http/Controllers) file on the Controllers folder.

### How to use this Repository
- [ ] Clone the project.
- [ ] Configure a Database. I already included a Sqlite3 DB on the project. Just update the drive to _sqlite_ and set the **DB_DATABASE** variable to your /project/route/path/./database/relations.db
- [ ] Migrate the Database.
  ```bash
  php artisan migrate:fresh --seed
  # I use the seed flag to include some samples in the database.
  ```
- [ ] Review the Migrations
- [ ] Review the Models
- [ ] Check the Action Controller to understand how to retrieve and store information using Eloquent.
