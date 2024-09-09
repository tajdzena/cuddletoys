<!-- Praćenje porudžbine -->
<div id="pracenje" class="section hidden">
    <h2 class="text-2xl text-center font-bold text-dark-pink -mt-12 mb-4">Praćenje porudžbina</h2>

    <!-- Ako nema aktuelnih porudzbina, napisati "Nema aktuelnih porudzbina", isto i za prethodne -->

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
            @endforeach
        @endif

        <!-- Ovde idu ostale prethodne porudzbine -->
    </div>
</div>
