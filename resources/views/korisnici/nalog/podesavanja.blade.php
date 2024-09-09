<!-- Podešavanja naloga -->
<div id="podesavanja" class="section">
    <h2 class="text-2xl text-center font-bold text-dark-pink -mt-12 mb-4">Podešavanja naloga</h2>
    <div class="bg-brighter-peach rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-purple mb-8">Izmena podataka</h2>
        <form action="{{ route('nalog.izmeni') }}" method="POST">
            @csrf
            @if ($errors->has('ime') || $errors->has('prezime') || $errors->has('mejl') || $errors->has('kor_ime') || $errors->has('adresa'))
                <div class="bg-red-100 text-red-500 p-3 mb-6 rounded">
                    <ul>
                        @error('ime') <li>{{ $message }}</li> @enderror
                        @error('prezime') <li>{{ $message }}</li> @enderror
                        @error('mejl') <li>{{ $message }}</li> @enderror
                        @error('kor_ime') <li>{{ $message }}</li> @enderror
                        @error('adresa') <li>{{ $message }}</li> @enderror
                    </ul>
                </div>
            @endif

            @if (session('success1'))
                <div class="bg-green/20 text-green p-3 mb-6 rounded">
                    {{ session('success1') }}
                </div>
            @endif
            <x-label-input for="ime" text="Ime" type="text" id="ime" name="ime" value="{{ $korisnik->ime }}"></x-label-input>
            <x-label-input for="prezime" text="Prezime" type="text" id="prezime" name="prezime" value="{{ $korisnik->prezime }}"></x-label-input>
            <x-label-input for="mejl" text="Mejl" type="email" id="mejl" name="mejl" value="{{ $korisnik->mejl }}"></x-label-input>
            <x-label-input for="kor_ime" text="Korisničko ime" type="text" id="kor_ime" name="kor_ime" value="{{ $korisnik->kor_ime }}"></x-label-input>
            <x-label-input for="adresa" text="Adresa" type="text" id="adresa" name="adresa" value="{{ $korisnik->adresa_kor }}"></x-label-input>
            <x-button type="submit" class="mt-4 py-2 px-4">Izmeni</x-button>
        </form>
    </div>

    <!-- Resetovanje lozinke -->
    <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold text-purple mb-8">Resetovanje lozinke</h2>
        <form action="{{ route('nalog.reset') }}" method="POST">
            @csrf

            @if ($errors->has('trenutna_lozinka') || $errors->has('nova_lozinka') || $errors->has('nova_lozinka_confirmation'))
                <div class="bg-red-100 text-red-500 p-3 mb-6 rounded">
                    <ul>
                        @error('trenutna_lozinka') <li>{{ $message }}</li> @enderror
                        @error('nova_lozinka') <li>{{ $message }}</li> @enderror
                        @error('nova_lozinka_confirmation') <li>{{ $message }}</li> @enderror
                    </ul>
                </div>
            @endif

            <!-- Proveri da li postoji success poruka u sesiji -->
            @if (session('success2'))
                <div class="bg-green/20 text-green p-3 mb-6 rounded">
                    {{ session('success2') }}
                </div>
            @endif

            <!-- Trenutna lozinka -->
            <div class="relative mb-4">
                <x-label-input for="trenutna_lozinka" text="Trenutna lozinka" type="password" id="trenutna_lozinka" name="trenutna_lozinka"></x-label-input>
                <button type="button" onclick="togglePasswordVisibility('trenutna_lozinka', this)" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">Prikaži</button>
            </div>

            <!-- Nova lozinka -->
            <div class="relative mb-4">
                <x-label-input for="nova_lozinka" text="Nova lozinka" type="password" id="nova_lozinka" name="nova_lozinka"></x-label-input>
                <button type="button" onclick="togglePasswordVisibility('nova_lozinka', this)" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">Prikaži</button>
            </div>

            <!-- Potvrda nove lozinke -->
            <div class="relative mb-4">
                <x-label-input for="nova_lozinka_confirmation" text="Potvrdi novu lozinku" type="password" id="nova_lozinka_confirmation" name="nova_lozinka_confirmation"></x-label-input>
                <button type="button" onclick="togglePasswordVisibility('nova_lozinka_confirmation', this)" class="absolute right-3 top-10 text-sm text-purple bg-white p-1 focus:outline-none">Prikaži</button>
            </div>

            <x-button type="submit" class="mt-4 py-2 px-4">Resetuj</x-button>
        </form>
    </div>

</div>

<script>

    // Sifra
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
