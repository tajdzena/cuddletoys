<!-- Praćenje porudžbine -->
<div id="pracenje" class="section hidden">
    <h2 class="text-2xl text-center font-bold text-dark-pink -mt-12 mb-4">Praćenje porudžbina</h2>

    <!-- Ako je admin ili kurir, prikaži dropdown za selektovanje korisnika -->
    @canany(['isAdmin', 'isKurir'], Auth::user())
        <form id="selectKorisnikForm" class="mb-4">
            <label for="idKorisnik" class="font-semibold ml-2">Izaberi korisnika:</label>
            <select name="idKorisnik" id="idKorisnik" class="border rounded p-2 ml-2">
                <option value="" disabled selected>Korisnik</option>
                @foreach($korisnici as $korisnik)
                    <option value="{{ $korisnik->idKorisnik }}">{{ $korisnik->ime }} {{ $korisnik->prezime }}</option>
                @endforeach
            </select>
        </form>
    @endcanany

    <!-- Ako nema aktuelnih porudzbina, napisati "Nema aktuelnih porudzbina", isto i za prethodne -->

    <div id="porudzbine-container">
        @include('korisnici.nalog.partials.porudzbine', ['aktuelnePorudzbine' => $aktuelnePorudzbine, 'prethodnePorudzbine' => $prethodnePorudzbine])
    </div>

</div>


<script>
    $('#idKorisnik').change(function() {
        let selectedValue = $('#idKorisnik').val();
        console.log(selectedValue);

        fetch(`/korisnici/porudzbine/${selectedValue}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(data => {
                document.getElementById('porudzbine-container').innerHTML = data;
            })
            .catch(error => console.error('Greška prilikom učitavanja porudžbina:', error));
    });
</script>
