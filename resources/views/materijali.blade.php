<x-nav>
    <title>CuddleToys - Materijali</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/materijali" class="hover:underline"> Materijali</a>
    </x-path>

    <x-title>Prikaz svih materijala</x-title>

    <div class="flex flex-col md:flex-row md:justify-between mb-6">
        <!-- Sortiranje -->
        <div>
            <label for="sort" class="block text-dark-pink font-semibold mb-2">Sortiraj po:</label>
            <x-select id="sort">
                <x-option value="" isDisabled="yes">Izaberi sortiranje</x-option>
                <x-option value="1">Cena (rastuće)</x-option>
                <x-option value="2">Cena (opadajuće)</x-option>
                <x-option value="3">Naziv (A-Š)</x-option>
                <x-option value="4">Naziv (Š-A)</x-option>
                <x-option value="5">Najnoviji</x-option>
            </x-select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Primer proizvoda -->
        <x-card-proizvod putanja="images/materijali/heklica/heklica3mm.jpg" alt="Heklica" href="materijal" naziv="Heklica 3-12mm" cena="200 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/vunica/vunica-zuta.jpg" alt="Vunica" href="materijal" naziv="Vunica" cena="400 RSD (po metru)"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/punjenje/punjenje300g.jpg" alt="Punjenje" href="materijal" naziv="Punjenje 300g" cena="700 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/makaze/makaze.jpg" alt="Makaze" href="materijal" naziv="Makaze" cena="500 RSD"></x-card-proizvod>
    </div>
</x-glavni-div>

<x-footer />
