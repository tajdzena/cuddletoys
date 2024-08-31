<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<x-nav>
    <title>CuddleToys - Moj nalog</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/profil" class="hover:underline">Moj nalog</a>
    </x-path>

    <h2 class="text-3xl font-bold text-purple mt-8 mb-4">Zdravo, Tijana! ♡</h2>

    <div class="flex mt-8">
        <!-- Sidebar meni -->
        <div class="w-1/3 pr-4">
            <ul class="text-dark-pink bg-brighter-peach rounded-lg shadow-lg p-6">
                <li class="mb-2"><button class="hover:underline" onclick="showSection('podesavanja')">Podešavanja naloga</button></li>
                <hr>
                <li class="mt-2 mb-2"><button class="hover:underline" onclick="showSection('pracenje')">Praćenje porudžbina</button></li>

                <hr>
                <li class="mt-2"><button class="hover:underline" onclick="showSection('statistika')">Statistika</button></li>
            </ul>
        </div>

        <!-- Sadržaj podstranica -->
        <div class="w-3/4">
            <!-- Podešavanja naloga -->
            <div id="podesavanja" class="section">
                <h2 class="text-2xl text-center font-bold text-dark-pink -mt-12 mb-4">Podešavanja naloga</h2>
                <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-purple mb-8">Izmena podataka</h2>
                    <form action="#" method="POST">
                        <x-label-input for="ime" text="Ime" type="text" id="ime" name="ime"></x-label-input>
                        <x-label-input for="prezime" text="Prezime" type="text" id="prezime" name="prezime"></x-label-input>
                        <x-label-input for="mejl" text="Mejl" type="email" id="mejl" name="mejl"></x-label-input>
                        <x-label-input for="kor_ime" text="Korisničko ime" type="text" id="kor_ime" name="kor_ime"></x-label-input>
                        <x-label-input for="adresa" text="Adresa" type="text" id="adresa" name="adresa"></x-label-input>
                        <x-button type="submit" class="mt-4 py-2 px-4">Izmeni</x-button>
                    </form>
                </div>

                <!-- Resetovanje lozinke -->
                <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-purple mb-8">Resetovanje lozinke</h2>
                    <form action="#" method="POST">
                        <!-- Nova lozinka -->
                        <div class="relative mb-4">
                            <x-label-input for="nova_lozinka" text="Nova lozinka" type="password" id="nova_lozinka" name="nova_lozinka"></x-label-input>
                            <button type="button" onclick="togglePasswordVisibility('nova_lozinka', this)" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">Prikaži</button>
                        </div>

                        <!-- Potvrda nove lozinke -->
                        <div class="relative mb-4">
                            <x-label-input for="nova_lozinka_potvrda" text="Potvrdi novu lozinku" type="password" id="nova_lozinka_potvrda" name="nova_lozinka_potvrda"></x-label-input>
                            <button type="button" onclick="togglePasswordVisibility('nova_lozinka_potvrda', this)" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">Prikaži</button>
                        </div>

                        <x-button type="submit" class="mt-4 py-2 px-4">Resetuj</x-button>
                    </form>
                </div>

            </div>



            <!-- Praćenje porudžbine -->
            <div id="pracenje" class="section hidden">
                <h2 class="text-2xl text-center font-bold text-dark-pink -mt-12 mb-4">Praćenje porudžbina</h2>

                <!-- Ako nema aktuelnih porudzbina, napisati "Nema aktuelnih porudzbina", isto i za prethodne -->

                <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-purple mb-4">Aktuelne porudžbine</h2>

                    <x-card-porudzbina
                        pret_ili_akt="aktuelna"
                        adresa_isporuke="Beograd, Adresa 123, 11000"
                        status_porudzbine="U izradi"
                        vreme_statusa="2024-08-30"
                        iznos="3000 RSD"
                        metod_placanja="Kartica"
                    ></x-card-porudzbina>
                </div>

                <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-purple mb-4">Prethodne porudžbine</h2>

                    <x-card-porudzbina
                        adresa_isporuke="Novi Sad, Adresa 456, 21000"
                        status_porudzbine="Isporučena"
                        vreme_statusa="2024-08-29"
                        iznos="2000 RSD"
                        metod_placanja="Po preuzeću"
                    ></x-card-porudzbina>

                    <x-card-porudzbina
                        adresa_isporuke="Novi Sad, Adresa 456, 21000"
                        status_porudzbine="Isporučena"
                        vreme_statusa="2024-08-29"
                        iznos="2000 RSD"
                        metod_placanja="Po preuzeću"
                    ></x-card-porudzbina>
                </div>
            </div>




            <!-- Sekcija za statistiku -->
            <div id="statistika" class="section hidden">
                <h2 class="text-2xl text-center font-bold text-dark-pink -mt-12 mb-4">Statistika</h2>
                <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
                    <div class="flex flex-row items-center justify-center mb-4 gap-12">
                        <div class="text-center">
                            <label for="mesec" class="block text-dark-pink font-semibold mb-2">Mesec: </label>
                            <x-select id="mesec" name="mesec" class="text-center">
                                <x-option value="" isDisabled="yes">Izaberi mesec</x-option>
                                <x-option value="avgust">Avgust</x-option>
                                <!-- Dodaj još opcija po potrebi -->
                            </x-select>
                        </div>
                        <div class="text-center">
                            <label for="godina" class="block text-dark-pink font-semibold mb-2">Godina: </label>
                            <x-select id="godina" name="godina" class="text-center">
                                <x-option value="" isDisabled="yes">Izaberi godinu</x-option>
                                <x-option value="2024">2024</x-option>
                                <!-- Dodaj još opcija po potrebi -->
                            </x-select>
                        </div>
                    </div>
                    <p class="text-lg text-dark-pink font-semibold mt-6">Statistika za <span id="selected-month" class="font-bold">avgust</span> <span id="selected-year" class="font-bold">2024</span>.</p>
                    <p class="text-md text-gray-700 mt-2">Ukupan broj prodaja: <span id="total-sales" class="font-bold">143</span> (<span id="total-revenue">35.000 RSD</span>)</p>


                    <div class="mt-8 flex flex-row gap-4">
                        <label for="proizvod_prodaja" class="mt-2 block text-dark-pink font-semibold mb-2">Broj prodaja po proizvodu: </label>
                        <x-select id="proizvod_prodaja" name="proizvod_prodaja" class="text-center">
                            <x-option value="" isDisabled="yes">Izaberi proizvod</x-option>
                            <x-option value="zabica">zabica</x-option>
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
        </div>
    </div>
