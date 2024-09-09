<x-nav>
    <title>CuddleToys - Korpa</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/korpa" class="hover:underline"> Korpa</a>
    </x-path>

    <x-title>Korpa</x-title>

    <div class="flex flex-col md:flex-row gap-6 mt-10">
        <!-- Tabela sa proizvodima u korpi -->
        <div class="w-full md:w-3/4 bg-brighter-peach rounded-lg shadow-lg p-6">
            <table class="min-w-full leading-normal">
                <thead>
                @if($stavkeKorpe->isEmpty())
                    <tr>
                        <td colspan="5" class="pt-12 text-xl font-bold text-center">Tvoja korpa je prazna.</td>
                    </tr>
                @else
                    <tr>
                        <th class="px-4 py-2 text-left text-dark-pink">Proizvod</th>
                        <th class="px-4 py-2 text-center text-dark-pink">Količina</th>
                        <th class="px-4 py-2 text-center text-dark-pink">Način pravljenja</th>
                        <th class="px-4 py-2 text-center text-dark-pink">Cena</th>
                        <th class="px-4 py-2 text-center text-dark-pink"></th>
                    </tr>
                @endif
                </thead>
                <tbody>

                <!-- Uključi komponentu za svaki red proizvoda -->
                @foreach($stavkeKorpe as $stavka)
                    @php
                        // Postavite podrazumevanu vrednost za $slika
                        $slika = '/images/no-image.jpg';
                    @endphp

                    @if($stavka->igracka)
                        @php
                            //cena
                            $cenaVunice = $stavka->igracka->boje->bojaVunice->kombinacije->first()->cena_m ?? 0;
                            $cenaOciju = $stavka->igracka->boje->bojaOciju->kombinacije->first()->cena_m ?? 0;
                            $cenaPravljenja = $stavka->igracka->cena_pravljenja ?? 0;
                            $cenaStavke = $cenaPravljenja + $cenaVunice + $cenaOciju;

                            // Formiraj putanju slike za igračku na osnovu boje vunice, boje očiju i vrste igračke
                            $igrackaNaziv = strtolower($stavka->igracka->boje->igracka->naziv_i) ?? '';

                            $bojaVunice = strtolower($stavka->igracka->boje->bojaVunice->boja->naziv_b);
                            $bojaOciju = strtolower($stavka->igracka->boje->bojaOciju->boja->naziv_b);

                            // Ako su neka slova specifična kao što je žaba ili žuta, osisaj latinicu
                            if ($igrackaNaziv === 'žaba') {
                                $igrackaNaziv = 'zaba';
                            }
                            if ($bojaVunice === 'žuta') {
                                $bojaVunice = 'zuta';
                            }

                            // Formiraj putanju slike za igračku
                            $slika = "/images/igracke/$igrackaNaziv/$igrackaNaziv-$bojaVunice-$bojaOciju.png";

                            //sta cu kad je poseban karakter
                            if ($igrackaNaziv === 'zaba') {
                                $igrackaNaziv = 'Žaba';
                            }
                            if ($bojaVunice === 'zuta') {
                                $bojaVunice = 'žuta';
                            }

                        @endphp
                    @elseif($stavka->materijal)
                        @php
                            $cenaStavke = $stavka->materijal->cena_m ?? 0;

                            // Formiraj putanju slike za materijal na osnovu kombinacije materijala, boje i dimenzije
                            $materijalNaziv = strtolower(optional($stavka->materijal)->naziv_m ?? '');
                            $bojaMaterijala = strtolower($stavka->materijal->boja_m);
                            $dimenzijeMaterijala = strtolower($stavka->materijal->dimenzije);

                            if ($bojaMaterijala === 'žuta') {
                                $bojaMaterijala = 'zuta';
                            }

                            // Formiraj putanju slike za materijal
                            $slika = "/images/materijali/$materijalNaziv/$materijalNaziv-$bojaMaterijala-$dimenzijeMaterijala.jpg";
                        @endphp
                    @endif

                    <x-korpa-proizvod
                        :image="$slika"
                        :vrsta="isset($stavka->igracka) ? 'igracka' : 'materijal'"
                        :naziv="isset($stavka->igracka) ? ucfirst($igrackaNaziv) : ucfirst($materijalNaziv)"
                        :boja_vunice="isset($stavka->igracka) ? $bojaVunice : ''"
                        :boja_ociju="isset($stavka->igracka) ? $bojaOciju : ''"
                        :boja_mat="isset($stavka->materijal) ? $stavka->materijal->boja_m : ''"
                        :dimenzije="isset($stavka->igracka) ? $stavka->igracka->dimenzija->naziv_d : $stavka->materijal->dimenzija->naziv_d"
                        :cena="isset($stavka->igracka) ?
                                    $cenaStavke * ($stavka->igracka->stavkaKorpe->first()->kolicina_s) :
                                    $cenaStavke * ($stavka->materijal->stavkaKorpe->first()->kolicina_s)"
{{--    1. PRoveri da li je IdIgrKomb == NULL, AKO NIJE, to znaci da je igracka i iz igracka_kombinacija.cena_pravljenja + cena za materijale
                                                                                                                        (vunica i oci, matKomb)
        2. Ako JESTE NULL, to znaci da je u pitanju materijal, i treba iz tabele materijal_kombinacija da dohvatis cena_m--}}
                        :kolicina="isset($stavka->igracka) ?
                                    $stavka->igracka->stavkaKorpe->first()->kolicina_s :
                                    $stavka->materijal->stavkaKorpe->first()->kolicina_s"
                        :stavka="$stavka"
                    />
                @endforeach

