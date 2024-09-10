@props(['image', 'vrsta', 'naziv', 'boja_vunice'=>'', 'boja_ociju'=>'', 'boja_mat'=>'', 'dimenzije', 'cena', 'kolicina', 'stavka'])

<tr id="stavka-{{ $stavka->idStavka }}"
    data-cena-pravljenja="{{ isset($stavka->igracka) ? $stavka->igracka->cena_pravljenja : 0 }}"
    data-cena-vunice="{{ isset($stavka->igracka) ? $stavka->igracka->boje->bojaVunice->kombinacije->first()->cena_m ?? 0 : 0 }}"
    data-cena-ociju="{{ isset($stavka->igracka) ? $stavka->igracka->boje->bojaOciju->kombinacije->first()->cena_m ?? 0 : 0 }}">
    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm">
        <div class="flex items-center">
            <img src="{{ $image }}" alt="{{ $naziv }}" class="w-16 h-16 rounded-md">
            <div class="ml-4">
                @if($vrsta == 'igracka')
                    <p class="text-dark-pink font-semibold"><a class="hover:underline" href="igracke/{{$stavka->igracka->boje->igracka->idIgracka}}">{{ $naziv }}</a></p>
                    <p class='text-blue font-semibold'>Boja vunice: {{ $boja_vunice }}</p>
                    <p class='text-blue font-semibold'>Boja očiju: {{ $boja_ociju }}</p>
                @elseif($vrsta == 'materijal')
                    <p class="text-dark-pink font-semibold"><a class="hover:underline" href="materijali/{{$stavka->materijal->materijalBoja->materijal->idMaterijal}}">{{ $naziv }}</a></p>
                    <p class='text-blue font-semibold'>Boja materijala: {{ $boja_mat }}</p>
                @endif
                <p class='text-blue font-semibold'>Dimenzije: {{ $dimenzije }}</p>
            </div>
        </div>
    </td>
    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        <div class="flex items-center justify-center">
            <input type="number" name="kolicina[]" min="1" value="{{ $kolicina }}" class="w-12 text-center bg-white border border-gray-300">
        </div>
    </td>

    <td class="hidden px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        <!-- Jedinična cena (sakrivena vrednost) -->
        <span class="jedinicna-cena" data-jedinicna-cena="{{ $cena / $kolicina }}">{{ sprintf('%.2f', ($cena / $kolicina)) }} RSD</span>
    </td>


    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        @if($vrsta == 'igracka')
            <x-select id='nacin_pravljenja-{{ $stavka->idStavka }}' name='nacin_pravljenja[]'>
                <x-option value='' isDisabled='yes'>Izaberi način pravljenja</x-option>
                <x-option value='gotova' :isSelected="$stavka->nacin_pravljenja == 'gotova' ? 'yes' : ''">Gotova igračka</x-option>
                <x-option value='samostalno' :isSelected="$stavka->nacin_pravljenja == 'samostalno' ? 'yes' : ''">Samostalno</x-option>
            </x-select>
        @endif
    </td>


    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        <span class="stavka-cena" id="stavka-cena-{{ $stavka->idStavka }}">{{ sprintf('%.2f', $cena) }} RSD</span>
    </td>


    <!-- Remove button -->
    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        <form action="{{ route('ukloni', ['id' => $stavka->idStavka]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="ukloni-stavku-btn text-red-600 hover:text-red-900 block">Ukloni</button>
        </form>
    </td>
</tr>



<script>

    $(document).ready(function(){
        // Funkcija koja se poziva kada korisnik promeni način pravljenja
        $('select[name="nacin_pravljenja[]"]').on('change', function () {
            let nacinPravljenja = $(this).val(); // Dohvata selektovanu vrednost
            let stavkaId = $(this).closest('tr').attr('id').split('-')[1]; // Dohvati ID stavke iz reda
            //console.log(nacinPravljenja, stavkaId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Posalji AJAX zahtev za azuriranje načina pravljenja u bazi
            $.ajax({
                url: '/azuriraj-nacin-pravljenja', // Ruta ka kontroleru
                method: 'POST',
                data: {
                    stavkaId: stavkaId,
                    nacin_pravljenja: nacinPravljenja
                },
                success: function (response) {
                    console.log('Nacin pravljenja je uspešno ažuriran:', response);
                    // Ažuriraj ukupnu cenu ako je potrebno
                    //updateUkupnaCena();
                },
                error: function (xhr, status, error) {
                    console.error('Došlo je do greške prilikom ažuriranja načina pravljenja:', error);
                }
            });
        });

        //kada korisnik promeni kolicinu
        $('input[name="kolicina[]"]').on('change', function () {
            let kolicinaStavke = $(this).val();
            let stavkaId = $(this).closest('tr').attr('id').split('-')[1];
            let stavkaCenaPoKomadu = $(this).closest('tr').find('.jedinicna-cena').data('jedinicna-cena');
            let novaCenaStavke = kolicinaStavke * stavkaCenaPoKomadu;

            // Ažuriraj cenu stavke
            $(this).closest('tr').find('.stavka-cena').text(novaCenaStavke.toFixed(2) + ' RSD');

            // Ažuriraj ukupnu cenu
            updateUkupnaCena();

            //console.log(kolicinaStavke, stavkaId);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Posalji AJAX zahtev za azuriranje načina pravljenja u bazi
            $.ajax({
                url: '/azuriraj-kolicinu', // Ruta ka kontroleru
                method: 'POST',
                data: {
                    stavkaId: stavkaId,
                    kolicinaStavke: kolicinaStavke
                },
                success: function (response) {
                    console.log('Nacin pravljenja je uspešno ažuriran:', response);
                    // Ažuriraj ukupnu cenu ako je potrebno
                    //updateUkupnaCena();
                },
                error: function (xhr, status, error) {
                    console.error('Došlo je do greške prilikom ažuriranja količine stavke:', error);
                }
            });
        });
    })

</script>





