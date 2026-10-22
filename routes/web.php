<?php

use App\Routes\Route;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

// artistes
Route::get('/artistes', 'ArtisteController@index');
Route::get('/artiste/show', 'ArtisteController@show');
Route::get('/artiste/create', 'ArtisteController@create');
Route::post('/artiste/create', 'ArtisteController@store');
Route::get('/artiste/edit', 'ArtisteController@edit');
Route::post('/artiste/update', 'ArtisteController@update');
Route::post('/artiste/delete', 'ArtisteController@delete');

// albums
Route::get('/albums', 'AlbumController@index');
Route::get('/album/show', 'AlbumController@show');
Route::get('/album/create', 'AlbumController@create');
Route::post('/album/create', 'AlbumController@store');
Route::get('/album/edit', 'AlbumController@edit');
Route::post('/album/update', 'AlbumController@update');
Route::post('/album/delete', 'AlbumController@delete');

// chansons
Route::get('/chansons', 'ChansonController@index');
Route::get('/chanson/show', 'ChansonController@show');
Route::get('/chanson/create', 'ChansonController@create');
Route::post('/chanson/create', 'ChansonController@store');
Route::get('/chanson/edit', 'ChansonController@edit');
Route::post('/chanson/update', 'ChansonController@update');
Route::post('/chanson/delete', 'ChansonController@delete');

// genres
Route::get('/genres', 'GenreController@index');
Route::get('/genre/show', 'GenreController@show');
Route::get('/genre/create', 'GenreController@create');
Route::post('/genre/create', 'GenreController@store');
Route::get('/genre/edit', 'GenreController@edit');
Route::post('/genre/update', 'GenreController@update');
Route::post('/genre/delete', 'GenreController@delete');

Route::dispatch();