<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<x-nav>
    <title>CuddleToys - Moj nalog</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/nalog" class="hover:underline">Moj nalog</a>
    </x-path>

    <h2 class="text-3xl font-bold text-purple mt-8 mb-4">Zdravo, {{ $korisnik->ime }}! ♡</h2>

    <div class="flex mt-8">
        <!-- Sidebar meni -->
        <div class="w-1/3 pr-4">
            <ul class="text-dark-pink bg-brighter-peach rounded-lg shadow-lg p-6">
                <li class="mb-2"><button class="hover:underline" onclick="showSection('podesavanja')">Podešavanja naloga</button></li>
                <hr>
                <li class="mt-2 mb-2"><button class="hover:underline" onclick="showSection('pracenje')">Praćenje porudžbina</button></li>

                @can('isAdmin', Auth::user())
                    <hr>
                    <li class="mt-2"><button class="hover:underline" onclick="showSection('statistika')">Statistika</button></li>
                @endcan
            </ul>
        </div>

        <!-- Sadržaj podstranica -->
        <div class="w-3/4">

            @include('korisnici.nalog.podesavanja')

            @include('korisnici.nalog.porudzbine')

            @include('korisnici.nalog.statistika')
        </div>
    </div>
</x-glavni-div>

<x-footer />


@verbatim
<script>
    function showSection(sectionId) {
        // Sakrij sve sekcije
        document.querySelectorAll('.section').forEach(section => {
            section.classList.add('hidden');
        });

        // Prikazi izabranu sekciju
        document.getElementById(sectionId).classList.remove('hidden');
    }
</script>
@endverbatim
