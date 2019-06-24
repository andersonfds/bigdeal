<?php

session_start();

use System\Route;

// Main routes
Route::on('ANY', '/', 'AnuncioController@index')->run(0);
Route::on('ANY', 'anuncio/([0-9]+)', 'AnuncioController@show')->run(0);

// Advertisement routes
Route::on('GET', 'anuncio/create', 'AnuncioController@create')->run(1);
Route::on('POST', 'anuncio/create', 'AnuncioController@store')->run(1);

Route::on('GET', 'anuncio/([0-9]+)/edit', 'AnuncioController@edit')->run(1);
Route::on('POST', 'anuncio/([0-9]+)/edit', 'AnuncioController@update')->run(1);

Route::on('GET', 'anuncio/([0-9]+)/delete', 'AnuncioController@destroy')->run(1);

// User routes
Route::on('GET', 'anuncio/list', 'AnuncioController@userList')->run(1);
Route::on('GET', 'users/manage', 'UsersController@manage')->run(9);
Route::on('GET', 'users/([0-9]+)/delete', 'UsersController@destroy')->run(9);
Route::on('GET', 'users/([0-9]+)/levelup', 'UsersController@levelUp')->run(9);
Route::on('GET', 'users/([0-9]+)/leveldown', 'UsersController@levelDown')->run(9);

// Login routes
Route::on('GET', 'login', 'LoginController@index')->run(0);
Route::on('POST', 'login', 'LoginController@login')->run(0);
Route::on('ANY', 'logout', 'LoginController@logout')->run(0);

// Register routes
Route::on('GET', 'register', 'RegisterController@index')->run(0);
Route::on('POST', 'register', 'RegisterController@store')->run(0);

// Favorites routes
Route::on('ANY', 'favorites', 'FavoriteController@index')->run(1);
Route::on('ANY', 'favorite/([0-9]+)/add', 'FavoriteController@store')->run(1);
Route::on('ANY', 'favorite/([0-9]+)/remove', 'FavoriteController@destroy')->run(1);

// Categories routes
Route::on('GET', 'category/create', 'CategoryController@create')->run(2);
Route::on('POST', 'category/create', 'CategoryController@store')->run(2);
Route::on('GET', 'category/([0-9]+)/edit', 'CategoryController@edit')->run(2);
Route::on('POST', 'category/([0-9]+)/edit', 'CategoryController@update')->run(2);
Route::on('GET', 'category/list', 'CategoryController@index')->run(2);

// Search Routes
Route::on('GET', 'search', 'SearchController@search')->run(0);