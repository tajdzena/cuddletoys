@props(['pret_ili_akt'=>'prethodna', 'adresa_isporuke', 'status_porudzbine', 'vreme_statusa', 'iznos', 'metod_placanja'])

<div class="mb-4">
    @if($pret_ili_akt == 'prethodna')
        <div class="border border-yellow border-2 p-4 rounded-lg">
    @else
        <div class="border border-green border-2 p-4 rounded-lg">
    @endif
        <p class="text-md text-gray-700 font-semibold mb-2">Adresa isporuke: <span class="text-dark-pink font-bold">{{$adresa_isporuke}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Status: <span class="text-dark-pink font-bold">{{$status_porudzbine}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Vreme statusa: <span class="text-dark-pink font-bold">{{$vreme_statusa}}</span></p>
        <p class="text-md text-gray-700 font-semibold mb-2">Iznos: <span class="text-dark-pink font-bold">{{$iznos}}</span></p>
        <p class="text-md text-gray-700 font-semibold">Metod plaćanja: <span class="text-dark-pink font-bold">{{$metod_placanja}}</span></p>
    </div>
        </div>
