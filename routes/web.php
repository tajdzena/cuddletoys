<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IgrackaController;
use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\PosiljkaController;
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
Route::get('/materijali', [MaterijalController::class, 'index'])->name('materijali.index');


// Zasebni proizvodi
Route::get('/igracke/{id}', [IgrackaController::class, 'show'])->name('igracke.show');
Route::get('/materijali/{id}', [MaterijalController::class, 'show'])->name('materijali.show');

Route::get('/materijal-boje/{idDimenzije}', [MaterijalController::class, 'getBojeByDimenzija']);
Route::post('/get-igracka-kombinacija', [IgrackaController::class, 'getIgrackaKombinacija']);
Route::post('/get-materijal-kombinacija', [MaterijalController::class, 'getMaterijalKombinacija']);

Route::get('/igracke/{id}/edit', [IgrackaController::class, 'edit'])->name('igracke.edit');
Route::get('/materijali/{id}/edit', [MaterijalController::class, 'edit'])->name('materijali.edit');

Route::post('/igracke/{id}/update', [IgrackaController::class, 'update'])->name('igracke.update');
Route::post('/materijali/{id}/update', [MaterijalController::class, 'update'])->name('materijali.update');

Route::delete('/igracke/{id}/delete', [IgrackaController::class, 'delete'])->name('igracke.delete');
Route::delete('/materijali/{id}/delete', [MaterijalController::class, 'delete'])->name('materijali.delete');

//dodati i stranicu za admina gde moze da napravi novi proizvod


// Pretraga
Route::get('/pretraga', [PretragaController::class, 'index'])->name('pretraga.index');


// Korisnici
Route::get('/registracija', [RegistracijaController::class, 'create'])->name('registracija.create');
Route::post('/registracija', [RegistracijaController::class, 'store'])->name('registracija.store');

Route::get('/prijava', [PrijavaController::class, 'create'])->name('prijava.create')->middleware('guest');
Route::post('/prijava', [PrijavaController::class, 'store'])->name('prijava.store');

Route::post('/odjava', [PrijavaController::class, 'destroy'])->name('prijava.destroy');

// Rute za profil korisnika
Route::get('/nalog', [KorisnikController::class, 'index'])->name('nalog')->middleware('auth');
Route::post('/nalog/izmeni', [KorisnikController::class, 'izmeniPodatke'])->name('nalog.izmeni')->middleware('auth');
Route::post('/nalog/reset-lozinke', [KorisnikController::class, 'resetujLozinku'])->name('nalog.reset')->middleware('auth');

Route::get('/nalog/get-meseci-godine', [KorisnikController::class, 'getMeseciGodine'])->name('getMeseciGodine')->middleware('auth');
Route::post('/nalog/statistika', [KorisnikController::class, 'getStatistika'])->name('nalog.statistika')->middleware('auth');
Route::post('/nalog/broj-prodaja', [KorisnikController::class, 'getBrojProdajaProizvoda'])->name('nalog.brojProdaja')->middleware('auth');

Route::post('/posiljke/{id}/status', [PosiljkaController::class, 'updateStatus'])->name('posiljke.updateStatus')->middleware('auth');
Route::delete('/posiljke/{id}', [PosiljkaController::class, 'delete'])->name('posiljke.delete')->middleware('auth');
Route::get('/korisnici/porudzbine/{idKorisnik}', [KorisnikController::class, 'getPorudzbineForUser'])->name('korisnici.pracenje');


// Staticne stranice
Route::get('/kontakt', [StranicaController::class, 'kontakt']);
Route::get('/o-nama', [StranicaController::class, 'oNama']);
Route::get('/tutorijali', [StranicaController::class, 'tutorijali']);


// Narudzbine
Route::get('/korpa', [PorudzbinaController::class, 'korpa'])->name('porudzbine.korpa')->middleware('auth');

Route::post('/dodaj-u-korpu', [PorudzbinaController::class, 'dodajUKorpu'])->name('dodajUKorpu')->middleware('auth');
Route::delete('/korpa-ukloni/{id}', [PorudzbinaController::class, 'ukloniStavku'])->name('ukloni')->middleware('auth');

Route::post('/azuriraj-nacin-pravljenja', [PorudzbinaController::class, 'azurirajNacinPravljenja'])->name('azurirajNacinPravljenja')->middleware('auth');
Route::post('/azuriraj-kolicinu', [PorudzbinaController::class, 'azurirajKolicinu'])->name('azurirajKolicinu')->middleware('auth');

Route::get('/porudzbina', [PorudzbinaController::class, 'porudzbina'])->name('porudzbina')->middleware('auth');
Route::post('/porudzbina', [PorudzbinaController::class, 'porudzbina'])->name('porudzbina')->middleware('auth');
Route::post('/zavrsi-porudzbinu', [PorudzbinaController::class, 'zavrsiPorudzbinu'])->name('zavrsiPorudzbinu')->middleware('auth');
Route::get('/racun', [PorudzbinaController::class, 'racun'])->name('racun')->middleware('auth');



