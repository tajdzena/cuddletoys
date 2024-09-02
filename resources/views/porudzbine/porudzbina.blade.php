<x-nav>
    <title>CuddleToys - Porudžbina</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/korpa"> Korpa</a>
        / <a href="/porudzbina"> Porudžbina</a>
    </x-path>

    <x-title>Porudžbina</x-title>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
        <!-- Podaci za porudžbinu -->
        <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-dark-pink mb-4">Podaci za porudžbinu</h2>
            <form action="#" method="POST">
                <!-- Koristi lične podatke sa profila -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="koristi-licne-podatke" class="mr-2">
                    <label for="koristi-licne-podatke" class="text-gray-700">Koristi lične podatke sa profila</label>
                </div>

                <!-- Ime i Prezime -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-label-input for="ime" text="Ime" type="text" id="ime" name="ime" placeholder="Tvoje ime"></x-label-input>
                    <x-label-input for="prezime" text="Prezime" type="text" id="prezime" name="prezime" placeholder="Tvoje prezime"></x-label-input>
                </div>

                <!-- Mejl i Telefon -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-label-input for="mejl" text="Mejl" type="email" id="mejl" name="mejl" placeholder="tvoj.mejl@gmail.com"></x-label-input>
                    <x-label-input for="telefon" text="Telefon" type="text" id="telefon" name="telefon" placeholder="0601234567"></x-label-input>
                </div>

                <!-- Adresa plaćanja i Adresa isporuke -->
                <x-label-input for="adresa-placanja" text="Adresa plaćanja" type="text" id="adresa-placanja" name="adresa-placanja" placeholder="Beograd, Adresa 123, 11000"></x-label-input>
                <x-label-input for="adresa-isporuke" text="Adresa isporuke" type="text" id="adresa-isporuke" name="adresa-isporuke" placeholder="Beograd, Adresa 123, 11000"></x-label-input>

                <!-- Napomena -->
                <p class="text-sm text-blue mt-8">* Molimo da u adresu upišeš grad, ulicu, broj i poštanski broj.</p>
                <p class="text-sm text-blue">* Isporučujemo samo unutar Srbije.</p>
            </form>
        </div>

        <!-- Kartice za metod plaćanja, način dostave i ukupan iznos -->
        <div class="space-y-12">
            <!-- Metod plaćanja -->
            <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-dark-pink mb-4">Metod plaćanja</h2>
                <x-select id="metod-placanja" name="metod-placanja">
                    <x-option value="" isDisabled="yes">Izaberi metod plaćanja</x-option>
                    <x-option value="kartica">Kartica</x-option>
                    <x-option value="pouzece">Po preuzeću</x-option>
                </x-select>
            </div>

            <!-- Način dostave -->
            <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-dark-pink mb-4">Način dostave</h2>
                <p class="text-md text-gray-700">Kurirska služba: <span class="font-bold text-dark-pink">480 RSD</span></p>
                <p class="text-md text-gray-700">Rok isporuke: <span class="font-bold text-dark-pink">1-3 radnih dana</span></p>
            </div>

            <!-- Ukupan iznos -->
            <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-dark-pink mb-2">Ukupan iznos: </h2>
                <h2 class="text-lg font-bold text-dark-pink">4.000 RSD</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <a href="/korpa"><x-button type="submit" class="w-full h-12">Nazad na korpu</x-button></a>
                    <a href="/racun"><x-button type="submit" class="w-full h-12">Poruči</x-button></a>
                </div>
            </div>
        </div>
    </div>
</x-glavni-div>

<x-footer />
