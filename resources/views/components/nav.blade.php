<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />

    {{$slot}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-peach font-mulish">
<header class="bg-gradient-to-r from-pink via-lavender to-blue">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex flex-1 items-center justify-between">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">CuddleToys</span>
{{--                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="CuddleToys Logo">--}}
                <img src="{{asset('images/logo/02-logo-cuddletoys.png')}}" class="h-10 w-auto" alt="CuddleToys">
            </a>

            <!-- Hamburger Menu Button (Mobile) -->
            <div class="lg:hidden ml-auto">
                <button id="open-menu-button" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-dark-pink">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="hidden lg:flex lg:gap-x-12">
            <x-nav-link putanja="../igracke">Igračke</x-nav-link>
            <x-nav-link putanja="../materijali">Materijali</x-nav-link>
            <x-nav-link putanja="../tutorijali">Tutorijali</x-nav-link>
            <x-nav-link putanja="../kontakt">Kontakt</x-nav-link>
            <x-nav-link putanja="../o-nama">O nama</x-nav-link>
        </div>

        <!-- Desktop Icons -->
        <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-x-6">
            <!-- Ikonica za pretragu -->
            <a href="../pretraga" class="text-dark-pink hover:text-hot-pink">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
                <span class="sr-only">Traži</span>
            </a>

            <!-- Ikonica za profil -->
            <div class="relative">
                <button id="profile-dropdown-button" class="text-dark-pink hover:text-hot-pink flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span class="sr-only">Profil</span>
                </button>
                <div id="profile-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-brighter-peach rounded-md shadow-lg py-2 hidden">
                    <a href="../prijava" class="block px-4 py-2 text-sm text-dark-pink hover:bg-dark-pink/10">Prijavi se</a>
                    <a href="../registracija" class="block px-4 py-2 text-sm text-dark-pink hover:bg-dark-pink/10">Registruj se</a>
                </div>
            </div>

            <!-- Ikonica za korpu -->
            <a href="../korpa" class="text-dark-pink hover:text-hot-pink">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
                <span class="sr-only">Korpa</span>
            </a>
        </div>
    </nav>

    <!-- Mobile menu, hidden by default -->
    <div id="mobile-menu" class="lg:hidden fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-peach px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10 hidden">
        <div class="flex items-center justify-between">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">CuddleToys</span>
                <img src="{{asset('images/logo/02-logo-cuddletoys.png')}}" class="h-8 w-auto" alt="CuddleToys">
            </a>
            <button id="close-menu-button" type="button" class="-m-2.5 rounded-md p-2.5 text-dark-pink">
                <span class="sr-only">Close menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/40">
                <div class="space-y-2 py-6">
                    <x-mobile-nav-link putanja="../igracke">Igračke</x-mobile-nav-link>
                    <x-mobile-nav-link putanja="../materijali">Materijali</x-mobile-nav-link>
                    <x-mobile-nav-link putanja="../tutorijali">Tutorijali</x-mobile-nav-link>
                    <x-mobile-nav-link putanja="../kontakt">Kontakt</x-mobile-nav-link>
                    <x-mobile-nav-link putanja="../o-nama">O nama</x-mobile-nav-link>
                </div>
                <div class="py-6">
                    <x-mobile-nav-link putanja="../pretraga">Traži</x-mobile-nav-link>
                    <div class="relative">
                        <button id="mobile-profile-dropdown-button" class="-ml-3 mr-4 flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-dark-pink hover:bg-white/20">
                            Profil
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="mobile-profile-dropdown-menu" class="-ml-1 mr-3 mt-2 bg-brighter-peach rounded-md shadow-lg py-2 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-dark-pink hover:bg-dark-pink/10">Prijavite se</a>
                            <a href="#" class="block px-4 py-2 text-sm text-dark-pink hover:bg-dark-pink/10">Registrujte se</a>
                        </div>
                    </div>
                    <x-mobile-nav-link putanja="../korpa">Korpa</x-mobile-nav-link>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Toggle for desktop profile dropdown menu
    const profileDropdownButton = document.getElementById('profile-dropdown-button');
    const profileDropdownMenu = document.getElementById('profile-dropdown-menu');

    profileDropdownButton.addEventListener('click', () => {
        profileDropdownMenu.classList.toggle('hidden');
    });

    // Toggle for mobile profile dropdown menu
    const mobileProfileDropdownButton = document.getElementById('mobile-profile-dropdown-button');
    const mobileProfileDropdownMenu = document.getElementById('mobile-profile-dropdown-menu');

    mobileProfileDropdownButton.addEventListener('click', () => {
        mobileProfileDropdownMenu.classList.toggle('hidden');
    });

    // Toggle for mobile menu
    const openMenuButton = document.getElementById('open-menu-button');
    const closeMenuButton = document.getElementById('close-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    openMenuButton.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
    });

    closeMenuButton.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
    });
</script>
</body>



