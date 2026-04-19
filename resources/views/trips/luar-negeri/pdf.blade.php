<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 16pt; font-weight: bold; }
        .header h2 { margin: 5px 0; font-size: 14pt; font-weight: bold; }
        .header p { margin: 5px 0; font-size: 11pt; }
        .title { text-align: center; margin: 20px 0; }
        .title h3 { margin: 0; font-size: 13pt; font-weight: bold; text-decoration: underline; }
        .content { margin: 20px 0; }
        .content table { width: 100%; border-collapse: collapse; }
        .content table td { padding: 5px 0; vertical-align: top; }
        .content table td:first-child { width: 180px; font-weight: bold; }
        .content table td:nth-child(2) { width: 20px; }
        .rincian-biaya { margin-top: 20px; }
        .rincian-biaya table { width: 100%; border: 1px solid #000; border-collapse: collapse; }
        .rincian-biaya table th, .rincian-biaya table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .rincian-biaya table th { background-color: #f0f0f0; }
        .rincian-biaya table td.text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .signature { margin-top: 40px; }
        .signature table { width: 100%; }
        .signature td { vertical-align: top; padding: 10px; }
        .signature .left { text-align: left; }
        .signature .right { text-align: right; }
        .signature-box { display: inline-block; text-align: center; min-width: 200px; }
        .signature-box .name { margin-top: 80px; font-weight: bold; text-decoration: underline; }
        .signature-box .nip { margin-top: 5px; }
        .footer { margin-top: 30px; font-size: 10pt; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KEMENTERIAN/LISTANSI INSTANSI</h1>
        <h2>DIREKTORAT JENDERAL ADMINISTRASI</h2>
        <p>Jl. Jenderal Sudirman Kav. 1-2, Jakarta Pusat</p>
        <p>Telepon: (021) 1234567 | Email: info@instansi.go.id</p>
    </div>

    <div class="title">
        <h3>SURAT PERJALANAN DINAS LUAR NEGERI</h3>
        <p>Nomor: {{ $trip->nomor_surat ?? '........../........../........' }}</p>
    </div>

    <div class="content">
        <p style="margin-bottom: 15px;">Dasar Perjalanan Dinas:</p>
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $trip->nama }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $trip->nip }}</td>
            </tr>
            <tr>
                <td>Pangkat/Golongan</td>
                <td>:</td>
                <td>{{ $trip->pangkat }} / {{ $trip->golongan }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $trip->jabatan }}</td>
            </tr>
            <tr>
                <td>Maksud Perjalanan</td>
                <td>:</td>
                <td>{{ $trip->maksud_perjalanan }}</td>
            </tr>
            <tr>
                <td>Jenis Angkutan</td>
                <td>:</td>
                <td>{{ ucfirst($trip->jenis_angkutan) }}</td>
            </tr>
            <tr>
                <td>Tempat Keberangkatan</td>
                <td>:</td>
                <td>{{ $trip->tempat_keberangkatan }}</td>
            </tr>
            <tr>
                <td>Negara Tujuan</td>
                <td>:</td>
                <td>{{ $trip->tujuan }}</td>
            </tr>
            <tr>
                <td>Tanggal Keberangkatan</td>
                <td>:</td>
                <td>{{ $trip->tanggal_keberangkatan->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Tanggal Kembali</td>
                <td>:</td>
                <td>{{ $trip->tanggal_kembali->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Lama Hari</td>
                <td>:</td>
                <td>{{ $trip->lama_hari }} ({{ $trip->lama_hari }} hari)</td>
            </tr>
        </table>
    </div>

    <div class="rincian-biaya">
        <h4 style="margin: 0 0 10px 0; text-decoration: underline;">RINCIAN BIAYA PERJALANAN DINAS</h4>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">Uraian</th>
                    <th style="width: 20%;">Volume</th>
                    <th style="width: 15%;">Satuan</th>
                    <th style="width: 15%;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Uang Harian ({{ $trip->tujuan }})</td>
                    <td class="text-center">{{ $trip->lama_hari }}</td>
                    <td>Hari</td>
                    <td class="text-right">$ {{ number_format($trip->total_uang_harian, 2) }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Biaya Transport ({{ $trip->jenis_transport ?? '-' }})</td>
                    <td class="text-center">1</td>
                    <td>Paket</td>
                    <td class="text-right">$ {{ number_format($trip->biaya_transport, 2) }}</td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>Biaya Hotel</td>
                    <td class="text-center">1</td>
                    <td>Paket</td>
                    <td class="text-right">$ {{ number_format($trip->biaya_hotel, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="text-center" colspan="4">TOTAL BIAYA</td>
                    <td class="text-right">$ {{ number_format($trip->total_biaya, 2) }}</td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top: 10px; font-style: italic;">
            Terbilang: <strong>{{ app(\App\Http\Controllers\TripController::class)->terbilang($trip->total_biaya) }} Dollar</strong>
        </p>
    </div>

    <div class="signature">
        <table>
            <tr>
                <td class="left">
                    <p>Pejabat Pembuat Komitmen,</p>
                    <div class="signature-box">
                        <div class="name">________________________</div>
                        <div class="nip">NIP. ........................</div>
                    </div>
                </td>
                <td class="right">
                    <p>Jakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                    <p>Yang Bersangkutan,</p>
                    <div class="signature-box">
                        <div class="name">{{ $trip->nama }}</div>
                        <div class="nip">NIP. {{ $trip->nip }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara elektronik dan sah tanpa tanda tangan basah.</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }} WIB</p>
        <p><em>Catatan: Semua biaya dalam mata uang Dolar Amerika Serikat (USD)</em></p>
    </div>
</body>
</html>
