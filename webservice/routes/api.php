<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/cadastro', 'UsuarioController@cadastro');
Route::post('/login', 'UsuarioController@login');

Route::middleware('auth:api')->put('/perfil', 'UsuarioController@perfil');
Route::middleware('auth:api')->post('/usuario/amigo', 'UsuarioController@amigo');

Route::middleware('auth:api')->post('/conteudo/adicionar', 'ConteudoController@adicionar');
Route::middleware('auth:api')->get('/conteudo/lista', 'ConteudoController@lista');
Route::middleware('auth:api')->put('/conteudo/curtir/{id}', 'ConteudoController@curtir');
Route::middleware('auth:api')->get('/conteudo/pagina/lista/{id}', 'ConteudoController@pagina');

Route::middleware('auth:api')->post('/comentario/adicionar/{id}', 'ComentarioController@adicionar');
