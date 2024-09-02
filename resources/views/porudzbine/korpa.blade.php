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
                <tr>
                    <th class="px-4 py-2 text-left text-dark-pink">Proizvod</th>
                    <th class="px-4 py-2 text-center text-dark-pink">Količina</th>
                    <th class="px-4 py-2 text-center text-dark-pink">Cena</th>
                    <th class="px-4 py-2 text-center text-dark-pink">Način pravljenja</th>
                    <th class="px-4 py-2 text-center text-dark-pink"></th>
                </tr>
                </thead>
                <tbody>
                <!-- Uključi komponentu za svaki red proizvoda -->
                <x-korpa-proizvod image="/images/igracke/zaba/zaba-zelena-plava.png" vrsta="igracka" naziv="Žaba" boja_vunice="zelena" boja_ociju="plava" dimenzije="15x30x30" cena="900" kolicina="1" />
                <x-korpa-proizvod image="/images/materijali/heklica/heklica5mm.jpg" vrsta="materijal" naziv="Heklica" boja_mat="plava" cena="900" dimenzije="5mm" kolicina="1" />
                <x-korpa-proizvod image="/images/igracke/zaba/zaba-zelena-plava.png" vrsta="igracka" naziv="Žaba" boja_vunice="zelena" boja_ociju="plava" dimenzije="30x60x60" cena="900" kolicina="1" />
                <!-- Dodajte više redova po potrebi -->
                </tbody>
            </table>

            <!-- Ukupna cena i dugme za nastavak -->
            <div class="flex justify-between items-center mt-6">
                <p class="text-lg font-semibold text-dark-pink">Ukupno: <span class="font-bold">3.000 RSD</span></p>
                <a href="/porudzbina"><x-button type="submit" class="px-6 py-3">Nastavi sa plaćanjem</x-button></a>
            </div>
        </div>

        <!-- Kartica za unos kupona -->
        <div class="bg-brighter-peach rounded-lg shadow-lg p-6 h-48">
            <form action="#" method="POST" class="flex flex-col">
                <x-label-input for="kupon-kod" text="Imaš kupon kod?" type="text" id="kupon-kod" name="kupon-kod" placeholder="%" isRequired="no"></x-label-input>
                <x-button type="submit" class="w-full px-4 py-2">Primeni</x-button>
            </form>
        </div>
    </div>
</x-glavni-div>

<x-footer />
