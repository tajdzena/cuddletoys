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
