# ![Parking Reservation API - Laravel]

This repo is functionality complete, PRs and issues are welcome

---

# Getting started

## Installation

Alternative installation is possible without local dependencies relying on [Docker](#docker).

Clone the repository

    git clone git@github.com:kareemaladawy/Parking-Reservation-API.git

Switch to the repo folder

    cd Parking-Reservation-API

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

# Testing the API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

And the api documentation can be accessed at

    http://localhost:8000/docs
