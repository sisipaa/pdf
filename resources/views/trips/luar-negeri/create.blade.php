@extends('layouts.app')

@section('title', 'Dinas Luar Negeri')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">&larr; Kembali ke Dashboard</a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">Surat Perjalanan Dinas - Luar Negeri</h1>
        </div>

        <form action="{{ route('trips.luar-negeri.store') }}" method="POST" id="tripForm">
            @csrf

            <div class="space-y-6">
                <!-- Informasi Pegawai -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pegawai</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', auth()->user()->nip) }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pangkat</label>
                            <input type="text" name="pangkat" value="{{ old('pangkat', auth()->user()->pangkat) }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Golongan</label>
                            <input type="text" name="golongan" value="{{ old('golongan', auth()->user()->golongan) }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', auth()->user()->jabatan) }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Detail Perjalanan -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Detail Perjalanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat</label>
                            <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keberangkatan</label>
                            <input type="date" name="tanggal_keberangkatan" id="tanggal_keberangkatan" value="{{ old('tanggal_keberangkatan') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lama Hari</label>
                            <input type="number" name="lama_hari" id="lama_hari" value="{{ old('lama_hari') }}" required min="1" readonly
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Keberangkatan</label>
                            <input type="text" name="tempat_keberangkatan" value="{{ old('tempat_keberangkatan') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Negara Tujuan</label>
                            <select name="tujuan" id="tujuan" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Negara</option>
                                @foreach($negaraOptions as $negara)
                                    <option value="{{ $negara }}" data-uang-harian="{{ app(\App\Http\Controllers\TripController::class)->uangHarianLuarNegeri[$negara] }}">{{ $negara }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Angkutan</label>
                            <select name="jenis_angkutan" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jenis</option>
                                <option value="darat">Darat</option>
                                <option value="udara">Udara</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Maksud Perjalanan</label>
                        <textarea name="maksud_perjalanan" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('maksud_perjalanan') }}</textarea>
                    </div>
                </div>

                <!-- Biaya -->
                <div class="border-b pb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Rincian Biaya (USD)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transport</label>
                            <select name="jenis_transport"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Jenis</option>
                                <option value="luar kota">Luar Kota</option>
                                <option value="taxi">Taxi</option>
                                <option value="dalam kota">Dalam Kota</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Transport (USD)</label>
                            <input type="number" name="biaya_transport" id="biaya_transport" value="{{ old('biaya_transport', 0) }}" min="0" step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Hotel (USD)</label>
                            <input type="number" name="biaya_hotel" id="biaya_hotel" value="{{ old('biaya_hotel', 0) }}" min="0" step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Ringkasan Biaya -->
                    <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Uang Harian (<span id="uangHarianLabel">0</span> hari x $<span id="rateLabel">0</span>)</span>
                                <span class="font-medium">$<span id="totalUangHarian">0</span></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Transport</span>
                                <span class="font-medium">$<span id="displayTransport">0</span></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Hotel</span>
                                <span class="font-medium">$<span id="displayHotel">0</span></span>
                            </div>
                            <div class="flex justify-between border-t pt-2 mt-2">
                                <span class="font-semibold text-gray-800">Total Biaya</span>
                                <span class="font-bold text-green-600">$<span id="totalBiaya">0</span></span>
                            </div>
                            <div class="text-sm text-gray-500 italic">
                                Terbilang: <span id="terbilang">-</span> Dollar
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-medium">
                Generate Surat PDF
            </button>
        </form>
    </div>
</div>

<script>
// Hitung lama hari
function hitungLamaHari() {
    const tglKeberangkatan = document.getElementById('tanggal_keberangkatan').value;
    const tglKembali = document.getElementById('tanggal_kembali').value;

    if (tglKeberangkatan && tglKembali) {
        const start = new Date(tglKeberangkatan);
        const end = new Date(tglKembali);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        document.getElementById('lama_hari').value = diffDays;
        hitungBiaya();
    }
}

// Format angka
function formatAngka(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}

// Terbilang function
function terbilang(angka) {
    const baca = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
    let terbilang = '';

    if (angka < 12) {
        terbilang = ' ' + baca[angka];
    } else if (angka < 20) {
        terbilang = terbilang(angka - 10) + ' Belas';
    } else if (angka < 100) {
        terbilang = terbilang(Math.floor(angka / 10)) + ' Puluh' + terbilang(angka % 10);
    } else if (angka < 200) {
        terbilang = ' Seratus' + terbilang(angka - 100);
    } else if (angka < 1000) {
        terbilang = terbilang(Math.floor(angka / 100)) + ' Ratus' + terbilang(angka % 100);
    } else if (angka < 2000) {
        terbilang = ' Seribu' + terbilang(angka - 1000);
    } else if (angka < 1000000) {
        terbilang = terbilang(Math.floor(angka / 1000)) + ' Ribu' + terbilang(angka % 1000);
    } else if (angka < 1000000000) {
        terbilang = terbilang(Math.floor(angka / 1000000)) + ' Juta' + terbilang(angka % 1000000);
    } else if (angka < 1000000000000) {
        terbilang = terbilang(Math.floor(angka / 1000000000)) + ' Milyar' + terbilang(angka % 1000000000);
    }

    return terbilang;
}

// Hitung biaya
function hitungBiaya() {
    const lamaHari = parseInt(document.getElementById('lama_hari').value) || 0;
    const tujuan = document.getElementById('tujuan');
    const selectedOption = tujuan.options[tujuan.selectedIndex];
    const uangHarianPerHari = parseFloat(selectedOption.getAttribute('data-uang-harian')) || 0;
    const biayaTransport = parseFloat(document.getElementById('biaya_transport').value) || 0;
    const biayaHotel = parseFloat(document.getElementById('biaya_hotel').value) || 0;

    const totalUangHarian = lamaHari * uangHarianPerHari;
    const totalBiaya = totalUangHarian + biayaTransport + biayaHotel;

    document.getElementById('uangHarianLabel').textContent = lamaHari;
    document.getElementById('rateLabel').textContent = formatAngka(uangHarianPerHari);
    document.getElementById('totalUangHarian').textContent = formatAngka(totalUangHarian);
    document.getElementById('displayTransport').textContent = formatAngka(biayaTransport);
    document.getElementById('displayHotel').textContent = formatAngka(biayaHotel);
    document.getElementById('totalBiaya').textContent = formatAngka(totalBiaya);
    document.getElementById('terbilang').textContent = terbilang(Math.floor(totalBiaya));
}

// Event listeners
document.getElementById('tanggal_keberangkatan').addEventListener('change', hitungLamaHari);
document.getElementById('tanggal_kembali').addEventListener('change', hitungLamaHari);
document.getElementById('tujuan').addEventListener('change', hitungBiaya);
document.getElementById('biaya_transport').addEventListener('input', hitungBiaya);
document.getElementById('biaya_hotel').addEventListener('input', hitungBiaya);
</script>
@endsection
