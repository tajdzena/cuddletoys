<x-nav>
    <title>CuddleToys - Porudžbina</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/korpa"> Korpa</a>
        / <a href="/porudzbina"> Porudžbina</a>
    </x-path>

    <x-title>Porudžbina</x-title>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
        <!-- Podaci za porudžbinu -->
        <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-dark-pink mb-4">Podaci za porudžbinu</h2>

            <!-- Započni formu ovde, ali ne zatvaraj je do kraja -->
            <form action="{{ route('zavrsiPorudzbinu') }}" method="POST">
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

                <!-- Koristi lične podatke sa profila -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="koristi-licne-podatke" class="mr-2">
                    <label for="koristi-licne-podatke" class="text-gray-700">Koristi lične podatke sa profila</label>
                </div>

                <!-- Ime i Prezime -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-label-input for="ime" text="Ime" type="text" id="ime" name="ime" placeholder="Tvoje ime" value="{{old('ime')}}"></x-label-input>
                    <x-label-input for="prezime" text="Prezime" type="text" id="prezime" name="prezime" placeholder="Tvoje prezime" value="{{old('prezime')}}"></x-label-input>
                </div>

                <!-- Mejl i Telefon -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-label-input for="mejl" text="Mejl" type="email" id="mejl" name="mejl" placeholder="tvoj.mejl@gmail.com" value="{{old('mejl')}}"></x-label-input>
                    <x-label-input for="telefon" text="Telefon" type="text" id="telefon" name="telefon" placeholder="0601234567" value="{{old('telefon')}}"></x-label-input>
                </div>

                <!-- Adresa plaćanja i Adresa isporuke -->
                <x-label-input for="adresa-placanja" text="Adresa plaćanja" type="text" id="adresa_placanja" name="adresa_placanja" placeholder="Beograd, Adresa 123, 11000" value="{{old('adresa_placanja')}}"></x-label-input>
                <x-label-input for="adresa-isporuke" text="Adresa isporuke" type="text" id="adresa_isporuke" name="adresa_isporuke" placeholder="Beograd, Adresa 123, 11000" value="{{old('adresa_isporuke')}}"></x-label-input>

                <!-- validaciju odraditi -->
        </div>

        <!-- Druga kolona sa metodom plaćanja, dostavom i ukupnim iznosom -->
        <div class="space-y-12">
            <!-- Metod plaćanja -->
            <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-dark-pink mb-4">Metod plaćanja</h2>
                <x-select id="metod_placanja" name="metod_placanja">
                    <x-option value="" isDisabled="yes">Izaberi metod plaćanja</x-option>
                    <x-option value="1">Po preuzeću</x-option>
                    <x-option value="2">Kartica</x-option>
                </x-select>
            </div>

            <!-- Način dostave -->
            <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-dark-pink mb-4">Način dostave</h2>
                <p class="text-md text-gray-700">Kurirska služba: <span class="font-bold text-dark-pink">480 RSD</span></p>
                <p class="text-md text-gray-700">Rok isporuke: <span class="font-bold text-dark-pink">1-3 radnih dana</span></p>
            </div>

            <!-- Ukupan iznos -->
            <div class="bg-brighter-peach rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-bold text-dark-pink mb-2">Ukupan iznos: </h2>
                <h2 class="text-lg font-bold text-dark-pink">{{ sprintf('%.2f', $ukupanIznos)}} RSD</h2>

                <!-- Hidden input za ukupan iznos -->
                <input type="hidden" id="ukupan_iznos" name="ukupan_iznos" value="{{ $ukupanIznos }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <a href="/korpa"><x-button type="button" class="w-full h-12">Nazad na korpu</x-button></a>
                    <x-button type="submit" class="w-full h-12">Poruči</x-button> <!-- Zatvori formu ovde -->
                </div>
            </div>
            </form>
        </div>
    </div>
</x-glavni-div>

<x-footer />

<script>
    $(document).ready(function() {
        $('#koristi-licne-podatke').change(function() {
            if ($(this).is(':checked')) {
                // Ako je checkbox označen, popuni polja sa ličnim podacima
                $('#ime').val('{{ Auth::user()->ime }}');
                $('#prezime').val('{{ Auth::user()->prezime }}');
                $('#mejl').val('{{ Auth::user()->mejl }}');
                $('#adresa_placanja').val('{{ isset(Auth::user()->adresa_kor) ? Auth::user()->adresa_kor : '' }}');
                $('#adresa_isporuke').val('{{ isset(Auth::user()->adresa_kor) ? Auth::user()->adresa_kor : '' }}');
            } else {
                // Ako se skine oznaka, očisti polja
                $('#ime').val('');
                $('#prezime').val('');
                $('#mejl').val('');
                $('#adresa_placanja').val('');
                $('#adresa_isporuke').val('');
            }
        });
    });
</script>
