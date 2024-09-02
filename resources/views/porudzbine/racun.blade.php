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
        <h1 class="text-3xl font-bold text-dark-pink mb-6">Tijana, hvala na porudžbini!</h1>
        <p class="text-md text-gray-700 mb-4">Broj tvoje pošiljke je: <span class="font-bold">#00000001</span> i možeš je pratiti sa svog <a href="/moj-nalog" class="text-purple underline">naloga</a>.</p>
        <p class="text-md text-gray-700 mb-12">Ako igračku praviš sam/a, poseti <a href="/tutorijali" class="text-purple underline">Tutorijale</a>.</p>
    </div>

    <!-- Pregled računa -->
    <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mt-6">
        <h2 class="text-lg font-bold text-blue mb-4">Pregled tvog računa:</h2>
        <div class="border border-green border-2 p-4 rounded-lg">
            <p class="text-md text-gray-700 font-semibold mb-2">Broj računa: <span class="text-dark-pink font-bold">#00000001</span></p>
            <p class="text-md text-gray-700 font-semibold mb-2">Iznos: <span class="text-dark-pink font-bold">4.000 RSD</span></p>
            <p class="text-md text-gray-700 font-semibold mb-2">Metod plaćanja: <span class="text-dark-pink font-bold">Po preuzeću</span></p>
            <p class="text-md text-gray-700 font-semibold mb-2">Datum i vreme izdavanja računa: <span class="text-dark-pink font-bold">___</span></p>
            <p class="text-md text-gray-700 font-semibold">Datum i vreme plaćanja: <span class="text-dark-pink font-bold">po isporuci / datum sa kartice</span></p>
        </div>
    </div>
</x-glavni-div>

<x-footer />
