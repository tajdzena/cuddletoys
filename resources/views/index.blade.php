<x-nav>
    <title>CuddleToys</title>
</x-nav>

<x-glavni-div>

    <x-title>Dobro došli u CuddleToys - carstvo popločano vunicom i heklicama!</x-title>

    <!-- Slajder sekcija -->
    <div class="relative w-full max-w-7xl mx-auto mt-12 mb-12 overflow-hidden">
        <div id="slider" class="flex transition-transform duration-700 ease-in-out">

{{--            <div class="min-w-full">--}}
{{--                <img src="{{ asset('images/slicica.jpg') }}" alt="slicica" class="w-full h-64 object-cover rounded-md">--}}
{{--            </div>--}}

            <x-slider-slika putanja="images/baneri/baner1.png" alt="Povratak u školu"></x-slider-slika>
            <x-slider-slika putanja="images/baneri/baner2.png" alt="Akcija za apsolvente"></x-slider-slika>
            <x-slider-slika putanja="images/baneri/baner3.png" alt="CuddleToys ponuda"></x-slider-slika>
        </div>

        <!-- Navigacija slajdera -->
        <button id="prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 px-4 py-2 text-white bg-dark-pink hover:bg-pink rounded-full">
            &larr;
        </button>
        <button id="next" class="absolute right-0 top-1/2 transform -translate-y-1/2 px-4 py-2 text-white bg-dark-pink hover:bg-pink rounded-full">
            &rarr;
        </button>
    </div>

    <!-- Najpopularnije igračke -->
    <x-title>Naše najpopularnije igračke</x-title>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12 mb-12">
{{--        <x-card-proizvod putanja="images/igracke/zaba/zaba-zelena-crna.png" href="igracka" alt="Žaba" naziv="Žaba" cena="2000 RSD"></x-card-proizvod>--}}
        @foreach($najnovijeIgracke as $igracka)
            <x-card-proizvod
                :putanja="isset($igracka->defaultBoje->slika) ? $igracka->defaultBoje->slika->putanja : 'images/no-image.jpg'"
                href="igracke/{{$igracka->idIgracka}}"
                :alt="ucfirst($igracka->naziv_i)"
                :naziv="ucfirst($igracka->naziv_i)"
                :cena="isset($igracka->ukupnaCena) ? ('Od ' . sprintf('%.2f', $igracka->ukupnaCena) . ' RSD') : '/ RSD'">
            </x-card-proizvod>
        @endforeach
    </div>

    <!-- Najpopularniji materijali -->
    <x-title>Naši najpopularniji materijali</x-title>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
{{--        <x-card-proizvod putanja="images/materijali/heklica/heklica3mm.jpg" alt="Heklica" href="materijal" naziv="Heklica 3-12mm" cena="200 RSD"></x-card-proizvod>--}}
        @foreach($najnovijiMaterijali as $materijal)
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
