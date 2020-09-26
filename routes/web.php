<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Rutas de Media-types
Route::get("mediatypes/insert", "MediaTypesController@showmass");
Route::post("mediatypes/store", "MediaTypesController@storemass");

//Ruta de prueba para la masterPage
Route::get('masterpage', function () {
    return view('layouts.masterpage');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Rutas resource

//Rutas de prefijo: imagen
Route::prefix('imagenes')->group(function(){
    Route::get('Crear','ImageController@create');
    Route::post('Guardar','ImageController@store');
});

Route::get('pdf',"PDFController@index");
