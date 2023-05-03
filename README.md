# Parking Reservation API - Laravel

This repo is functionally complete, PRs and issues are welcome

---

# Getting started

### ERD
![drawSQL-vehicle-parking-api-export-2023-05-03](https://user-images.githubusercontent.com/62149929/235961695-1309c338-40cc-4d78-b860-7b2f8cc993d3.png)

## Installation

    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    php artisan serve

The api can now be accessed at

    http://localhost:8000/api/v1

And the api documentation can be accessed at

    http://localhost:8000/docs
