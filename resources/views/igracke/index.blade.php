<x-nav>
    <title>CuddleToys - Igračke</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/igracke" class="hover:underline"> Igračke</a>
    </x-path>

    <x-title>Prikaz svih igračaka</x-title>

    <div class="flex flex-col md:flex-row md:justify-between mb-6">
        <!-- Sortiranje -->
        <form action="{{ route('igracke.index') }}" method="GET">
            <!-- forma da bi ostala selectovana vrednost -->
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
        @foreach($igracke as $igracka)
            <x-card-proizvod
                :putanja="isset($igracka->defaultBoje->slika) ? $igracka->defaultBoje->slika->putanja : 'images/no-image.jpg'"
                href="igracke/{{$igracka->idIgracka}}"
                :alt="ucfirst($igracka->naziv_i)"
                :naziv="ucfirst($igracka->naziv_i)"
                :cena="isset($igracka->ukupnaCena) ? ('Od ' . sprintf('%.2f', $igracka->ukupnaCena) . ' RSD') : '/ RSD'">
{{--                :cena="isset($ukupnaCena) ? ('Od ' . $ukupnaCena . ' RSD') : '/ RSD'">--}}
                <form class="add-to-cart-form" method="POST" action="{{ route('dodajUKorpu') }}">
                    @csrf
                    <input type="hidden" name="idIgrKomb" value="{{ $igracka->defaultKombinacija->idIgrKomb }}">
                    <input type="hidden" name="kolicina" value="1">
                    <x-button type="submit" class="mt-4 px-4 py-2">Dodaj u korpu</x-button>
                </form>
            </x-card-proizvod>
        @endforeach
    </div>


    <!-- Linkovi za paginaciju -->
    <div class="mt-6">
        {{ $igracke->appends(['sort' => $selectedSort])->links('pagination::simple-tailwind') }}
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
