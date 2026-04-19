# Aplikasi Perjalanan Dinas (E-Surat Dinas)

Aplikasi web untuk manajemen surat perjalanan dinas dengan fitur generate PDF otomatis.

## Fitur Utama

### 1. Autentikasi
- Registrasi pengguna dengan field: nama, email, password, jabatan, NIP, pangkat, golongan
- Login dengan email dan password
- Session management

### 2. Dashboard
- Header dengan logo perusahaan dan nama pengguna
- Dua card statistik:
  - Dinas Dalam Negeri
  - Dinas Luar Negeri
- Tabel arsip data pengajuan dinas

### 3. Dinas Dalam Negeri
Form input dengan field:
- Nomor surat
- Tanggal keberangkatan & kembali
- Data pegawai (nama, NIP, pangkat, golongan, jabatan)
- Maksud perjalanan
- Jenis angkutan (darat/udara)
- Tempat keberangkatan
- Tujuan (otomatis menentukan uang harian)
- Lama hari dinas (otomatis)

**Perhitungan otomatis:**
- Uang harian berdasarkan tujuan × jumlah hari
- Transport (opsi: luar kota, taxi, dalam kota)
- Biaya hotel (input manual)
- Total biaya
- Konversi angka ke terbilang (rupiah)

**Output:** Generate file PDF surat dinas

### 4. Dinas Luar Negeri
Fitur serupa dengan dalam negeri, dengan perbedaan:
- Mata uang menggunakan Dolar (USD)
- Uang harian berdasarkan negara tujuan
- Perhitungan total dalam USD
- Terbilang dalam bahasa Indonesia

### 5. Fitur Tambahan
- Penyimpanan data ke database
- Tabel arsip data
- Download ulang file PDF
- Validasi input
- UI responsif dan modern dengan TailwindCSS

## Teknologi

- **Backend:** PHP Laravel 12
- **Frontend:** HTML, CSS, JavaScript (Blade Templates + TailwindCSS)
- **Database:** MySQL / SQLite
- **PDF Generation:** Dompdf

## Instalasi Lokal

### Prasyarat
- PHP 8.2+
- Composer
- MySQL atau SQLite

### Langkah Instalasi

1. Clone repository
```bash
git clone <repository-url>
cd code
```

2. Install dependencies
```bash
composer install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Setup database
```bash
# Untuk SQLite
touch database/database.sqlite

# Untuk MySQL, edit .env dengan kredensial database Anda
```

5. Run migrations
```bash
php artisan migrate
```

6. Create storage link (untuk download PDF)
```bash
php artisan storage:link
```

7. Jalankan development server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Deployment ke Railway

### Langkah Deployment

1. Push kode ke repository GitHub

2. Buka [Railway](https://railway.app) dan login

3. Klik "New Project" → "Deploy from GitHub repo"

4. Pilih repository Anda

5. Tambahkan environment variables:
   - `DB_HOST`: Host database
   - `DB_PORT`: Port database (biasanya 3306)
   - `DB_DATABASE`: Nama database
   - `DB_USERNAME`: Username database
   - `DB_PASSWORD`: Password database

6. Railway akan otomatis build dan deploy aplikasi

7. Setelah deploy, buka URL yang diberikan Railway

## Struktur Database

### Tabel users
- id, name, nama, email, password
- nip, pangkat, golongan, jabatan, role
- remember_token, created_at, updated_at

### Tabel trips
- id, user_id, type (dalam_negeri/luar_negeri)
- nomor_surat, tanggal_keberangkatan, tanggal_kembali
- nama, nip, pangkat, golongan, jabatan
- maksud_perjalanan, jenis_angkutan
- tempat_keberangkatan, tujuan, lama_hari
- uang_harian_per_hari, total_uang_harian
- jenis_transport, biaya_transport, biaya_hotel, total_biaya
- mata_uang (IDR/USD), file_pdf, status
- created_at, updated_at

## License

MIT License
