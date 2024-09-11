<x-nav>
    <title>CuddleToys - Račun</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/moj-nalog" class="hover:underline"> Moj nalog</a>
        / <a href="/racun" class="hover:underline"> Račun</a>
    </x-path>

    <x-title>Račun</x-title>

    <!-- Naslov i zahvalnica -->
    <div class="text-start mt-8">
        <h1 class="text-3xl font-bold text-dark-pink mb-6">{{ Auth::user()->ime }}, hvala na porudžbini!</h1>
        <p class="text-md text-gray-700 mb-4">Broj tvoje pošiljke je: <span class="font-bold">#{{ str_pad($racun->idPosiljka, 8, '0', STR_PAD_LEFT) }}</span>
            i možeš je pratiti sa svog <a href="/nalog" class="text-purple underline">naloga</a>.</p>
        <p class="text-md text-gray-700 mb-12">Ako igračku praviš sam/a, poseti <a href="/tutorijali" class="text-purple underline">Tutorijale</a>.</p>
    </div>

    <!-- Pregled računa -->
    <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mt-6">
        <h2 class="text-lg font-bold text-blue mb-4">Pregled tvog računa:</h2>
        <div class="border border-green border-2 p-4 rounded-lg">
            <p class="text-md text-gray-700 font-semibold mb-2">Broj računa: <span class="text-dark-pink font-bold">#{{ str_pad($racun->idRacun, 8, '0', STR_PAD_LEFT) }}</span></p>
            <p class="text-md text-gray-700 font-semibold mb-2">Iznos: <span class="text-dark-pink font-bold">{{ sprintf('%.2f', $racun->iznos) }} RSD</span></p>
            <p class="text-md text-gray-700 font-semibold mb-2">Metod plaćanja: <span class="text-dark-pink font-bold">{{ $racun->idMetodPlacanja == 2 ? 'Kartica' : 'Po preuzeću' }}</span></p>
            <p class="text-md text-gray-700 font-semibold mb-2">Datum i vreme izdavanja računa: <span class="text-dark-pink font-bold">{{ $racun->datum_vreme_izdavanjaR->format('d.m.Y H:i') }}</span></p>
            <p class="text-md text-gray-700 font-semibold">Datum i vreme plaćanja: <span class="text-dark-pink font-bold">{{ $racun->idMetodPlacanja == 2 ? $racun->datum_vreme_placanja->format('d.m.Y H:i') : 'Po preuzeću' }}</span></p>
        </div>
    </div>
</x-glavni-div>

<x-footer />
