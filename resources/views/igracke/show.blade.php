<x-nav>
    @if($igracka->naziv_i == 'žaba')
        <title>CuddleToys - Žaba</title>
    @else
        <title class="capitalize">CuddleToys - {{ ucfirst($igracka->naziv_i) }}</title>
    @endif
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="{{ route('igracke.index') }}" class="hover:underline"> Igračke</a>
        / <a href="igracke/{{$igracka->idIgracka}}" class="hover:underline capitalize"> {{ ucfirst($igracka->naziv_i) }} </a>
    </x-path>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Slajder -->
        <div class="relative mx-auto mt-10 mb-12 overflow-hidden">
            <div id="slider" class="flex transition-transform duration-700 ease-in-out">
                <!-- Prva slika se menja u skladu sa izborom korisnika -->
                @php
                    if($igracka->naziv_i == 'žaba'){
                        $igracka->naziv_i = 'zaba';
                    }
                    if($igracka->naziv_i == 'kornjača'){
                        $igracka->naziv_i = 'kornjaca';
                    }
                @endphp
                <img id="{{$igracka->naziv_i}}"
                     src="{{ asset('images/igracke/' . $igracka->naziv_i . '/' . $igracka->naziv_i . '-' . $defaultBojaVunice . '-' . $defaultBojaOciju . '.png') }}"
                     alt="{{ ucfirst($igracka->naziv_i) }}"
                     data-price="{{ $igracka->defaultKombinacija->cena_pravljenja ?? 0}}"
                     class="w-full h-62 object-cover rounded-md">
                <img src="{{ asset('images/igracke/' . $igracka->naziv_i . '/' . $igracka->naziv_i . '2.png') }}"
                     alt="{{ ucfirst($igracka->naziv_i) }}"
                     class="w-full h-62 object-cover rounded-md">
                <img src="{{ asset('images/igracke/' . $igracka->naziv_i . '/' . $igracka->naziv_i . '3.png') }}"
                     alt="{{ ucfirst($igracka->naziv_i) }}"
                     class="w-full h-62 object-cover rounded-md">
{{--                <x-slika putanja="images/igracke/zaba/zaba2.png" alt="{{ ucfirst($igracka->naziv_i) }}" h="56"></x-slika>--}}
{{--                <x-slika putanja="images/igracke/zaba/zaba3.png" alt="{{ ucfirst($igracka->naziv_i) }}" h="56"></x-slika>--}}
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
            if($igracka->naziv_i == 'zaba'){
                $igracka->naziv_i = 'žaba';
            }
            if($igracka->naziv_i == 'kornjaca'){
                $igracka->naziv_i = 'kornjača';
            }
        @endphp
        <div class="flex flex-col justify-start mt-14">
            <h2 class="text-2xl font-bold text-purple mb-10 capitalize">{{ ucfirst($igracka->naziv_i) }}</h2>
            <p class="text-gray-700 mb-20">{{ $igracka->opis_i }}</p>

            <div class="flex flex-row mb-12">
                <p class="text-2xl font-bold text-dark-pink"
                   id="cena-igracke">
                    {{ sprintf('%.2f', ($igracka->defaultKombinacija->cena_pravljenja + $igracka->defaultBoje->bojaVunice->defaultKombinacija->cena_m + $igracka->defaultBoje->bojaOciju->defaultKombinacija->cena_m)) }} RSD
                </p>

                <div class="ml-auto mr-7">
                    <input type="number" min="1" value="1" class="mr-4 w-14 h-10 text-lg text-center border border-gray-300 rounded">
                    <x-button type="submit" class="px-6 py-3 mb-4">Dodaj u korpu</x-button>
                </div>
            </div>

            <!-- Opcije za prilagođavanje -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-11">
                <!-- Boja vunice -->
                <div>
                    <label for="boja_vunice" class="block text-dark-pink font-semibold mb-2">Boja vunice</label>
                    <x-select id="boja_vunice" name="boja_vunice" onchange="updateImage()">
                        @foreach($bojeVunice as $boja)
                            <option value="{{ ($boja->boja->naziv_b) }}"
                                    class="capitalize"
                                    data-price="{{ $igracka->defaultBoje->bojaVunice->defaultKombinacija->cena_m ?? 0}}">
                                {{ ucfirst($boja->boja->naziv_b) }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
                <!-- Boja očiju -->
                <div>
                    <label for="boja_ociju" class="block text-dark-pink font-semibold mb-2">Boja očiju</label>
                    <x-select id="boja_ociju" name="boja_ociju" onchange="updateImage()">
                        @foreach($bojeOciju as $boja)
                            <option value="{{ ($boja->boja->naziv_b) }}"
                                    class="capitalize"
                                    data-price="{{ $igracka->defaultBoje->bojaOciju->defaultKombinacija->cena_m ?? 0}}">
                                {{ ucfirst($boja->boja->naziv_b) }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
                <!-- Dimenzije -->
                <div>
                    <label for="dimenzije" class="block text-dark-pink font-semibold mb-2">Dimenzije</label>
                    <x-select id="dimenzije" name="dimenzije" onchange="updatePrice()">
                        @foreach($dimenzije as $dimenzija)
                            <option
                                value="{{ $dimenzija['idDimenzije'] }}"
                                data-price="{{ $dimenzija['cena_pravljenja'] ?? 0 }}">
                                {{ $dimenzija['naziv_d'] }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <p class="mt-8 text-blue">Imaš posebne zahteve za pravljenje igračke? <a href="/kontakt" class="text-hot-pink underline">Piši nam</a>.</p>
        </div>
    </div>
</x-glavni-div>

<x-footer />

@verbatim
    <script>
        var prviSlajder = document.querySelector('#slider img:first-child');

        var vunica = document.getElementById('boja_vunice').selectedOptions[0];
        var cenaVunice = parseFloat(vunica.getAttribute('data-price')) || 0;

        var oci = document.getElementById('boja_ociju').selectedOptions[0];
        var cenaOciju = parseFloat(oci.getAttribute('data-price')) || 0;


        function updateImage() {
            var bojaVunice = document.getElementById('boja_vunice').value.toLowerCase();
            var bojaOciju = document.getElementById('boja_ociju').value.toLowerCase();

            var igrackaNaziv = prviSlajder.id.toLowerCase();

            //console.log(igrackaNaziv);

            if(igrackaNaziv === 'žaba'){
                igrackaNaziv = 'zaba'; //u putanji osisana latinica
            }
            if(bojaVunice === 'žuta'){
                bojaVunice = 'zuta';
            }

            // Formiranje putanje slike
            var novaPutanja = "/images/igracke/" + igrackaNaziv + "/" + igrackaNaziv + "-" + bojaVunice + "-" + bojaOciju + ".png";

            prviSlajder.src = novaPutanja;

            //console.log("Updated image path: ", novaPutanja);
        }

        function updatePrice() {
            var selectDimenzija = document.getElementById('dimenzije');
            var dimenzija = selectDimenzija.options[selectDimenzija.selectedIndex];
            var cenaDimenzije = parseFloat(dimenzija.getAttribute('data-price')) || 0; //cena pravljenja

            //console.log(cenaDimenzije);

            // Izračunaj ukupnu cenu
            var totalCena = cenaOciju + cenaVunice + cenaDimenzije;

            document.getElementById('cena-igracke').innerText = totalCena.toFixed(2) + ' RSD';
        }
    </script>
@endverbatim
