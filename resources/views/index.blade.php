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

    <x-title>Naše najnovije igračke</x-title>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12 mb-12">
{{--        <x-card-proizvod putanja="images/igracke/zaba/zaba-zelena-crna.png" href="igracka" alt="Žaba" naziv="Žaba" cena="2000 RSD"></x-card-proizvod>--}}
        @foreach($najnovijeIgracke as $igracka)
            <x-card-proizvod
                :putanja="isset($igracka->defaultBoje->slika) ? $igracka->defaultBoje->slika->putanja : 'images/no-image.jpg'"
                href="igracke/{{$igracka->idIgracka}}"
                :alt="ucfirst($igracka->naziv_i)"
                :naziv="ucfirst($igracka->naziv_i)"
                :cena="isset($igracka->ukupnaCena) ? ('Od ' . sprintf('%.2f', $igracka->ukupnaCena) . ' RSD') : '/ RSD'">
                <form class="add-to-cart-form" method="POST" action="{{ route('dodajUKorpu') }}">
                    @csrf
                    <input type="hidden" name="idIgrKomb" value="{{ $igracka->defaultKombinacija->idIgrKomb }}">
                    <input type="hidden" name="kolicina" value="1">
                    <x-button type="submit" class="mt-4 px-4 py-2">Dodaj u korpu</x-button>
                </form>
            </x-card-proizvod>
        @endforeach
    </div>

    <x-title>Naši najnoviji materijali</x-title>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
{{--        <x-card-proizvod putanja="images/materijali/heklica/heklica3mm.jpg" alt="Heklica" href="materijal" naziv="Heklica 3-12mm" cena="200 RSD"></x-card-proizvod>--}}
        @foreach($najnovijiMaterijali as $materijal)
            <x-card-proizvod
                :putanja="isset($materijal->defaultKombinacija->slika) ? $materijal->defaultKombinacija->slika->putanja : 'images/no-image.jpg'"
                href="materijali/{{$materijal->idMaterijal}}"
                :alt="ucfirst($materijal->naziv_m)"
                :naziv="ucfirst($materijal->naziv_m)"
                :cena="isset($materijal->defaultKombinacija->cena_m) ? ('Od ' . sprintf('%.2f', $materijal->defaultKombinacija->cena_m) . ' RSD') : '/ RSD'">
                <!-- Forma za dodavanje u korpu -->
                <form class="add-to-cart-form" method="POST" action="{{ route('dodajUKorpu') }}">
                    @csrf
                    <input type="hidden" name="idMatKomb" value="{{ $materijal->defaultKombinacija->idMatKomb }}">
                    <input type="hidden" name="kolicina" value="1">
                    <x-button type="submit" class="mt-4 px-4 py-2">Dodaj u korpu</x-button>
                </form>
            </x-card-proizvod>
        @endforeach
    </div>
</x-glavni-div>

<x-footer />


<script>
    $(document).ready(function () {
        // Kada korisnik pošalje formu za dodavanje u korpu
        $('form').on('submit', function(event) {
            event.preventDefault(); // Spreči da se stranica osveži

            let formData = $(this).serialize(); // Uzmi podatke iz forme

            $.ajax({
                url: $(this).attr('action'), // URL iz action atributa forme
                method: $(this).attr('method'), // Metoda iz method atributa
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Prikaži poruku o uspešnom dodavanju
                        showPopupMessage(response.message);
                    }
                },
                error: function() {
                    showPopupMessage('Došlo je do greške pri dodavanju proizvoda u korpu.');
                }
            });
        });

        // Funkcija za prikazivanje pop-up poruke
        function showPopupMessage(message) {
            // Kreiraj element za prikazivanje poruke
            let popup = $('<div></div>')
                .addClass('popup-message bg-yellow/80 text-green py-2 px-4 rounded shadow-md')
                .text(message)
                .hide()
                .appendTo('body');

            // Prikaži poruku
            popup.fadeIn(200).delay(3000).fadeOut(400, function() {
                $(this).remove(); // Ukloni poruku nakon što se ugasi
            });
        }
    });
</script>
