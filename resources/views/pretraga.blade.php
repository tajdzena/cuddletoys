<x-nav>
    <title>CuddleToys - Pretraga</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/pretraga" class="hover:underline"> Pretraga</a>
    </x-path>

    <x-title>Pretraga</x-title>

    <!-- Pretraga i sortiranje -->
    <div class="flex flex-col md:flex-row md:justify-between mb-8">
        <x-label-input for="pretraga" text="Pretraži proizvode: " type="text" id="pretraga" name="pretraga" placeholder="npr. žaba..."></x-label-input>
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
        <x-card-proizvod putanja="images/igracke/zaba/zaba1.png" href="igracka" alt="Žaba" naziv="Žaba" cena="2000 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/igracke/slon/slon1.png" href="igracka" alt="Slon" naziv="Slon" cena="2000 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/heklica/heklica3mm.jpg" alt="Heklica" href="materijal" naziv="Heklica 3-12mm" cena="200 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/vunica/vunica-zuta.jpg" alt="Vunica" href="materijal" naziv="Vunica" cena="400 RSD (po metru)"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/punjenje/punjenje300g.jpg" alt="Punjenje" href="materijal" naziv="Punjenje 300g" cena="700 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/makaze/makaze.jpg" alt="Makaze" href="materijal" naziv="Makaze" cena="500 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/igracke/patka/patka1.png" href="igracka" alt="Patka" naziv="Patka" cena="2000 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/igracke/meda/meda1.png" href="igracka" alt="Meda" naziv="Meda" cena="2000 RSD"></x-card-proizvod>
    </div>

</x-glavni-div>




<x-footer />
