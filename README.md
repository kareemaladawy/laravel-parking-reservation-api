# Parking reservations API
[![Status](https://img.shields.io/badge/status-active-success.svg)]() 


[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)
## Overview
This Laravel API allows users to view available parking zones, register, view, update, and remove their vehicles, start, view, and stop their parkings.

## Features
- View available parking zones
- Register, view, update, and remove vehicles
- Start, view, and stop parkings
- Login, register, and logout

## Installation
To install the API, clone this repository to your local machine and run the following commands:

``composer install``

``php artisan key:generate``

``php artisan migrate``

## Usage
Once the API is installed, you can start using it by sending HTTP requests to the following endpoints:

#### Make sure to specify API version before every request

``http
 /api/v1
``

| Endpoint  | Method   | Description                |
| :-------- | :------- | :------------------------- |
| `/zones`  | `GET` | View available zones to use for parking |
| `/vehicles`  | `GET` | View all of your vehicles |
| `/vehicles`  | `POST` | Add a new vehicle |
| `/vehicles/{vehicle}`  | `GET` | View the details of a specific vehicle |
| `/vehicles/{vehicle}`  | `PUT/PATCH` | Update the details of a specific vehicle |
| `/vehicles/{vehicle}`  | `DELETE` | Remove a specific vehicle from your vehicles |
| `/parkings/start`  | `POST` | Start/reserve parking |
| `/parkings/{parking}`  | `GET` | View the details of a parking that's currently in service |
| `/parkings/{parking}`  | `PUT` | Stop parking |
| `/auth/login`  | `POST` | Login a user  |
| `/auth/register`  | `POST` | Register a new user  |
| `/auth/logout`  | `POST` | Logout a user  |





## Examples
#### make sure to include an authentication header for all requests except for ```/zones```, ```/auth/register ```, and ```/auth/login```
To get a list of all available parking zones, send a GET request to the /parking-zones endpoint:

```curl -X GET http://localhost:8000/api/v1/zones ```

To register a new vehicle, send a POST request to the /vehicles endpoint with the following JSON body:

``` 
{
  'plate_number' : "ABC123"
}
```

To get a vehicle by ID, send a GET request to the ```/vehicles/{vehicle}``` endpoint, where {vehicle} is the ID of the vehicle:

```curl -X GET http://localhost:8000/api/v1/vehicles/1```

To start/reserve a new parking, send a POST request to the ```/parkings/start``` endpoint with the following JSON body:

``` 
{
  'vehicle_id' : 1,
  'zone_id' : 1
}
```

To get a parking by ID, send a GET request to the ```/parkings/{parking}``` endpoint, where {parking} is the ID of the parking:

```curl -X GET http://localhost:8000/api/v1/parkings/1```

To get a parking by ID, send a GET request to the ```/parkings/{parking}``` endpoint, where {parking} is the ID of the parking:

```curl -X DELETE http://localhost:8000/api/v1/parkings/1```

To register a new user, send a POST request to the ```/auth/register``` endpoint with the following JSON body:
``` 
{
  'name' : 'Kareem Aladawy,
  'email' : 'ka@mailnator.com',
  'password' : 'password'
}
```
To log in a user, send a POST request to the ```/auth/login``` endpoint with the following JSON body:

``` 
{
  'email' : 'ka@mailnator.com',
  'password' : 'password'
}
```
To log out a user, send a POST request to the ```/auth/logout``` endpoint:

```curl -X POST http://localhost:8000/api/v1/auth/logout```

## Conclusion
This Laravel API provides a comprehensive set of features for managing parking reservations. It is easy to use and can be customized to meet your specific needs.
## Authors

- [@kareemalaadwy](https://www.github.com/kareemalaadwy)


## Contributing

Contributions are always welcome!


