<x-nav>
    <title>CuddleToys - Materijal</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/materijali" class="hover:underline"> Materijali</a>
        / <a href="/materijal" class="hover:underline"> Materijal</a> <!-- specifican id igracke kasnije -->
    </x-path>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        <!-- Slajder -->
        <div class="relative mx-auto mt-10 mb-12 overflow-hidden">
            <div id="slider" class="flex transition-transform duration-700 ease-in-out">
                <x-slika putanja="images/materijali/heklica/heklica3mm.jpg" alt="Heklica" h="56"></x-slika>
                <x-slika putanja="images/materijali/heklica/heklica5mm.jpg" alt="Heklica" h="56"></x-slika>
                <x-slika putanja="images/materijali/heklica/heklica8mm.jpg" alt="Heklica" h="56"></x-slika>
                <x-slika putanja="images/materijali/heklica/heklica12mm.jpg" alt="Heklica" h="56"></x-slika>
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
            <h2 class="text-2xl font-bold text-purple mb-10">Heklica</h2>
            <p class="text-gray-700 mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aspernatur fuga in mollitia perspiciatis quidem sed soluta. Ad aperiam beatae, fuga maiores officia quos saepe suscipit tempora totam vero. Doloremque?</p>

            <div class="flex flex-row mb-4">
                <p class="text-2xl font-bold text-dark-pink">350 RSD</p>

                <div class="ml-auto mr-7">
                    <input type="number" min="1" value="1" class="mr-4 w-14 h-10 text-lg text-center border border-gray-300 rounded">
                    <x-button type="submit" class="px-6 py-3 mb-4">Dodaj u korpu</x-button>
                </div>
            </div>


            <!-- Opcije za prilagođavanje -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-11 mt-8">
                <!-- Boja -->
                <div>
                    <label for="boja_mat" class="block text-dark-pink font-semibold mb-2">Boja materijala</label>
                    <x-select id="boja_mat" name="boja_mat">
                        <x-option value="zelena">Zelena</x-option>
                        <x-option value="plava">Plava</x-option>
                        <x-option value="roze">Roze</x-option>
                        <x-option value="zuta">Žuta</x-option>
                    </x-select>
                </div>
                <div>
                    <label for="dimenzije_mat" class="block text-dark-pink font-semibold mb-2">Veličina materijala</label>
                    <x-select id="dimenzije_mat" name="dimenzije_mat">
                        <x-option value="1">3mm</x-option>
                        <x-option value="2">5mm</x-option>
                        <x-option value="3">8mm</x-option>
                        <x-option value="4">12mm</x-option>
                    </x-select>
                </div>
            </div>

            <p class="mt-8 text-blue">Imaš posebne zahteve za materijal? <a href="/kontakt" class="text-hot-pink underline">Piši nam</a>.</p>
        </div>
    </div>
</x-glavni-div>

<x-footer />
