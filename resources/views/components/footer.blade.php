<!-- resources/views/components/footer.blade.php -->
<footer class="bg-gradient-to-r from-pink via-lavender to-blue text-dark-pink py-8 mt-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-7 gap-5">
            <!-- Logo i copyright sa desnom vertikalnom crtom -->
            <div class="flex flex-col items-center justify-center">
                <a href="/" class="">
                    <span class="sr-only">CuddleToys</span>
                    <img src="{{asset('images/logo/02-logo-cuddletoys.png')}}" class="h-8" alt="CuddleToys">
                </a>
                <p class="text-sm mt-2">&copy; 2024</p>
            </div>

            <div class="border-r border-brighter-peach/50 mr-20"></div>

            <!-- Proizvodi -->
            <div>
                <h3 class="text-md font-bold">Proizvodi</h3>
                <ul class="mt-2 space-y-1 list-none">
                    <x-footer-link putanja="/igracke">Igračke</x-footer-link>
                    <x-footer-link putanja="/materijali">Materijali</x-footer-link>
                </ul>
            </div>

            <!-- Uradi sam -->
            <div>
                <h3 class="text-md font-bold">Uradi sam</h3>
                <ul class="mt-2 space-y-1 list-none">
                    <x-footer-link putanja="/tutorijali">Tutorijali</x-footer-link>
                </ul>
            </div>

            <!-- Informacije -->
            <div>
                <h3 class="text-md font-bold">Informacije</h3>
                <ul class="mt-2 space-y-1 list-none">
                    <x-footer-link putanja="/kontakt">Kontakt</x-footer-link>
                    <x-footer-link putanja="/o-nama">O nama</x-footer-link>
                </ul>
            </div>

            <!-- Korisni linkovi -->
            <div>
                <h3 class="text-md font-bold">Korisni linkovi</h3>
                <ul class="mt-2 space-y-1 list-none">
                    <x-footer-link putanja="/moj-nalog">Moj nalog</x-footer-link>
                    <x-footer-link putanja="/registracija">Registracija</x-footer-link>
                    <x-footer-link putanja="/korpa">Korpa</x-footer-link>
                </ul>
            </div>

            <!-- Društvene mreže -->
            <div>
                <h3 class="text-md font-bold">Društvene mreže</h3>
                <ul class="mt-2 space-y-1 list-none">
                    <x-footer-link putanja="https://instagram.com" target="_blank">Instagram</x-footer-link>
                    <x-footer-link putanja="https://tiktok.com" target="_blank">TikTok</x-footer-link>
                    <x-footer-link putanja="https://facebook.com" target="_blank">Facebook</x-footer-link>
                </ul>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
