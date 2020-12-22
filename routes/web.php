<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/info_perfil/{user}', 'UserController@getInfoPerfil')->name('info_perfil');
Route::post('/editarperfil', 'UserController@putEditarPerfil')->name('editar_perfil');

// rutas de post
Route::post('posts', 'PostController@guardar_post')->name('guardar_post');
Route::get('/home/like/{post}', 'PostController@getLikePost')->name('like_post');
Route::get('/home/dislike/{post}', 'PostController@getDislikePost')->name('dislike_post');
Route::get('/home/compartir/{post}', 'PostController@getCompartirPost')->name('compartir_post');
Route::get('/home/comentarios/{post}', 'PostController@getVerComentarios')->name('ver_comentarios');
Route::post('/home/comentar/{post}', 'PostController@postComentarPost')->name('comentar_post');



// rutas de  login de facebook
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('facebook');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');