{{--                <x-korpa-proizvod image="/images/igracke/zaba/zaba-zelena-plava.png" vrsta="igracka" naziv="Žaba" boja_vunice="zelena" boja_ociju="plava" dimenzije="15x30x30" cena="900" kolicina="1" />--}}
{{--                <x-korpa-proizvod image="/images/materijali/heklica/heklica-5mm-zuta.jpg" vrsta="materijal" naziv="Heklica" boja_mat="žuta" cena="900" dimenzije="5mm" kolicina="1" />--}}
{{--                <x-korpa-proizvod image="/images/igracke/zaba/zaba-zelena-plava.png" vrsta="igracka" naziv="Žaba" boja_vunice="zelena" boja_ociju="plava" dimenzije="30x60x60" cena="900" kolicina="1" />--}}

                </tbody>
            </table>

            <!-- Ukupna cena i dugme za nastavak -->
            <div class="flex justify-between items-center mt-6">
                @if($stavkeKorpe->isEmpty())
                @else
                    <p class="text-lg font-semibold text-dark-pink">Ukupno: <span class="font-bold" id="ukupna-cena">{{ sprintf('%.2f', $ukupnaCena) }} RSD</span></p>

                    <form action="{{ route('porudzbina') }}" method="POST">
                        @csrf
                        @foreach($stavkeKorpe as $stavka)
                            <input class="hidden" name="idStavka[]" value="{{ $stavka->idStavka }}">
                            <input class="hidden" type="number" name="kolicina[]" value="{{ $stavka->kolicina_s }}">
                            <select class="hidden" name="nacin_pravljenja[]">
                                <option class="hidden" value="gotova" {{ $stavka->nacin_pravljenja == 'gotova' ? 'selected' : '' }}>Gotova igračka</option>
                                <option class="hidden" value="samostalno" {{ $stavka->nacin_pravljenja == 'samostalno' ? 'selected' : '' }}>Samostalno</option>
                            </select>
                        @endforeach
                        <input class="hidden" name="popust" value="0.7">
                        <x-button type="submit" class="px-6 py-3">Nastavi sa plaćanjem</x-button>
                    </form>
{{--                    <a href="/porudzbina"><x-button type="submit" class="px-6 py-3">Nastavi sa plaćanjem</x-button></a>--}}
                @endif
            </div>
        </div>

        <!-- Kartica za unos kupona -->
        <div class="bg-brighter-peach rounded-lg shadow-lg p-6 h-48">
            <x-label-input for="kupon-kod" text="Imaš kupon kod?" type="text" id="kupon-kod" name="kupon-kod" placeholder="%" isRequired="no"></x-label-input>
            <x-button type="submit" class="w-full px-4 py-2" onclick="popustCena()">Primeni</x-button>

        </div>
    </div>
</x-glavni-div>

<x-footer />

@verbatim
    <script>
        // Funkcija za ažuriranje ukupne cene u korpi
        function updateUkupnaCena() {
            let ukupnaCena = 0;

            // Prođi kroz sve stavke i saberi cene
            $('.stavka-cena').each(function() {
                let stavkaCena = parseFloat($(this).text().replace(' RSD', '')) || 0;
                ukupnaCena += stavkaCena;
            });

            // Ažuriraj ukupnu cenu
            $('#ukupna-cena').text(ukupnaCena.toFixed(2) + ' RSD');
        }

        function updateCena(stavkaId) {
            // Pronađi red za stavku koristeći ID
            let row = document.getElementById('stavka-' + stavkaId);
            let select = document.getElementById('nacin_pravljenja-' + stavkaId);
            let selectedOption = select.value;

            // Dohvati cene materijala i pravljenja iz data atributa u redu
            let cenaPravljenja = parseFloat(row.getAttribute('data-cena-pravljenja'));
            let cenaVunice = parseFloat(row.getAttribute('data-cena-vunice'));
            let cenaOciju = parseFloat(row.getAttribute('data-cena-ociju'));

            let ukupnaCena = 0;

            if (selectedOption === 'samostalno') {
                // Ako je samostalno, izračunaj samo cenu materijala (vunica + oči)
                ukupnaCena = cenaVunice + cenaOciju;
            } else {
                // Ako je gotova, uračunaj i cenu pravljenja
                ukupnaCena = cenaPravljenja + cenaVunice + cenaOciju;
            }

            // Ažuriraj cenu stavke
            document.getElementById('stavka-cena-' + stavkaId).textContent = ukupnaCena.toFixed(2) + ' RSD';

            // Ažuriraj ukupnu cenu korpe
            updateUkupnaCena();
        }


        $(document).ready(function() {

            //Kad se promeni nacin pravljenja
            document.querySelectorAll('[id^="nacin_pravljenja-"]').forEach(function (select) {
                select.addEventListener('change', function () {
                    updateCena(select.id.split('-')[1]);
                });
            });

        });

        function popustCena(){
            var kupon = $('#kupon-kod').val();
            //console.log(kupon);

            var popust = 1; //0%

            if(kupon === 'CUDDLE30'){
                popust = 0.7; //30% popusta
            }

            let popustCena = parseFloat($('#ukupna-cena').text().replace(' RSD', '')) * popust || 0;

            // Ažuriraj ukupnu cenu
            $('#ukupna-cena').text(popustCena.toFixed(2) + ' RSD');
        }
    </script>
@endverbatim
