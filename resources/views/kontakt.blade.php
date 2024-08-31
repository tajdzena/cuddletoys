<x-nav>
    <title>CuddleToys - Kontakt</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/kontakt" class="hover:underline"> Kontakt</a>
    </x-path>

    <x-title>Kontaktiraj nas</x-title>

    <div class="flex flex-col md:flex-row gap-2 mt-12">
        <!-- Kontakt informacije -->
        <div class="w-full md:w-1/2 bg-brighter-peach rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-dark-pink mb-6">Naše informacije</h2>
            <p class="text-gray-700 mb-2">Mejl: <a href="mailto:info@cuddletoys.com" class="text-purple text-md hover:underline">info@cuddletoys.com</a></p>
            <p class="text-gray-700 mb-6">Telefon: <a href="tel:+381111234567" class="text-purple text-md hover:underline">011/1234-567</a></p>
            <p class="text-gray-700 mb-2">Zaprati nas na društvenim mrežama: </p>
            <ul class="mb-6">
                <li class="heart-bullet"><a href="https://instagram.com" target="_blank" class="text-purple text-md hover:underline">Instagram</a></li>
                <li class="heart-bullet"><a href="https://tiktok.com" target="_blank" class="text-purple text-md hover:underline">TikTok</a></li>
                <li class="heart-bullet"><a href="https://facebook.com" target="_blank" class="text-purple text-md hover:underline">Facebook</a></li>
            </ul>
            <p class="text-gray-700 mb-2">Imaš li posebne zahteve i pitanja oko izrade igračaka ili vrste materijala? Pošalji nam poruku!</p>

        </div>

        <!-- Kontakt forma -->
        <div class="w-full md:w-1/2 bg-brighter-peach rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-dark-pink mb-6">Pošalji poruku</h2>
            <form action="#" method="POST">
                <x-label-input for="ime" text="Ime" type="text" id="ime" name="ime" placeholder="Pera Perić"></x-label-input>
                <x-label-input for="mejl" text="Mejl" type="email" id="mejl" name="mejl" placeholder="pera.peric@gmail.com"></x-label-input>
                <x-label-input for="poruka" text="Poruka" type="textarea" id="poruka" name="poruka" placeholder="Pohvale, predlozi, kritike..."></x-label-input>

                <!-- Dugme poravnato u desno -->
                <div class="text-right">
                    <x-button type="submit" class="px-6 py-3">Pošalji</x-button>
                </div>

                <!-- Ili da dugme bude centrirano -->
                <!--
                <div class="flex justify-center">
                    <button type="submit" class="bg-dark-pink text-white px-6 py-3 rounded hover:bg-pink transition">Pošalji</button>
                </div>
                -->
            </form>
        </div>
    </div>

</x-glavni-div>

<x-footer />
