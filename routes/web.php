<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IgrackaController;
use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\RegistracijaController;
use App\Http\Controllers\MaterijalController;
use App\Http\Controllers\PorudzbinaController;
use App\Http\Controllers\PretragaController;
use App\Http\Controllers\PrijavaController;
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
Route::get('/igracke/{id}', [IgrackaController::class, 'show'])->name('igracke.show');
Route::get('/materijali/{id}', [MaterijalController::class, 'show'])->name('materijali.show');
Route::get('/materijal-boje/{idDimenzije}', [MaterijalController::class, 'getBojeByDimenzija']);

//dodati opcionalnost da klikom na zaseban proizvod admin moze da ga menja i brise, edit, patch i delete
//dodati i stranicu za admina gde moze da napravi novi proizvod


// Pretraga
Route::get('/pretraga', [PretragaController::class, 'index'])->name('pretraga.index');

// Korisnici
Route::get('/registracija', [RegistracijaController::class, 'create'])->name('registracija.create');
Route::post('/registracija', [RegistracijaController::class, 'store'])->name('registracija.store');

Route::get('/prijava', [PrijavaController::class, 'create'])->name('prijava.create');
Route::post('/prijava', [PrijavaController::class, 'store'])->name('prijava.store');
Route::post('/odjava', [PrijavaController::class, 'destroy'])->name('prijava.destroy');

// Rute za profil korisnika
Route::get('/nalog', [KorisnikController::class, 'nalog'])->name('nalog');
Route::post('/nalog/izmeni', [KorisnikController::class, 'izmeniPodatke'])->name('nalog.izmeni');
Route::post('/nalog/reset-lozinke', [KorisnikController::class, 'resetujLozinku'])->name('nalog.reset');

// Staticne stranice
Route::get('/kontakt', [StranicaController::class, 'kontakt']);
Route::get('/o-nama', [StranicaController::class, 'oNama']);
Route::get('/tutorijali', [StranicaController::class, 'tutorijali']);

// Narudzbine
Route::get('/korpa', [PorudzbinaController::class, 'korpa']); //bice ovo najvrv zasebni kontroleri
Route::get('/porudzbina', [PorudzbinaController::class, 'porudzbina']);
Route::get('/racun', [PorudzbinaController::class, 'racun']);



