<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use App\Models\Posiljka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosiljkaController extends Controller{

    public function updateStatus($id)
    {
        //$this->authorize(['isKurir', 'isAdmin'], Auth::user()); // Samo kurir i admin mogu menjati status

        $korisnik = Auth::user();

        if ($korisnik->getAuthIdentifier() == 1 || $korisnik->getAuthIdentifier() == 3) {
            $posiljka = Posiljka::findOrFail($id);
            $status = request()->input('status');

            $posiljka->status_posiljke = $status;
            $posiljka->vreme_statusa = now();
            $posiljka->save();

            return redirect()->back()->with('success', 'Status porudžbine uspešno ažuriran.');
        }

        // Ako korisnik nije admin ili kurir
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function delete($id)
    {
//        $this->authorize('isAdmin', Auth::user()); // Samo admin može brisati porudžbine

        $korisnik = Auth::user();

        if ($korisnik->getAuthIdentifier() == 1) {
            $posiljka = Posiljka::findOrFail($id);
            $posiljka->delete();

            return redirect()->back()->with('success', 'Porudžbina uspešno obrisana.');
        }

        // Ako korisnik nije admin ili kurir
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}