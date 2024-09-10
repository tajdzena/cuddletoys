<!-- Sekcija za statistiku -->
@can('isAdmin', Auth::user())
    <div id="statistika" class="section hidden">
        <h2 class="text-2xl text-center font-bold text-dark-pink -mt-12 mb-4">Statistika</h2>
        <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
            <div class="flex flex-row items-center justify-center mb-4 gap-12">
                <div class="text-center">
                    <label for="mesec" class="block text-dark-pink font-semibold mb-2">Mesec: </label>
                    <x-select id="mesec" name="mesec" class="text-center">
                        <x-option value="" isDisabled="yes">Izaberi mesec</x-option>
{{--                        <x-option value="avgust">Avgust</x-option>--}}

                    </x-select>
                </div>
                <div class="text-center">
                    <label for="godina" class="block text-dark-pink font-semibold mb-2">Godina: </label>
                    <x-select id="godina" name="godina" class="text-center">
                        <x-option value="" isDisabled="yes">Izaberi godinu</x-option>
{{--                        <x-option value="2024">2024</x-option>--}}

                    </x-select>
                </div>
            </div>
            <p class="text-lg text-dark-pink font-semibold mt-6">
                Statistika za <span id="selected-month" class="font-bold"> mesec </span>
                <span id="selected-year" class="font-bold"> - godinu</span></p>
            <p class="text-md text-gray-700 mt-2">
                Ukupan broj prodaja: <span id="total-sales" class="font-bold"> ... </span> (<span id="total-revenue"> ... RSD </span>)</p>


            <div class="mt-8 flex flex-row gap-4">
                <label for="proizvod_prodaja" class="mt-2 block text-dark-pink font-semibold mb-2">Broj prodaja po proizvodu: </label>
                <x-select id="proizvod_prodaja" name="proizvod_prodaja" class="text-center">
                    <x-option value="" isDisabled="yes">Izaberi proizvod</x-option>
{{--                    <x-option value="zabica">zabica</x-option>--}}
                    <!-- Dodaj još opcija po potrebi -->
                </x-select>
                <!-- u js odraditi kad kliknem na proizvod da se ispise broj prodaja -->
            </div>


            <!-- Grafikon -->
            <div class="mt-12">
                <canvas id="zaradaGrafikon" class="w-full"></canvas>
            </div>
        </div>
    </div>
