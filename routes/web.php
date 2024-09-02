<?php

use App\Http\Controllers\IgrackaController;
use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\MaterijalController;
use App\Http\Controllers\PorudzbinaController;
use App\Http\Controllers\PretragaController;
use App\Http\Controllers\SesijaController;
use App\Http\Controllers\StranicaController;
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

// Pocetna
Route::get('/', [StranicaController::class, 'pocetna']);

// Proizvodi
Route::get('/igracke', [IgrackaController::class, 'index'])->name('igracke.index'); //name zbog forme za select
Route::get('/materijali', [MaterijalController::class, 'index'])->name('materijali.index');;

// Zasebni proizvodi
Route::view('/igracka', 'igracke.show')->name('igracke.show');
Route::view('/materijal', 'materijali.show')->name('materijali.show');
//Route::get('/igracke/{id}', [IgrackaController::class, 'show']);
//Route::get('/materijali/{id}', [MaterijalController::class, 'show']);
//dodati opcionalnost da klikom na zaseban proizvod admin moze da ga menja i brise, edit, patch i delete
//dodati i stranicu za admina gde moze da napravi novi proizvod

// Pretraga
Route::get('/pretraga', [PretragaController::class, 'index'])->name('pretraga.index');

// Korisnici
//Route::get('/registracija', [KorisnikController::class, 'create']);
Route::get('/registracija', [KorisnikController::class, 'show']);

//Route::get('/prijava', [SesijaController::class, 'create']);
//Route::get('/odjava', [SesijaController::class, 'destroy']);
//Route::get('/moj-nalog', [SesijaController::class, 'show']);
Route::get('/prijava', [SesijaController::class, 'prijava']);
Route::get('/odjava', [SesijaController::class, 'odjava']);
Route::get('/moj-nalog', [SesijaController::class, 'mojNalog']);

// Staticne stranice
Route::get('/kontakt', [StranicaController::class, 'kontakt']);
Route::get('/o-nama', [StranicaController::class, 'oNama']);
Route::get('/tutorijali', [StranicaController::class, 'tutorijali']);

// Narudzbine
Route::get('/korpa', [PorudzbinaController::class, 'korpa']); //bice ovo najvrv zasebni kontroleri
Route::get('/porudzbina', [PorudzbinaController::class, 'porudzbina']);
Route::get('/racun', [PorudzbinaController::class, 'racun']);



