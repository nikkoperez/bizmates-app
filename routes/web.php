<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WeatherController@index');

Route::get('/getForecast', 'WeatherController@getForecast')->name('WeatherController.getForecast');

Route::get('/getPlaces', 'WeatherController@getPlaces')->name('WeatherController.getPlaces');