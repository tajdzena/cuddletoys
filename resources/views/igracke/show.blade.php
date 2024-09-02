<x-nav>
    <title>CuddleToys - Igračka</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/igracke" class="hover:underline"> Igračke</a>
        / <a href="/igracka" class="hover:underline"> Igračka</a> <!-- specifican id igracke kasnije -->
    </x-path>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        <!-- Slajder -->
        <div class="relative mx-auto mt-10 mb-12 overflow-hidden">
            <div id="slider" class="flex transition-transform duration-700 ease-in-out">
                <x-slika putanja="images/igracke/zaba/zaba-zelena-crna.png" alt="Žaba" h="56"></x-slika>
                <x-slika putanja="images/igracke/zaba/zaba2.png" alt="Žaba" h="56"></x-slika>
                <x-slika putanja="images/igracke/zaba/zaba3.png" alt="Žaba" h="56"></x-slika>
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
        <div class="flex flex-col justify-start mt-14">
            <h2 class="text-2xl font-bold text-purple mb-10">Žaba</h2>
            <p class="text-gray-700 mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aspernatur fuga in mollitia perspiciatis quidem sed soluta. Ad aperiam beatae, fuga maiores officia quos saepe suscipit tempora totam vero. Doloremque?</p>

            <div class="flex flex-row mb-12">
                <p class="text-2xl font-bold text-dark-pink">2.000 RSD</p>

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
                    <x-select id="boja_vunice" name="boja_vunice">
                        <x-option value="zelena">Zelena</x-option>
                        <x-option value="plava">Plava</x-option>
                        <x-option value="roze">Roze</x-option>
                        <x-option value="zuta">Žuta</x-option>
                    </x-select>
                </div>
                <!-- Boja očiju -->
                <div>
                    <label for="boja_ociju" class="block text-dark-pink font-semibold mb-2">Boja očiju</label>
                    <x-select id="boja_ociju" name="boja_ociju">
                        <x-option value="zelena">Zelena</x-option>
                        <x-option value="plava">Plava</x-option>
                        <x-option value="roze">Roze</x-option>
                        <x-option value="zuta">Žuta</x-option>
                    </x-select>
                </div>
                <!-- Dimenzije -->
                <div>
                    <label for="dimenzije" class="block text-dark-pink font-semibold mb-2">Dimenzije</label>
                    <x-select id="dimenzije" name="dimenzije">
                        <x-option value="15x20">15 x 20 cm</x-option>
                        <x-option value="30x60">30 x 60 cm</x-option>
                        <x-option value="60x120">60 x 120 cm</x-option>
                    </x-select>
                </div>
            </div>

            <p class="mt-8 text-blue">Imaš posebne zahteve za pravljenje igračke? <a href="/kontakt" class="text-hot-pink underline">Piši nam</a>.</p>
        </div>
    </div>
</x-glavni-div>

<x-footer />
