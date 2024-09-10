<x-nav>
    <title>CuddleToys - Izmena igračke</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="{{ route('igracke.index') }}" class="hover:underline"> Igračke</a>
        / <a href="{{ route('igracke.show', ['id' => $igracka->idIgracka]) }}" class="hover:underline capitalize"> {{ ucfirst($igracka->naziv_i) }} </a>
        / <a href="{{ route('igracke.edit', ['id' => $igracka->idIgracka]) }}" class="hover:underline"> Izmena </a>
    </x-path>

    <x-title>Izmena igračke</x-title>
{{--    <p class="text-lg text-center text-gray-700 mb-12">Postani već danas deo naše heklane družine! ♡</p>--}}

    <!-- Dodajemo klase za centriranje -->
    <div class="flex justify-center">
        <div class="w-full max-w-md bg-brighter-peach rounded-lg shadow-lg p-6 mt-4">
            <form action="{{ route('igracke.update', ['id' => $igracka->idIgracka]) }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-100 text-red-500 p-3 mb-6 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <x-label-input for="naziv" text="Naziv igračke" type="text" id="naziv" name="naziv" placeholder="Žaba" value="{{ $igrackaNaziv }}"></x-label-input>
                <x-label-input for="opis" text="Opis" type="textarea" id="opis" name="opis" placeholder="Ovde ide neki sjajan opis..."> {{ $igrackaOpis }} </x-label-input>


                <!-- Dugme za prijavu -->
                <x-button type="submit" class="w-full px-4 py-3 mt-4">Izmeni</x-button>
            </form>

            @can('isAdmin', Auth::user())
                <form action="{{ route('igracke.delete', ['id' => $igracka->idIgracka]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" class="w-full px-4 py-3 mt-4 bg-blue hover:bg-blue/40">Obriši proizvod</x-button>
                </form>
            @endcan
        </div>
    </div>
</x-glavni-div>

<x-footer />
