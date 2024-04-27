<div class="bg-white p-3 pr-5 flex justify-between items-center sticky top-0 shadow-lg" id="navbar">
    <i class="bi bi-list text-xl" id="menu-toggle"></i>
    <a href="{{ auth()->user()->role == 'administrator' ? route('admin.profil') : route('petugas.profil') }}"
        class="font-medium text-lg tracking-wide">{{ auth()->user()->name }} <i
            class="bi bi-person-circle ml-2 {{ auth()->user()->role == 'administrator' ? 'text-blue-400' : '' }} text-xl"></i></a>
</div>

<script>
    $(document).ready(function() {
        $('#menu-toggle').on('click', function() {
            $('#sidebar').toggle('hidden')
        })
    })
</script>
