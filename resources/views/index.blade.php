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
        <x-card-proizvod putanja="images/igracke/zaba/zaba1.png" href="igracka" alt="Žaba" naziv="Žaba" cena="2000 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/igracke/slon/slon1.png" href="igracka" alt="Slon" naziv="Slon" cena="2000 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/igracke/patka/patka1.png" href="igracka" alt="Patka" naziv="Patka" cena="2000 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/igracke/meda/meda1.png" href="igracka" alt="Meda" naziv="Meda" cena="2000 RSD"></x-card-proizvod>
    </div>

    <!-- Najpopularniji materijali -->
    <x-title>Naši najpopularniji materijali</x-title>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
        <x-card-proizvod putanja="images/materijali/heklica/heklica3mm.jpg" alt="Heklica" href="materijal" naziv="Heklica 3-12mm" cena="200 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/vunica/vunica-zuta.jpg" alt="Vunica" href="materijal" naziv="Vunica" cena="400 RSD (po metru)"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/punjenje/punjenje300g.jpg" alt="Punjenje" href="materijal" naziv="Punjenje 300g" cena="700 RSD"></x-card-proizvod>
        <x-card-proizvod putanja="images/materijali/makaze/makaze.jpg" alt="Makaze" href="materijal" naziv="Makaze" cena="500 RSD"></x-card-proizvod>
    </div>
</x-glavni-div>

<x-footer />
