<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::view('/', 'index');

Route::view('/igracke', 'igracke');
Route::view('/materijali', 'materijali');
Route::view('/kontakt', 'kontakt');
Route::view('/o-nama', 'o-nama');

Route::view('/igracka', 'igracka');
Route::view('/materijal', 'materijal');

Route::view('/pretraga', 'pretraga');

Route::view('/registracija', 'registracija');
Route::view('/prijava', 'prijava');

Route::view('/moj-nalog', 'moj-nalog');

Route::view('/korpa', 'korpa');

Route::view('/porudzbina', 'porudzbina');

Route::view('/racun', 'racun');

Route::view('/tutorijali', 'tutorijali');



