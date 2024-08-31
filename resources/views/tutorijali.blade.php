<x-nav>
    <title>CuddleToys - Tutorijali</title>
</x-nav>

<x-glavni-div>
    <x-path>
        / <a href="/tutorijali" class="hover:underline"> Tutorijali</a>
    </x-path>

    <x-title>Tutorijali - pretvori maštu u stvarnost</x-title>

    <!-- Select meni za izbor tutorijala -->
    <div class="mb-6">
        <label for="tutorial-select" class="block text-dark-pink font-semibold mb-2">Tutorijal za igračku: </label>
        <x-select id="tutorial-select">
            <x-option value="" isDisabled="yes">Izaberi igračku</x-option>
            <x-option value="frog">Žaba</x-option>
            <x-option value="bear">Medvedić</x-option>
            <x-option value="doll">Lutka</x-option>
        </x-select>
    </div>

    <!--jos neki div o opisu tutorijala ili tako nesto-->

    <!-- Ugrađeni YouTube video koji se menja na osnovu izbora -->
    <div id="tutorial-video" class="flex justify-center mt-10 hidden">
        <!-- Primer: Tutorijal za žabu -->
        <x-iframe id="frog" src="https://www.youtube.com/embed/8KRig-NRMPY?si=KaM7saGgjE-0Zyw7"></x-iframe>
        <x-iframe id="bear" src="https://www.youtube.com/embed/8KRig-NRMPY?si=KaM7saGgjE-0Zyw7"></x-iframe>
    </div>

</x-glavni-div>

<x-footer />

<script>
    document.getElementById('tutorial-select').addEventListener('change', function() {
        var selectedValue = this.value;
        // Sakrij sve video tutorijale
        document.querySelectorAll('#tutorial-video iframe').forEach(function(video) {
            video.classList.add('hidden');
        });

        if (selectedValue) {
            // Prikazi odabrani video tutorijal
            document.getElementById(selectedValue).classList.remove('hidden');
            document.getElementById('tutorial-video').classList.remove('hidden');
        }
    });
</script>
