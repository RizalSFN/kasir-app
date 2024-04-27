@extends('layouts.app')

@section('component')
    <div class="flex mt-2 mx-2">
        <div class="flex flex-col w-4/12">
            <label for="kasir" class="font-medium">Kasir </label>
            <input type="text" name="kasir" id="kasir" value="{{ auth()->user()->name }}"
                class="px-2 py-1 bg-gray-300 rounded-md outline-none" readonly>
        </div>
        <div class="flex flex-col mx-2 w-4/12">
            <label for="transaksi_ke" class="font-medium">Transaksi ke</label>
            <input type="text" name="transaksi_ke" id="transaksi_ke" value="{{ $transaksi_ke }}"
                class="px-2 py-1 bg-gray-300 rounded-md outline-none" readonly>
        </div>
        <div class="flex flex-col w-4/12 mr-2">
            <label for="pilih_member" class="font-medium">Pilih Member</label>
            <select name="pilih_member" id="pilih_member">
                <option value="">Pilih Member</option>
                @foreach ($member as $m)
                    <option value="{{ $m->id_member }}" {{ $member_id == $m->id_member ? 'selected' : '' }}>
                        {{ $m->id_member . ' - ' . $m->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col w-4/12">
            <label for="kode_transaksi" class="font-medium">Kode Transaksi</label>
            <input type="text" name="kode_transaksi" id="kode_transaksi" value="{{ $kode_transaksi }}"
                class="px-2 py-1 bg-gray-300 rounded-md outline-none" readonly>
        </div>
    </div>
    <div class="flex mt-5 mx-2">
        <div class="flex flex-col w-8/12 mr-10">
            <form action="{{ route('petugas.transaksi.tambah.keranjang') }}" method="POST"
                class="shadow-lg border rounded-md border-gray-200">
                @csrf
                <h1 class="py-3 font-medium flex items-center text-xl w-full px-5 bg-blue-300 rounded-t-md">
                    <i class="bi bi-box-fill mr-3"></i>
                    Pilih produk
                </h1>
                <input type="hidden" name="kode_transaksi_input" value="{{ $kode_transaksi }}">
                <input type="hidden" name="pilih_member_input" id="pilih_member_input">
                <div class="flex my-3 mx-5">
                    <div class="flex flex-col w-7/12">
                        <label for="pilih_produk" class="font-medium mb-1">Pilih Produk</label>
                        <select name="pilih_produk" id="pilih_produk">
                            <option value="">Pilih Produk</option>
                            @foreach ($produk as $p)
                                <option value="{{ $p->id_produk }}">{{ $p->id_produk . ' - ' . $p->nama }}</option>
                            @endforeach
                        </select>
                        @error('pilih_produk')
                            <label class="text-red-500 font-medium tracking-wide flex items-center">
                                <i class="bi bi-exclamation-circle mr-3"></i>
                                {{ $message }}
                            </label>
                        @enderror
                        <label class="font-medium">Stok tersedia : <span id="stok" class="font-bold">-</span></label>
                    </div>
                    <div class="flex flex-col ml-5 w-5/12">
                        <label for="quantity" class="font-medium mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity" required placeholder="masukkan jumlah beli"
                            class="py-1 px-2 border rounded-md border-gray-400 outline-gray-500">
                        <label class="hidden text-red-500 font-medium tracking-wide" id="stok-alert"></label>
                    </div>
                </div>
                <div class="flex my-3 mx-5">
                    <div class="flex flex-col w-3/12">
                        <label for="harga_satuan" class="font-medium mb-1">Harga Satuan</label>
                        <input type="number" name="harga_satuan" id="harga_satuan"
                            class="px-2 py-1 bg-gray-300 rounded-md outline-none" readonly>
                    </div>
                    <div class="flex flex-col w-1/12 ml-5 mr-3">
                        <label for="diskon" class="font-medium mb-1">Diskon</label>
                        <div class="flex">
                            <input type="number" name="diskon" id="diskon"
                                class="px-2 w-7/12 py-1 bg-gray-300 rounded-l-md outline-none" readonly>
                            <p class="rounded-r-md bg-gray-300 outline-none py-1 px-2">%</p>
                        </div>
                    </div>
                    <div class="flex flex-col w-3/12">
                        <label for="sub_total" class="font-medium mb-1">Sub Total</label>
                        <input type="number" name="sub_total" id="sub_total"
                            class="px-2 py-1 bg-gray-300 rounded-md outline-none" readonly>
                    </div>
                    <button id="tambah-btn"
                        class="py-1 text-center w-5/12 ml-5 mt-6 text-white font-medium bg-blue-500 hover:bg-blue-600 rounded-md">Tambah</button>
                </div>
            </form>
            <div class="shadow-lg border rounded-md border-gray-200 mt-10 ">
                <h1 class="py-3 font-medium flex items-center text-xl w-full px-5 bg-blue-300 rounded-t-md">
                    <i class="bi bi-cart-fill mr-3"></i>
                    Keranjang
                </h1>
                <table class="my-2 border border-gray-200 text-center mx-2">
                    <thead>
                        <tr class="bg-gray-200 text-neutral-400 font-medium text-sm">
                            <td class="w-1/12 py-3">ID PRODUK</td>
                            <td class="w-1/12 py-3">NAMA PRODUK</td>
                            <td class="w-2/12 py-3">JUMLAH BELI</td>
                            <td class="w-1/12 py-3">DISKON</td>
                            <td class="w-1/12 py-3">SUB TOTAL</td>
                            <td class="w-1/12 py-3">AKSI</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($new_keranjang as $k)
                            <tr class="border-b border-gray-200">
                                <td class="py-3">{{ $k->produk_id }}</td>
                                <td class="py-3">{{ $k->produk->nama }}</td>
                                <td class="py-3">
                                    <form action="{{ route('petugas.transaksi.quantity', $k->id) }}" method="POST"
                                        class="flex w-4/12 mx-auto justify-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" id="kurangi" name="kurangi" max="{{ $k->jumlah_beli }}"
                                            min="1"
                                            class="px-2 py-1 border border-r-0 border-gray-300 rounded-l-md w-5/12 outline-none"
                                            value="{{ $k->jumlah_beli }}">
                                        <button
                                            class="px-2 py-1 border border-l-0 border-gray-300 rounded-r-md bg-gray-200 hover:bg-gray-300 font-bold"><i
                                                class="bi bi-floppy"></i></button>
                                    </form>
                                </td>
                                <td class="py-3">{{ $k->diskon ? $k->diskon : '-' }} %</td>
                                <td class="py-3">Rp
                                    {{ $k->diskon ? $k->sub_total_diskon_new : $k->sub_total_normal_new }}</td>
                                <td class="hidden sub_total">
                                    {{ $k->diskon ? $k->sub_total_diskon : $k->sub_total_normal }}</td>
                                <td class="py-3">
                                    <a href="{{ route('petugas.transaksi.hapus.keranjang', $k->id) }}"
                                        class="py-2 px-3 text-white bg-red-400 hover:bg-red-500 rounded-md">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if ($new_keranjang == [])
                            <tr class="border-b border-gray-200">
                                <td class="py-3 font-medium" colspan="6">Belum ada barang</td>
                            </tr>
                        @endif
                        <tr class="border-b border-gray-200">
                            <td class="py-3 font-bold tracking-wide" colspan="4">Total harga </td>
                            <td class="font-bold tracking-wide" colspan="2">Rp <span id="total_harga"></span></td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="py-3 font-bold tracking-wide" colspan="4">Potongan Member </td>
                            <td class="font-bold tracking-wide" colspan="2">Rp <span id="potongan_harga"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form action="{{ route('petugas.transaksi.proses.update', $kode_transaksi) }}" method="POST"
            class="flex flex-col w-4/12">
            @csrf
            @method('PUT')
            @if (session('success'))
                <div
                    class="border border-green-300 text-green-500 bg-green-100 rounded-md flex flex-col text-xl font-medium px-4 py-3 mb-5">
                    {{ session('success') }}
                    <a href="{{ route('petugas.transaksi.struk', session('id')) }}"
                        class="py-2 text-center mt-4 w-5/12 text-white text-lg font-medium bg-indigo-500 hover:bg-indigo-600 rounded-md">Cetak
                        struk</a>
                </div>
            @endif
            <input type="hidden" name="total_pembayaran_input" id="total_pembayaran_input" value="0">
            <input type="hidden" name="kembalian_input" id="kembalian_input">
            <input type="hidden" name="potongan_member" id="potongan_member">
            <div class="border border-gray-300 rounded-md shadow-lg flex flex-col tracking-wide p-3">
                <span class="font-medium text-xl">TOTAL PEMBAYARAN</span>
                <span class="font-bold text-4xl mt-3">Rp <span id="total_pembayaran">0.00</span></span>
            </div>
            <div class="border border-gray-300 rounded-md shadow-lg flex flex-col tracking-wide p-3 mt-5">
                <span class="font-medium text-xl">UANG DITERIMA</span>
                <input type="number" name="uang_diterima" id="uang_diterima" required placeholder="masukkan uang tunai"
                    class="p-2 text-3xl mt-3 border rounded-md font-medium border-gray-400 outline-gray-500">
            </div>
            <div class="border border-gray-300 rounded-md shadow-lg flex flex-col tracking-wide p-3 mt-5">
                <span class="font-medium text-xl">KEMBALIAN</span>
                <span class="font-bold text-4xl mt-3">Rp <span id="kembalian">0.00</span></span>
            </div>
            <div class="flex justify-around mt-5">
                <a href="{{ route('petugas.transaksi') }}"
                    class="py-2 text-center w-5/12 text-white font-medium bg-red-500 hover:bg-red-600 rounded-md">Kembali</a>
                <button id="bayar-btn"
                    class="py-2 text-center w-5/12 text-white font-medium bg-green-500 hover:bg-green-600 rounded-md">Bayar</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#pilih_member').select2({
                placeholder: 'Pilih Member'
            })

            $('#pilih_produk').select2({
                placeholder: 'Pilih Produk'
            })

            $('#pilih_member').change(function() {
                $('#pilih_member_input').val($(this).val())
            })

            $('#pilih_produk').change(function() {
                let id = $(this).val()

                $.ajax({
                    url: '/produk/harga/' + id,
                    type: 'GET',
                    success: function(harga) {
                        $('#harga_satuan').val(harga.harga)

                        $.ajax({
                            url: '/produk/diskon/' + id,
                            type: 'GET',
                            success: function(diskon) {
                                $('#diskon').val(diskon.diskon)

                                $.ajax({
                                    url: '/produk/stok/' + id,
                                    type: 'GET',
                                    success: function(stok) {
                                        $('#stok').text(stok.stok)
                                        if (stok.stok == 0) {
                                            $('#stok-alert')
                                                .removeClass('hidden')
                                                .text(
                                                    'Stok produk habis')
                                            $('#tambah-btn').addClass(
                                                'cursor-not-allowed'
                                            ).attr('disabled',
                                                'true')
                                        } else {
                                            $('#stok-alert').addClass(
                                                'hidden')
                                            $('#tambah-btn')
                                                .removeClass(
                                                    'cursor-not-allowed'
                                                ).removeAttr(
                                                    'disabled')
                                        }
                                    },
                                    error: function(err) {
                                        console.error(err);
                                    }
                                })
                            },
                            error: function(err) {
                                console.error(err);
                            }
                        })
                    },
                    error: function(err) {
                        console.error(err);
                    }
                })
            })

            $('#quantity').on('input', function() {
                let qty = $(this).val()

                $.ajax({
                    url: '/produk/stok/' + $('#pilih_produk').val(),
                    type: 'GET',
                    success: function(stok) {
                        if (stok.stok < qty || qty == '' || qty == 0) {
                            $('#stok-alert').removeClass('hidden').text(
                                'Stok produk tidak mencukupi')
                            $('#tambah-btn').addClass('cursor-not-allowed').attr('disabled',
                                'true')
                        } else {
                            $('#stok-alert').addClass('hidden')
                            $('#tambah-btn').removeClass('cursor-not-allowed').removeAttr(
                                'disabled')
                        }

                        let potongan = $('#harga_satuan').val() * $('#diskon').val() / 100

                        if (qty == '' || qty == 0) {
                            $('#sub_total').val(0 * $('#harga_satuan').val())
                        } else if ($('#diskon').val() != '') {
                            $('#sub_total').val(qty * $('#harga_satuan').val() - potongan)
                        } else {
                            $('#sub_total').val(qty * $('#harga_satuan').val())
                        }
                    },
                    error: function(err) {
                        console.error(err);
                    }
                })
            })

            function updateTotal() {
                let total_harga = 0
                let potongan = 0

                $('.sub_total').each(function() {
                    total_harga += parseFloat($(this).text())
                })

                $.ajax({
                    url: '/diskon',
                    type: 'GET',
                    success: function(data) {
                        if (total_harga >= data.minimum && $('#pilih_member').val()) {
                            potongan = total_harga * data.diskon / 100
                        }
                        $('#potongan_harga').text($.number(potongan, 2, ',', '.'))
                        $('#total_pembayaran').text($.number(total_harga - potongan, 2, ',', '.'))
                        $('#total_pembayaran_input').val(total_harga - potongan)
                        $('#potongan_member').val(potongan)
                    },
                    error: function(err) {
                        console.error(err);
                    }
                })
                $('#total_pembayaran').text($.number(total_harga - potongan, 2, ',', '.'))
                $('#total_pembayaran_input').val(total_harga - potongan)
                $('#total_harga').text($.number(total_harga, 2, ',', '.'))
                $('#potongan_harga').text(potongan)
                $('#potongan_member').val(potongan)

            }

            updateTotal()

            $(document).on('input', '.sub_total', function() {
                updateTotal()
            })

            $('#uang_diterima').on('input', function() {
                let kembalian = $(this).val() - $('#total_pembayaran_input').val()
                $('#kembalian').text($.number(kembalian, 2, ',', '.'))
                $('#kembalian_input').val(kembalian)

                if ($('#kembalian_input').val() < 0 || $('#total_pembayaran_input').val() == 0) {
                    $('#bayar-btn').addClass('cursor-not-allowed').attr('disabled', 'true')
                } else {
                    $('#bayar-btn').removeClass('cursor-not-allowed').removeAttr('disabled')
                }
            })

            if ($('#kembalian_input').val() == '' || $('#total_pembayaran_input').val() == '') {
                $('#bayar-btn').addClass('cursor-not-allowed').attr('disabled', 'true')
            } else {
                $('#bayar-btn').removeClass('cursor-not-allowed').removeAttr('disabled')
            }
        })
    </script>
@endsection
