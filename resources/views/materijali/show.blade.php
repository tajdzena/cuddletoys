<x-nav>
    <title class="capitalize">CuddleToys - {{ ucfirst($materijal->naziv_m) }}</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="{{ route('materijali.index') }}" class="hover:underline"> Materijali</a>
        / <a href="materijali/{{$materijal->idMaterijal}}" class="hover:underline capitalize"> {{ ucfirst($materijal->naziv_m) }} </a>
    </x-path>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Slajder -->
        <div class="relative mx-auto mt-10 mb-12 overflow-hidden">
            <div id="slider" class="flex transition-transform duration-700 ease-in-out">
                <!-- Prva slika se menja u skladu sa izborom korisnika -->
                @php
                    if($materijal->naziv_m == 'oči'){
                        $materijal->naziv_m = 'oci';
                    }
                @endphp
                <img id="{{$materijal->idMaterijal}}"
                     src="{{ asset('images/materijali/' . $materijal->naziv_m . '/' . $materijal->naziv_m . '-' . $materijal->defaultKombinacija->dimenzija->naziv_d . '-' . $defaultBojaMaterijala . '.jpg') }}"
                     alt="{{ ($materijal->naziv_m) }}"
                     class="w-full h-62 object-cover rounded-md">
                <img id="{{$materijal->naziv_m}}"
                     src="{{ asset('images/materijali/' . $materijal->naziv_m . '/' . $materijal->naziv_m . '.jpg') }}"
                     alt="{{ ucfirst($materijal->naziv_m) }}"
                     class="w-full h-62 object-cover rounded-md">
            </div>

            <!-- Navigacija slajdera -->
            <button id="prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 px-4 py-2 text-white bg-dark-pink hover:bg-pink rounded-full">
                &larr;
            </button>
            <button id="next" class="absolute right-0 top-1/2 transform -translate-y-1/2 px-4 py-2 text-white bg-dark-pink hover:bg-pink rounded-full">
                &rarr;
            </button>
        </div>

        <!-- Detalji proizvoda -->
        @php
            if($materijal->naziv_m == 'oci'){
                $materijal->naziv_m = 'oči';
            }
        @endphp
        <div class="flex flex-col justify-start mt-14">
            <h2 class="text-2xl font-bold text-purple mb-10 capitalize">{{ ucfirst($materijal->naziv_m) }}</h2>
            <p class="text-gray-700 mb-20">{{ $materijal->opis_m }}</p>

            <div class="flex flex-row mb-12">
                <p class="text-2xl font-bold text-dark-pink" id="cena-materijala">
                    {{ sprintf('%.2f', ($materijal->defaultKombinacija->cena_m)) }} RSD
                </p>

                <div class="ml-auto mr-7">
                    <form action="{{ route('dodajUKorpu') }}" method="POST">
                        @csrf
                        <!-- Polje za idMatKomb koji dolazi iz kombinacije -->
                        <input type="hidden" name="idMatKomb" value="1">
                        <input type="number" name="kolicina" min="1" value="{{ old('kolicina', 1) }}" class="mr-4 w-14 h-10 text-lg text-center border border-gray-300 rounded">
                        <x-button type="submit" id="dodaj-u-korpu" class="px-6 py-3 mb-4">Dodaj u korpu</x-button>
                    </form>
                </div>
            </div>

            <!-- Opcije za prilagođavanje -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-11 mb-4">
                <!-- Boja materijala -->
                <div>
                    <label for="boja_materijala" class="block text-dark-pink font-semibold mb-2">Boja materijala</label>
                    <x-select id="boja_materijala" name="boja_materijala" onchange="updateImage()">
                        @foreach($bojeMaterijala as $boja)
                            <option
                                id="{{$boja->idBoja}}"
                                value="{{ ($boja->naziv_b) }}"
                                class="capitalize">
                                {{ ucfirst($boja->naziv_b) }}
                            </option>
                        @endforeach
                    </x-select>
                </div>

                <!-- Dimenzije materijala -->
                <div>
                    <label for="dimenzije" class="block text-dark-pink font-semibold mb-2">Dimenzije</label>
                    <x-select id="dimenzije" name="dimenzije" onchange="updateBoje(); updatePrice()">
                        @foreach($dimenzije as $dimenzija)
                            <option value="{{ $dimenzija['idDimenzije'] }}"
                                    data-price="{{ $dimenzija['cena_m'] ?? 0 }}"
                                    name="{{ $dimenzija['naziv_d'] }}">
                                {{ $dimenzija['naziv_d'] }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="flex flex-row justify-between">
                <p class="mt-28 text-blue">Imaš posebne zahteve za pravljenje materijala? <a href="/kontakt" class="text-hot-pink underline">Piši nam</a>.</p>

                @canany(['isAdmin', 'isModerator'], Auth::user())
                    <a href="{{ route('materijali.edit', ['id' => $materijal->idMaterijal]) }}">
                        <button class="mt-24 h-10 w-20 bg-pink text-dark-pink rounded ml-auto mr-8 hover:bg-pink/50">Izmeni</button>
                    </a>
                @endcanany
            </div>
        </div>
    </div>
</x-glavni-div>

<x-footer />

@verbatim
    <script>
        var prviSlajder = document.querySelector('#slider img:first-child');
        var selectDimenzija = document.getElementById('dimenzije');

        $(document).ready(function() {
            updateIdMatKomb();

            // Funkcija za ažuriranje idIgrKomb na osnovu izbora korisnika
            function updateIdMatKomb() {
                var idBoja = document.getElementById('boja_materijala').options[document.getElementById('boja_materijala').selectedIndex].id;
                var idDimenzije = selectDimenzija.options[selectDimenzija.selectedIndex].getAttribute('value');
                var idMaterijal = prviSlajder.id;

                console.log(idBoja);
                console.log(idDimenzije);
                console.log(idMaterijal);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Napravi AJAX poziv na backend da dobiješ odgovarajući idIgrKomb
                $.ajax({
                    url: '/get-materijal-kombinacija', // Ruta za backend funkciju
                    method: 'POST',
                    data: {
                        idMaterijal: idMaterijal,
                        idBoja: idBoja,
                        idDimenzije: idDimenzije
                    },
                    success: function (response) {
                        // Ažuriraj hidden input polje za idIgrKomb
                        console.log('Response:', response);
                        console.log(response.idMatKomb);
                        document.querySelector('input[name="idMatKomb"]').value = response.idMatKomb;
                    },
                    error: function (xhr, status, error) {
                        console.log('Greška prilikom povlačenja kombinacije:', error);
                    }
                });


                // // Kada korisnik promeni boju ili dimenzije, ponovo pokreni AJAX poziv
                // $('#boja_materijala, #dimenzije').on('change', function () {
                //     updateIdMatKomb();
                // });
            }

            // Ažuriraj boje kada se promeni dimenzija, a zatim ažuriraj ID kombinacije
            function updateBoje() {
                var idDimenzije = document.getElementById('dimenzije').value;

                fetch(`/materijal-boje/${idDimenzije}`)
                    .then(response => response.json())
                    .then(data => {
                        var selectBoja = document.getElementById('boja_materijala');
                        selectBoja.innerHTML = ''; // Očisti trenutne boje

                        if (data.boje.length > 0) {
                            data.boje.forEach(boja => {
                                var option = document.createElement('option');
                                option.value = boja.naziv_b;
                                option.id = boja.idBoja;  // Dodaj ID boje
                                option.text = boja.naziv_b.charAt(0).toUpperCase() + boja.naziv_b.slice(1);
                                selectBoja.appendChild(option);
                            });

                            // Postavi prvu boju kao default nakon promene dimenzije
                            selectBoja.selectedIndex = 0;

                            // Ažuriraj sliku koristeći prvu boju iz novog seta boja
                            updateImage();

                            // Nakon što su boje ažurirane, pozovi funkciju za ažuriranje kombinacije
                            updateIdMatKomb();
                        }
                    })
                    .catch(error => console.error('Greška prilikom osvežavanja boja:', error));
            }


            // Kada korisnik promeni dimenziju, prvo osveži boje, a zatim ažuriraj kombinaciju
            $('#dimenzije').on('change', function () {
                updateBoje();
                updatePrice();
            });

            // Kada korisnik promeni boju, odmah ažuriraj kombinaciju
            $('#boja_materijala').on('change', function () {
                updateIdMatKomb();
            });


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
                    .addClass('popup-message bg-green/30 text-green py-2 px-4 rounded shadow-md')
                    .text(message)
                    .hide()
                    .appendTo('body');

                // Prikaži poruku
                popup.fadeIn(200).delay(3000).fadeOut(400, function() {
                    $(this).remove(); // Ukloni poruku nakon što se ugasi
                });
            }

        })

        function updateImage() {
            var bojaMaterijala = document.getElementById('boja_materijala').value.toLowerCase();
            var materijalNaziv = prviSlajder.alt.toLowerCase();

            var selectDimenzija = document.getElementById('dimenzije').selectedOptions[0];
            var dimenzijaNaziv = selectDimenzija.getAttribute('name').toLowerCase();
            //console.log(dimenzijaNaziv);

            if(bojaMaterijala === 'žuta'){
                bojaMaterijala = 'zuta';
            }

            // Formiranje putanje slike
            var novaPutanja = "/images/materijali/" + materijalNaziv + "/" + materijalNaziv + "-" + dimenzijaNaziv + "-" + bojaMaterijala + ".jpg";
            //console.log(novaPutanja);
            document.querySelector('#slider img:first-child').src = novaPutanja;
        }

        function updatePrice() {
            var selectDimenzija = document.getElementById('dimenzije');
            var dimenzija = selectDimenzija.options[selectDimenzija.selectedIndex];
            var cenaDimenzije = parseFloat(dimenzija.getAttribute('data-price')) || 0;

            document.getElementById('cena-materijala').innerText = cenaDimenzije.toFixed(2) + ' RSD';
        }
    </script>
@endverbatim
