@props(['pret_ili_akt'=>'prethodna',
        'broj_posiljke',
        'broj_racuna',
        'ime',
        'prezime',
        'mejl',
        'telefon',
        'adresa_isporuke',
        'adresa_placanja',
        'status_posiljke',
        'vreme_statusa',
        'iznos',
        'metod_placanja'])

<div class="mb-4">
    <div class="{{ $pret_ili_akt == 'prethodna' ? 'border-yellow' : 'border-green' }} border-2 p-4 rounded-lg">
        <p class="text-md text-gray-700 font-semibold mb-2">Broj pošiljke: <span class="text-dark-pink font-bold">{{$broj_posiljke}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Broj računa: <span class="text-dark-pink font-bold">{{$broj_racuna}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Ime: <span class="text-dark-pink font-bold">{{$ime}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Prezime: <span class="text-dark-pink font-bold">{{$prezime}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Mejl: <span class="text-dark-pink font-bold">{{$mejl}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Telefon: <span class="text-dark-pink font-bold">{{$telefon}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Adresa isporuke: <span class="text-dark-pink font-bold">{{$adresa_isporuke}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Adresa plaćanja: <span class="text-dark-pink font-bold">{{$adresa_placanja}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Status: <span class="text-dark-pink font-bold">{{$status_posiljke}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Vreme statusa: <span class="text-dark-pink font-bold">{{$vreme_statusa}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Iznos: <span class="text-dark-pink font-bold">{{$iznos}}</span></p>
        <p class="text-md text-gray-700 font-semibold">Metod plaćanja: <span class="text-dark-pink font-bold">{{$metod_placanja}}</span></p>
    </div>
</div>
