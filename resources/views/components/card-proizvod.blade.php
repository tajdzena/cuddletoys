@props(['putanja', 'alt', 'href', 'naziv', 'cena'])

<div class="bg-white/50 rounded-lg shadow-md p-4">
    <x-slika putanja="{{$putanja}}" alt="{{$alt}}" h="48"></x-slika>
    <a href="{{$href}}"><h2 class="mt-4 text-lg font-semibold text-dark-pink capitalize">{{$naziv}}</h2></a>
    <p class="mt-2 font-bold text-gray-700">{{$cena}}</p>
    <x-button type="submit" class="mt-4 px-4 py-2">Dodaj u korpu</x-button>
</div>