@endcan


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('zaradaGrafikon').getContext('2d');
        const zaradaGrafikon = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'],
                datasets: [{
                    label: 'Ukupna zarada po mesecu (RSD)',
                    data: [], // Ovaj deo će se ažurirati
                    backgroundColor: 'rgba(254,206,124,0.4',
                    borderColor: 'rgb(254,206,124)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: godina,
                        color: '#b2247e',
                        position: 'top',
                        font: {
                            family: 'Mulish',
                            size: 20,
                            style: 'normal',
                            weight: 'bold',
                            lineHeight: 1.2,
                        },
                    },
                    legend: {
                        labels: {
                            font: {
                                family: 'Mulish',
                                size: 12,
                                style: 'normal',
                                weight: 'bold',
                                lineHeight: 2,
                            },
                        },
                    },
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Kada se stranica učita, pozovi funkciju za punjenje meseci i godina
        loadMeseciGodine();

        zaradaGrafikon.options.plugins.title.text = "Godina";

        function loadMeseciGodine() {
            $.ajax({
                url: '/nalog/get-meseci-godine',  // Ruta ka kontroleru
                method: 'GET',
                success: function (response) {
                    let meseci = [
                        'Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'
                    ];

                    let mesecSelect = $('#mesec');
                    let godinaSelect = $('#godina');

                    // mesecSelect.empty();
                    // godinaSelect.empty();
                    //
                    // mesecSelect.append('<option value="" disabled selected>Izaberi mesec</option>');
                    // godinaSelect.append('<option value="" disabled selected>Izaberi godinu</option>');

                    // Napuni select menije za mesece i godine
                    response.forEach(function (item) {
                        // Dodaj mesec u select meni ako nije već dodat
                        mesecSelect.append('<option value="' + item.mesec + '">' + meseci[item.mesec - 1] + '</option>');
                        // Dodaj godinu u select meni ako nije već dodat
                        if (godinaSelect.find('option[value="' + item.godina + '"]').length === 0) {
                            godinaSelect.append('<option value="' + item.godina + '">' + item.godina + '</option>');
                        }
                    });
                }
            });
        }


        $('#mesec, #godina').change(function() {
            let mesec = $('#mesec').val(); //9
            let godina = $('#godina').val(); //2024
            //console.log(mesec, godina);

            if (mesec && godina) {
                updateStatistika(mesec, godina);

                //console.log(mesec, godina);

                $('#selected-month').text(mesec + '.');
                $('#selected-year').text(godina + '.');

                // Ažuriraj naslov grafikona
                zaradaGrafikon.options.plugins.title.text = godina;
                zaradaGrafikon.update();  // Ažuriraj grafikon da primeni promene
            }
        });

        function updateStatistika(mesec, godina) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/nalog/statistika', // ruta ka kontroleru
                method: 'POST',
                data: {
                    mesec: mesec,
                    godina: godina,
                },
                success: function(response) {
                    // Ažuriraj broj prodaja i zaradu
                    //console.log(response.ukupanBrojProdaja, response.ukupnaZarada, response.zaradaPoMesecu);
                    // Mape za mesece
                    const meseciNazivi = ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'];

                    $('#total-sales').text(response.ukupanBrojProdajaMesec);
                    $('#total-revenue').text(response.ukupnaZaradaMesec.toFixed(2) + ' RSD');


                    // Ažuriraj grafikon za celu godinu, koristeći zaradaPoMesecu koji vraća server
                    let zaradaPoMesecima = [];
                    for (let i = 1; i <= 12; i++) {
                        zaradaPoMesecima.push(response.zaradaPoMesecima[i] || 0); // Dodaj zaradu po mesecu ili 0 ako nema podataka
                    }


                    console.log(zaradaPoMesecima);
                    zaradaGrafikon.data.datasets[0].data = zaradaPoMesecima;
                    zaradaGrafikon.data.labels = meseciNazivi;  // Koristimo nazive meseci umesto brojeva
                    zaradaGrafikon.update();

                    // Ažuriraj proizvode u select meniju
                    let proizvodSelect = $('#proizvod_prodaja');
                    proizvodSelect.empty();
                    proizvodSelect.append('<option value="" disabled selected>Izaberi proizvod</option>');
                    response.igracke.forEach(function(igracka) {
                        proizvodSelect.append('<option value="igracka-' + igracka.idIgracka + '">' + igracka.naziv_i + '</option>');
                    });
                    response.materijali.forEach(function(materijal) {
                        proizvodSelect.append('<option value="materijal-' + materijal.idMaterijal + '">' + materijal.naziv_m + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Došlo je do greške prilikom azuriranja statistike:', error);
                }
            });
        }


        //kada se selektuje proizvod
        $('#proizvod_prodaja').change(function() {
            let selectedValue = $('#proizvod_prodaja').val(); //proizvod-idProizvoda
            //console.log(selectedValue);
            let [tipProizvoda, proizvodId] = selectedValue.split('-'); // Razdvojimo tip i ID

            let mesec = $('#mesec').val();
            let godina = $('#godina').val();
            //console.log(proizvodId, tipProizvoda);

            if (mesec && godina && proizvodId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/nalog/broj-prodaja',
                    method: 'POST',
                    data: {
                        mesec: mesec,
                        godina: godina,
                        proizvodId: proizvodId,
                        tipProizvoda: tipProizvoda
                    },
                    success: function(response) {
                        // Dinamički prikaži broj prodaja ispod select menija
                        $('#brojProdajaProizvoda').remove(); // Ukloni prethodni prikaz
                        $('#proizvod_prodaja').parent().after('<p id="brojProdajaProizvoda" class="mt-2 text-gray-700">Ukupan broj prodaja za proizvod: <span class="font-bold">' + response.brojProdaja + '</span></p>');
                    },
                    error: function (xhr, status, error) {
                        console.error('Došlo je do greške prilikom menjanja broja prodaje po proizvodu:', error);
                    }
                });
            }
        });
    });
</script>
