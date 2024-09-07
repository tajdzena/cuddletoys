<x-nav>
    <title>CuddleToys - Materijali</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/materijali" class="hover:underline"> Materijali</a>
    </x-path>

    <x-title>Prikaz svih materijala</x-title>

    <div class="flex flex-col md:flex-row md:justify-between mb-6">
        <form action="{{ route('materijali.index') }}" method="GET">
            <!-- Sortiranje -->
            <div>
                <label for="sort" class="block text-dark-pink font-semibold mb-2">Sortiraj po:</label>
                <x-select id="sort" name="sort" onchange="this.form.submit()">
                    <x-option value="" isDisabled="yes" isSelected="{{ $selectedSort == '' ? 'yes' : '' }}">Izaberi sortiranje</x-option>
                    <x-option value="1" isSelected="{{ $selectedSort == '1' ? 'yes' : '' }}">Cena (rastuće)</x-option>
                    <x-option value="2" isSelected="{{ $selectedSort == '2' ? 'yes' : '' }}">Cena (opadajuće)</x-option>
                    <x-option value="3" isSelected="{{ $selectedSort == '3' ? 'yes' : '' }}">Naziv (A-Š)</x-option>
                    <x-option value="4" isSelected="{{ $selectedSort == '4' ? 'yes' : '' }}">Naziv (Š-A)</x-option>
                    <x-option value="5" isSelected="{{ $selectedSort == '5' ? 'yes' : '' }}">Najnoviji</x-option>
                </x-select>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Primer proizvoda -->
{{--        <x-card-proizvod putanja="images/materijali/heklica/heklica3mm.jpg" alt="Heklica" href="materijal" naziv="Heklica 3-12mm" cena="200 RSD"></x-card-proizvod>--}}
        @foreach($materijali as $materijal)
            <x-card-proizvod
                :putanja="isset($materijal->defaultKombinacija->slika) ? $materijal->defaultKombinacija->slika->putanja : 'images/no-image.jpg'"
                href="materijali/{{$materijal->idMaterijal}}"
                :alt="ucfirst($materijal->naziv_m)"
                :naziv="ucfirst($materijal->naziv_m)"
                :cena="isset($materijal->defaultKombinacija->cena_m) ? ('Od ' . sprintf('%.2f', $materijal->defaultKombinacija->cena_m) . ' RSD') : '/ RSD'">
            </x-card-proizvod>
        @endforeach
    </div>
</x-glavni-div>

<x-footer />
