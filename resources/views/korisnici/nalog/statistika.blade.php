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
@endcan


<script>
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
