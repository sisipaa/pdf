<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class TripController extends Controller
{
    // Daftar uang harian per kota (dalam negeri)
    private $uangHarianDalamNegeri = [
        'Jakarta' => 500000,
        'Bandung' => 450000,
        'Surabaya' => 450000,
        'Yogyakarta' => 400000,
        'Semarang' => 400000,
        'Medan' => 500000,
        'Makassar' => 500000,
        'Palembang' => 450000,
        'Denpasar' => 500000,
        'Balikpapan' => 550000,
        'Manado' => 500000,
        'Pontianak' => 450000,
        'Banjarmasin' => 450000,
        'Pekanbaru' => 450000,
        'Jambi' => 400000,
        'Padang' => 450000,
        'Malang' => 400000,
        'Solo' => 400000,
        'Mataram' => 450000,
        'Kupang' => 450000,
        'Ambon' => 550000,
        'Jayapura' => 600000,
        'Sorong' => 600000,
        'Ternate' => 550000,
        'Kendari' => 500000,
        'Palu' => 500000,
        'Gorontalo' => 450000,
        'Mamuju' => 550000,
        'Tarakan' => 550000,
        'Tanjung Pinang' => 450000,
    ];

    // Daftar uang harian per negara (luar negeri) dalam USD
    private $uangHarianLuarNegeri = [
        'Singapura' => 150,
        'Malaysia' => 100,
        'Thailand' => 100,
        'Filipina' => 100,
        'Vietnam' => 90,
        'Indonesia' => 50,
        'Korea Selatan' => 180,
        'Jepang' => 200,
        'Taiwan' => 150,
        'Hong Kong' => 180,
        'Tiongkok' => 150,
        'Australia' => 200,
        'Selandia Baru' => 180,
        'Inggris' => 200,
        'Prancis' => 180,
        'Jerman' => 180,
        'Italia' => 180,
        'Spanyol' => 180,
        'Belanda' => 180,
        'Swiss' => 220,
        'Arab Saudi' => 150,
        'Uni Emirat Arab' => 150,
        'Qatar' => 150,
        'India' => 80,
        'Pakistan' => 80,
        'Bangladesh' => 80,
        'Mesir' => 100,
        'Afrika Selatan' => 120,
        'Amerika Serikat' => 200,
        'Kanada' => 180,
        'Brazil' => 150,
        'Argentina' => 120,
    ];

    public function createDalamNegeri()
    {
        $kotaOptions = array_keys($this->uangHarianDalamNegeri);
        return view('trips.dalam-negeri.create', compact('kotaOptions'));
    }

    public function storeDalamNegeri(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_keberangkatan' => 'required|date',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'pangkat' => 'required|string|max:100',
            'golongan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'maksud_perjalanan' => 'required|string',
            'jenis_angkutan' => 'required|in:darat,udara',
            'tempat_keberangkatan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:tanggal_keberangkatan',
            'jenis_transport' => 'nullable|in:luar kota,taxi,dalam kota',
            'biaya_transport' => 'nullable|numeric|min:0',
            'biaya_hotel' => 'nullable|numeric|min:0',
        ]);

        $uangHarianPerHari = $this->uangHarianDalamNegeri[$validated['tujuan']] ?? 400000;
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];
        $biayaTransport = $validated['biaya_transport'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        $totalBiaya = $totalUangHarian + $biayaTransport + $biayaHotel;

        $trip = Trip::create([
            'user_id' => Auth::id(),
            'type' => 'dalam_negeri',
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_keberangkatan' => $validated['tanggal_keberangkatan'],
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'pangkat' => $validated['pangkat'],
            'golongan' => $validated['golongan'],
            'jabatan' => $validated['jabatan'],
            'maksud_perjalanan' => $validated['maksud_perjalanan'],
            'jenis_angkutan' => $validated['jenis_angkutan'],
            'tempat_keberangkatan' => $validated['tempat_keberangkatan'],
            'tujuan' => $validated['tujuan'],
            'lama_hari' => $validated['lama_hari'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'uang_harian_per_hari' => $uangHarianPerHari,
            'total_uang_harian' => $totalUangHarian,
            'jenis_transport' => $validated['jenis_transport'] ?? null,
            'biaya_transport' => $biayaTransport,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
            'mata_uang' => 'IDR',
            'status' => 'pending',
        ]);

        return redirect()->route('trips.dalam-negeri.pdf', $trip->id);
    }

    public function createLuarNegeri()
    {
        $negaraOptions = array_keys($this->uangHarianLuarNegeri);
        return view('trips.luar-negeri.create', compact('negaraOptions'));
    }

    public function storeLuarNegeri(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_keberangkatan' => 'required|date',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'pangkat' => 'required|string|max:100',
            'golongan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'maksud_perjalanan' => 'required|string',
            'jenis_angkutan' => 'required|in:darat,udara',
            'tempat_keberangkatan' => 'required|string|max:255',
            'tujuan' => 'required|string',
            'lama_hari' => 'required|integer|min:1',
            'tanggal_kembali' => 'required|date|after:tanggal_keberangkatan',
            'jenis_transport' => 'nullable|in:luar kota,taxi,dalam kota',
            'biaya_transport' => 'nullable|numeric|min:0',
            'biaya_hotel' => 'nullable|numeric|min:0',
        ]);

        $uangHarianPerHari = $this->uangHarianLuarNegeri[$validated['tujuan']] ?? 100;
        $totalUangHarian = $uangHarianPerHari * $validated['lama_hari'];
        $biayaTransport = $validated['biaya_transport'] ?? 0;
        $biayaHotel = $validated['biaya_hotel'] ?? 0;
        $totalBiaya = $totalUangHarian + $biayaTransport + $biayaHotel;

        $trip = Trip::create([
            'user_id' => Auth::id(),
            'type' => 'luar_negeri',
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_keberangkatan' => $validated['tanggal_keberangkatan'],
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'pangkat' => $validated['pangkat'],
            'golongan' => $validated['golongan'],
            'jabatan' => $validated['jabatan'],
            'maksud_perjalanan' => $validated['maksud_perjalanan'],
            'jenis_angkutan' => $validated['jenis_angkutan'],
            'tempat_keberangkatan' => $validated['tempat_keberangkatan'],
            'tujuan' => $validated['tujuan'],
            'lama_hari' => $validated['lama_hari'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'uang_harian_per_hari' => $uangHarianPerHari,
            'total_uang_harian' => $totalUangHarian,
            'jenis_transport' => $validated['jenis_transport'] ?? null,
            'biaya_transport' => $biayaTransport,
            'biaya_hotel' => $biayaHotel,
            'total_biaya' => $totalBiaya,
            'mata_uang' => 'USD',
            'status' => 'pending',
        ]);

        return redirect()->route('trips.luar-negeri.pdf', $trip->id);
    }

    public function generatePdfDalamNegeri($id)
    {
        $trip = Trip::findOrFail($id);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('trips.dalam-negeri.pdf', compact('trip'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'surat_dinas_dalam_negeri_' . $trip->id . '.pdf';

        // Save PDF
        $pdfPath = storage_path('app/public/pdfs/' . $filename);
        file_put_contents($pdfPath, $dompdf->output());

        $trip->update(['file_pdf' => 'pdfs/' . $filename]);

        return $dompdf->stream($filename);
    }

    public function generatePdfLuarNegeri($id)
    {
        $trip = Trip::findOrFail($id);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('trips.luar-negeri.pdf', compact('trip'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'surat_dinas_luar_negeri_' . $trip->id . '.pdf';

        // Save PDF
        $pdfPath = storage_path('app/public/pdfs/' . $filename);
        file_put_contents($pdfPath, $dompdf->output());

        $trip->update(['file_pdf' => 'pdfs/' . $filename]);

        return $dompdf->stream($filename);
    }

    public function downloadPdf($id)
    {
        $trip = Trip::findOrFail($id);

        if (!$trip->file_pdf) {
            if ($trip->type === 'dalam_negeri') {
                return $this->generatePdfDalamNegeri($id);
            } else {
                return $this->generatePdfLuarNegeri($id);
            }
        }

        $filePath = storage_path('app/public/' . $trip->file_pdf);

        if (!file_exists($filePath)) {
            if ($trip->type === 'dalam_negeri') {
                return $this->generatePdfDalamNegeri($id);
            } else {
                return $this->generatePdfLuarNegeri($id);
            }
        }

        return response()->download($filePath);
    }

    // Helper function untuk terbilang
    public function terbilang($angka)
    {
        $angka = abs($angka);
        $baca = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
        $terbilang = '';

        if ($angka < 12) {
            $terbilang = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $terbilang = $this->terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            $terbilang = $this->terbilang($angka / 10) . ' Puluh' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' Seratus' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = $this->terbilang($angka / 100) . ' Ratus' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' Seribu' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = $this->terbilang($angka / 1000) . ' Ribu' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = $this->terbilang($angka / 1000000) . ' Juta' . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = $this->terbilang($angka / 1000000000) . ' Milyar' . $this->terbilang(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $terbilang = $this->terbilang($angka / 1000000000000) . ' Trilyun' . $this->terbilang(fmod($angka, 1000000000000));
        }

        return $terbilang;
    }
}
