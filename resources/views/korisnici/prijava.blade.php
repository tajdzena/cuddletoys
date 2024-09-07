<x-nav>
    <title>CuddleToys - Prijava</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/prijava" class="hover:underline"> Prijava</a>
    </x-path>

    <x-title>Prijavi se</x-title>
    <p class="text-lg text-center text-gray-700 mb-12">Nastavi da budeš deo naše heklane družine! ♡</p>

    <!-- Dodajemo klase za centriranje -->
    <div class="flex justify-center">
        <div class="w-full max-w-md bg-brighter-peach rounded-lg shadow-lg p-6">
            <form action="{{ route('prijava.create') }}" method="POST">
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

                <x-label-input for="mejl_ili_kor_ime"
                               text="Mejl ili korisničko ime"
                               type="text"
                               id="mejl_ili_kor_ime"
                               name="mejl_ili_kor_ime"
                               placeholder="pera.peric@gmail.com ili peraperic"
                               value="{{old('mejl_ili_kor_ime')}}"
                ></x-label-input>

                <!-- Input za lozinku sa dugmetom za toggle -->
                <div class="relative mb-4">
                    <x-label-input for="lozinka"
                                   text="Lozinka"
                                   type="password"
                                   id="lozinka"
                                   name="lozinka"
                                   placeholder="Unesi lozinku"></x-label-input>
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">
                        Prikaži
                    </button>
                </div>

                <!-- Dugme za prijavu -->
                <x-button type="submit" class="w-full px-4 py-3 mt-4">Prijavi se</x-button>

                <!-- Link za registraciju -->
                <p class="mt-4 text-center text-sm text-gray-600">Nemaš nalog? <a href="/registracija" class="text-purple hover:underline">Registruj se</a></p>
            </form>
        </div>
    </div>
</x-glavni-div>

<x-footer />

<!-- Skripta za prikaz/sakrivanje lozinke -->
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('lozinka');
        const toggleButton = event.currentTarget;
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.textContent = 'Sakrij';
        } else {
            passwordInput.type = 'password';
            toggleButton.textContent = 'Prikaži';
        }
    }
</script>
