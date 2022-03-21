<?php

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api/books'], function () use($router){

    $router->get('','BooksController@index');

});

$router->group(['prefix' => 'api/characters'], function () use($router){

    $router->get('/query','CharactersController@query');

});

$router->group(['prefix' => 'api/comments'], function () use($router){

    $router->get('','CommentsController@index');

    $router->post('','CommentsController@store');

});

$router->group(['prefix' => 'api/docs'], function () use($router){

    $router->get('',function (){
        return file_get_contents("../public/docs/index.html");
    });

});
