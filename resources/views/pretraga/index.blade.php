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
        <form action="{{ route('pretraga.index') }}" method="GET">
            <!-- Pretraga input -->
            <x-label-input
                for="pretraga"
                text="Pretraži proizvode: "
                type="text"
                id="pretraga"
                name="search"
                placeholder="npr. žaba..."
                :isRequired="'no'"
                value="{{ request('search') }}"
            ></x-label-input>

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
{{--        <x-card-proizvod putanja="images/igracke/zaba/zaba-zelena-crna.png" href="igracka" alt="Žaba" naziv="Žaba" cena="2000 RSD"></x-card-proizvod>--}}
        @foreach($results as $product)
            @if($product instanceof \App\Models\Igracka)
                <!-- Prikaz igracke -->
                <x-card-proizvod
                    :putanja="isset($product->defaultBoje->slika) ? $product->defaultBoje->slika->putanja : 'images/no-image.jpg'"
                    href="igracke/{{$product->idIgracka}}"
                    :alt="ucfirst($product->naziv_i)"
                    :naziv="ucfirst($product->naziv_i)"
                    :cena="isset($product->ukupnaCena) ? ('Od ' . sprintf('%.2f', $product->ukupnaCena) . ' RSD') : '/ RSD'">
                </x-card-proizvod>
            @elseif($product instanceof \App\Models\Materijal)
                <!-- Prikaz materijala -->
                <x-card-proizvod
                    :putanja="isset($product->defaultKombinacija->slika) ? $product->defaultKombinacija->slika->putanja : 'images/no-image.jpg'"
                    href="materijali/{{$product->idMaterijal}}"
                    :alt="ucfirst($product->naziv_m)"
                    :naziv="ucfirst($product->naziv_m)"
                    :cena="isset($product->defaultKombinacija->cena_m) ? ('Od ' . sprintf('%.2f', $product->defaultKombinacija->cena_m) . ' RSD') : '/ RSD'">
                </x-card-proizvod>
            @endif
        @endforeach
    </div>

    <!-- Navigacija za paginaciju -->
    <div class="mt-6">
        {{ $results->appends(['sort' => $selectedSort, 'search' => $searchTerm])->links('pagination::simple-tailwind') }}
    </div>

</x-glavni-div>

<x-footer />
