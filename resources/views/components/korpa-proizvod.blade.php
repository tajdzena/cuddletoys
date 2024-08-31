@props(['image', 'vrsta', 'naziv', 'boja_vunice'=>'', 'boja_ociju'=>'', 'boja_mat'=>'', 'dimenzije', 'cena', 'kolicina'])

<tr>
    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm">
        <div class="flex items-center">
            <img src="{{ $image }}" alt="{{ $naziv }}" class="w-16 h-16 rounded-md">
            <div class="ml-4">
                <p class="text-dark-pink font-semibold">{{ $naziv }}</p>
                @if($vrsta == 'igracka')
                    <p class='text-blue font-semibold'>Boja vunice: {{ $boja_vunice }}</p>
                    <p class='text-blue font-semibold'>Boja očiju: {{ $boja_ociju }}</p>
                @elseif($vrsta == 'materijal')
                    <p class='text-blue font-semibold'>Boja materijala: {{ $boja_mat }}</p>
                @endif
                <p class='text-blue font-semibold'>Dimenzije: {{ $dimenzije }}</p>
            </div>
        </div>
    </td>
    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        <div class="flex items-center justify-center">
            <input type="number" min="1" value="{{ $kolicina }}" class="w-12 text-center bg-white border border-gray-300">
        </div>
    </td>
    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        <span class="text-gray-700 font-semibold<">{{ $cena }} RSD</span>
    </td>

    <td class="px-4 py-4 border-b border-gray-200 bg-brighter-peach text-sm text-center">
        @if($vrsta == 'igracka')
            <!-- Izbacujemo PHP blok i koristimo direktno Blade -->
            <x-select id='nacin_pravljenja' name='nacin_pravljenja'>
                <x-option value='' isDisabled='yes'>Izaberi način pravljenja</x-option>
                <x-option value='1'>Samostalno</x-option>
                <x-option value='2'>Gotova igračka</x-option>
            </x-select>
        @endif
    </td>
    <td>
        <button class="text-red-600 hover:text-red-900 mt-2 block">Ukloni</button>
    </td>
</tr>
