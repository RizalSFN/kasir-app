<div class="bg-blue-500 w-2/12 h-screen sticky top-0 flex flex-col justify-between" id="sidebar">
    <div>
        <h1 class="w-full py-6 mt-5 px-4 font-medium text-3xl text-center text-white">Kasir</h1>
        <div class="flex flex-col mt-10 px-5">
            <a href="{{ route('admin.dashboard') }}"
                class="w-full rounded-md py-2 px-3 {{ $title == 'dashboard' ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }} flex items-center font-medium tracking-wide text-lg">
                <i class="bi bi-house-fill mr-3 text-xl"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.produk') }}"
                class="w-full mt-5 rounded-md py-2 px-3 {{ $title == 'produk' ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }} flex items-center font-medium tracking-wide text-lg">
                <i class="bi bi-box-fill mr-3 text-xl"></i>
                Produk
            </a>
            <a href="{{ route('admin.member') }}"
                class="w-full mt-5 rounded-md py-2 px-3 {{ $title == 'member' ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }} flex items-center font-medium tracking-wide text-lg">
                <i class="bi bi-person-fill mr-3 text-xl"></i>
                Member
            </a>
            <a href="{{ route('admin.petugas') }}"
                class="w-full mt-5 rounded-md py-2 px-3 {{ $title == 'petugas' ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }} flex items-center font-medium tracking-wide text-lg">
                <i class="bi bi-person-badge-fill mr-3 text-xl"></i>
                Petugas
            </a>
            <a href="{{ route('admin.diskon') }}"
                class="w-full mt-5 rounded-md py-2 px-3 {{ $title == 'diskon' ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }} flex items-center font-medium tracking-wide text-lg">
                <i class="bi bi-percent mr-3 text-xl"></i>
                Diskon
            </a>
            <a href="{{ route('admin.transaksi') }}"
                class="w-full mt-5 rounded-md py-2 px-3 {{ $title == 'transaksi' ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }} flex items-center font-medium tracking-wide text-lg">
                <i class="bi bi-cart-fill mr-3 text-xl"></i>
                Transaksi
            </a>
            <a href="{{ route('admin.laporan') }}"
                class="w-full mt-5 rounded-md py-2 px-3 {{ $title == 'laporan' ? 'bg-white text-black' : 'text-white hover:bg-white hover:text-black' }} flex items-center font-medium tracking-wide text-lg">
                <i class="bi bi-file-earmark-text-fill mr-3 text-xl"></i>
                Laporan
            </a>
        </div>
    </div>
    <button id="logout"
        class="w-full py-3 text-white font-medium text-lg bg-red-500 hover:bg-red-600 flex justify-center items-center">
        <i class="bi bi-power text-xl mr-3"></i>
        Logout
    </button>
</div>
{{-- modal logout --}}
<div id="overlay" class="hidden absolute z-40 top-0 bottom-0 right-0 left-0 bg-black opacity-35"></div>
<div id="modal"
    class="hidden absolute w-2/12 p-10 z-50 top-1/2 text-center left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-md">
    <label class="font-medium text-xl tracking-wide w-full">Yakin ingin logout?</label>
    <div class="flex justify-center w-full mt-5">
        <a href="{{ route('logout') }}"
            class="py-2 bg-red-500 hover:bg-red-600 font-medium text-white rounded-md text-center w-4/12">Logout</a>
        <button id="close-btn"
            class="w-4/12 rounded-md ml-5 font-medium bg-gray-100 hover:bg-gray-200 text-center py-2">Batal</button>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#logout').on('click', function() {
            $('#overlay').removeClass('hidden')
            $('#modal').removeClass('hidden')
        })

        $('#close-btn').on('click', function() {
            $('#overlay').addClass('hidden')
            $('#modal').addClass('hidden')
        })
    })
</script>
