<!-- Aktuelne porudzbine -->
<div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-purple mb-4">Aktuelne porudžbine</h2>

    @if ($aktuelnePorudzbine->isEmpty())
        <p>Još uvek nemaš aktuelne porudžbine.</p>
    @else
        @foreach ($aktuelnePorudzbine as $posiljka)
            <x-card-porudzbina
                pret_ili_akt="aktuelna"
                broj_posiljke="#{{ sprintf('%08d', $posiljka->idPosiljka) }}"
                broj_racuna="#{{ sprintf('%08d', $posiljka->racun->idRacun) }}"
                ime="{{ $posiljka->ime_p }}"
                prezime="{{ $posiljka->prezime_p }}"
                mejl="{{ $posiljka->mejl_p }}"
                telefon="{{ $posiljka->telefon_p }}"
                adresa_isporuke="{{ $posiljka->adresa_isporuke }}"
                adresa_placanja="{{ $posiljka->adresa_placanja }}"
                status_posiljke="{{ ucfirst($posiljka->status_posiljke) }}"
                vreme_statusa="{{ $posiljka->vreme_statusa }}"
                iznos="{{ sprintf('%.2f', $posiljka->racun->iznos) }} RSD"
                metod_placanja="{{ ucfirst($posiljka->racun->metodPlacanja->naziv_p) }}"
            ></x-card-porudzbina>


            <!-- Ako je kurir, prikaži opciju za promenu statusa -->
            @canany(['isKurir', 'isAdmin'], Auth::user())
                <form action="{{ route('posiljke.updateStatus', ['id' => $posiljka->idPosiljka]) }}" method="POST" class="mt-4">
                    @csrf
                    <label for="status" class="font-semibold">Izmeni status porudžbine:</label>
                    <select name="status" id="status" class="border rounded p-2">
                        <option value="u izradi" {{ $posiljka->status_posiljke == 'u izradi' ? 'selected' : '' }}>U izradi</option>
                        <option value="u transportu" {{ $posiljka->status_posiljke == 'u transportu' ? 'selected' : '' }}>U transportu</option>
                        <option value="isporučena" {{ $posiljka->status_posiljke == 'isporučena' ? 'selected' : '' }}>Isporučena</option>
                    </select>
                    <x-button type="submit" class="ml-2 py-1 px-4">Izmeni status</x-button>
                </form>
            @endcanany

            <!-- Ako je admin, prikaži opciju za brisanje porudžbine -->
            @can('isAdmin', Auth::user())
                <form action="{{ route('posiljke.delete', ['id' => $posiljka->idPosiljka]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" class="bg-blue hover:bg-blue/40 text-white mb-8 py-1 px-2">Obriši porudžbinu</x-button>
                </form>
            @endcan

        @endforeach
    @endif

    <!-- ovde ide sledeca aktuelna porudzbina -->
</div>


<!-- Prethodne porudzbine -->
<div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold text-purple mb-4">Prethodne porudžbine</h2>

    @if ($prethodnePorudzbine->isEmpty())
        <p>Još uvek nemaš prethodne porudžbine.</p>
    @else
        @foreach ($prethodnePorudzbine as $posiljka)
            <x-card-porudzbina
                broj_posiljke="#{{ sprintf('%08d', $posiljka->idPosiljka) }}"
                broj_racuna="#{{ sprintf('%08d', $posiljka->racun->idRacun) }}"
                ime="{{ $posiljka->ime_p }}"
                prezime="{{ $posiljka->prezime_p }}"
                mejl="{{ $posiljka->mejl_p }}"
                telefon="{{ $posiljka->telefon_p }}"
                adresa_isporuke="{{ $posiljka->adresa_isporuke }}"
                adresa_placanja="{{ $posiljka->adresa_placanja }}"
                status_posiljke="{{ ucfirst($posiljka->status_posiljke) }}"
                vreme_statusa="{{ $posiljka->vreme_statusa }}"
                iznos="{{ sprintf('%.2f', $posiljka->racun->iznos) }} RSD"
                metod_placanja="{{ ucfirst($posiljka->racun->metodPlacanja->naziv_p) }}"
            ></x-card-porudzbina>

            <!-- Ako je admin, prikaži opciju za brisanje porudžbine -->
            @can('isAdmin', Auth::user())
                <form action="{{ route('posiljke.delete', ['id' => $posiljka->idPosiljka]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" class="bg-blue hover:bg-blue/40 text-white mb-8 py-1 px-2">Obriši porudžbinu</x-button>
                </form>
            @endcan
        @endforeach
    @endif

    <!-- Ovde idu ostale prethodne porudzbine -->
</div>
