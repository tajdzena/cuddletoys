<x-nav>
    <title>CuddleToys - Tutorijali</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/tutorijali" class="hover:underline"> Tutorijali</a>
    </x-path>

    <x-title>Tutorijali</x-title>
    <p class="text-lg text-center text-gray-700 mb-12">Izaberi igračku, prevuci do dna stranice i pretvori maštu u stvarnost! ♡</p>

    <!-- Grid za prikazivanje igračaka -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
        @foreach($igracke as $igracka)
            <x-card-proizvod
                :putanja="isset($igracka->defaultBoje->slika) ? $igracka->defaultBoje->slika->putanja : 'images/no-image.jpg'"
                href="igracke/{{$igracka->idIgracka}}"
                :alt="ucfirst($igracka->naziv_i)"
                :naziv="ucfirst($igracka->naziv_i)"
                :cena="null">

                <!-- Dugme za prikaz tutorijala -->
                <x-button class="mt-1 px-4 py-2" onclick="prikaziTutorijal('{{ $igracka->naziv_i }}')">
                    Prikaži tutorijal
                </x-button>
            </x-card-proizvod>
        @endforeach
    </div>


    <!-- Ugrađeni YouTube video koji se menja na osnovu izbora -->
    <div id="tutorial-video" class="flex justify-center mt-16 mb-6 hidden">
        <!-- Video iframe koji se dinamički menja -->
        <iframe id="yt-video"
                class="shadow-2xl shadow-purple rounded-3xl"
                width="1080"
                height="608"
                src=""
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>

</x-glavni-div>

<x-footer />

<script>

    // Mapa koja povezuje igračke sa odgovarajućim YouTube URL-ovima
    const videoLinks = {
        'zaba': 'https://www.youtube.com/embed/8KRig-NRMPY?si=KaM7saGgjE-0Zyw7',
        'meda': 'https://www.youtube.com/embed/DtAM9E7qsH0?si=WW6YltP_43brDHOD',
        'slon': 'https://www.youtube.com/embed/qdbunVKic_o?si=9Ub6BeOCNfFrDbd5',
        'patka': 'https://www.youtube.com/embed/JJ53NWc2tOU?si=V9cBW8uNOdJhKddd',
        'kornjaca': 'https://www.youtube.com/embed/vqPlfiTzTcA?si=jVQSz9PYQ4vxJcGI',
        'dinosaurus': 'https://www.youtube.com/embed/fTupccciqQs?si=xPYpRWHCMGgoRswV'
    };

    // Funkcija za prikaz tutorijala
    function prikaziTutorijal(igracka) {

        if(igracka === 'žaba'){
            igracka = 'zaba';
        }
        if(igracka === 'kornjača'){
            igracka = 'kornjaca';
        }

        console.log(igracka);

        // Učitaj odgovarajući video iz mape
        const videoSrc = videoLinks[igracka];

        if (videoSrc) {
            // Prikaži video u iframe elementu
            document.getElementById('yt-video').src = videoSrc;
            document.getElementById('tutorial-video').classList.remove('hidden');
        } else {
            // Sakrij video ako nema tutorijala
            document.getElementById('tutorial-video').classList.add('hidden');
        }
    }
</script>