</x-glavni-div>

<x-footer />

<script>
    function showSection(sectionId) {
        // Sakrij sve sekcije
        document.querySelectorAll('.section').forEach(section => {
            section.classList.add('hidden');
        });

        // Prikazi izabranu sekciju
        document.getElementById(sectionId).classList.remove('hidden');
    }


    // Sifra
    function togglePasswordVisibility(fieldId, toggleButton) {
        const field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
            toggleButton.textContent = "Sakrij";
        } else {
            field.type = "password";
            toggleButton.textContent = "Prikaži";
        }
    }


    // Inicijalizacija grafikona sa Chart.js
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('zaradaGrafikon').getContext('2d');
        const zaradaGrafikon = new Chart(ctx, {
            type: 'bar', // Tip grafikona
            data: {
                labels: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'], // Meseci
                datasets: [{
                    label: 'Ukupna zarada po mesecu (RSD)',
                    data: [10000, 15000, 20000, 25000, 23000, 21000, 27000, 35000], // Podaci o zaradi za svaki mesec
                    backgroundColor: 'rgba(254,206,124,0.4',
                    borderColor: 'rgb(254,206,124)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: '2024',
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
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Ažuriranje grafikona kada se promeni godina
        document.getElementById('godina').addEventListener('change', function() {
            const selectedYear = this.value;
            document.getElementById('selected-year').textContent = selectedYear;

            // Izmena podataka grafikona za odabranu godinu
            // Primer: Promena podataka za grafikon (koristi stvarne podatke)
            zaradaGrafikon.data.datasets[0].data = [11000, 14000, 21000, 23000, 25000, 20000, 26000, 34000, 32000, 31000, 30000, 37000]; // Novi podaci
            zaradaGrafikon.update();
        });
    });
</script>
