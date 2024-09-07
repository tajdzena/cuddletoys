<x-nav>
    <title>CuddleToys - Registracija</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/registracija" class="hover:underline"> Registracija</a>
    </x-path>

    <x-title>Registruj se</x-title>
    <p class="text-lg text-center text-gray-700 mb-12">Postani već danas deo naše heklane družine! ♡</p>

    <!-- Dodajemo klase za centriranje -->
    <div class="flex justify-center">
        <div class="w-full max-w-md bg-brighter-peach rounded-lg shadow-lg p-6">
            <form action="{{ route('registracija.store') }}" method="POST">
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

                <x-label-input for="ime" text="Ime" type="text" id="ime" name="ime" placeholder="Pera" value="{{ old('ime') }}"></x-label-input>
                <x-label-input for="prezime" text="Prezime" type="text" id="prezime" name="prezime" placeholder="Perić" value="{{ old('prezime') }}"></x-label-input>
                <x-label-input for="mejl" text="Mejl" type="email" id="mejl" name="mejl" placeholder="pera.peric@gmail.com" value="{{ old('mejl') }}"></x-label-input>
                <x-label-input for="kor_ime" text="Korisničko ime" type="text" id="kor_ime" name="kor_ime" placeholder="peraperic" value="{{ old('kor_ime') }}"></x-label-input>
                <x-label-input for="adresa" text="Adresa (opciono)" type="text" id="adresa" name="adresa" placeholder="Beograd, Adresa 123, 11000" value="{{ old('adresa') }}" isRequired="no"></x-label-input>

                <!-- Lozinka sa dugmetom za prikazivanje/sakrivanje -->
                <div class="mb-4 relative">
                    <label for="lozinka" class="block text-dark-pink font-semibold mb-2">Lozinka</label>
                    <input type="password" id="lozinka" name="lozinka" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2" placeholder="Unesi lozinku">
                    <button type="button" onclick="togglePasswordVisibility('lozinka', this)" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">Prikaži</button>
                </div>

                <!-- Potvrda lozinke sa dugmetom za prikazivanje/sakrivanje -->
                <div class="mb-4 relative">
                    <label for="lozinka_confirmation" class="block text-dark-pink font-semibold mb-2">Potvrda lozinke</label>
                    <input type="password" id="lozinka_confirmation" name="lozinka_confirmation" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2" placeholder="Ponovo unesi lozinku">
                    <button type="button" onclick="togglePasswordVisibility('lozinka_confirmation', this)" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">Prikaži</button>
                </div>

                <p class="text-sm text-blue mt-6">* Molimo da u adresu upišeš grad, ulicu, broj i poštanski broj.</p>

                <!-- Dugme za prijavu -->
                <x-button type="submit" class="w-full px-4 py-3 mt-4">Registruj se</x-button>

                <!-- Link za registraciju -->
                <p class="mt-4 text-center text-sm text-gray-600">Imaš nalog? <a href="/prijava" class="text-purple hover:underline">Prijavi se</a></p>
            </form>
        </div>
    </div>
</x-glavni-div>

<x-footer />

<script>
    function togglePasswordVisibility(fieldId, toggleButton) {
        const field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
            toggleButton.textContent = "Sakrij";
        } else {
            field.type = "password";
            toggleButton.textContent = "Prikaži";
        }
    }
</script>
