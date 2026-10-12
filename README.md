# WEBA ERP

**Sistem ERP Produksi Berbasis Web dengan Decision Support System Metode Simple Additive Weighting (SAW) untuk Menentukan Prioritas Penyelesaian Produksi**

Studi kasus: PT Weba International, produsen sepatu.

WEBA ERP mengelola produksi dari pesanan pelanggan sampai barang jadi: order produksi, work order per stasiun kerja, bahan baku, pembelian, penerimaan barang, penjualan, faktur, dan pembayaran. Di atasnya terdapat sistem pendukung keputusan yang menilai setiap order yang sedang berjalan dengan metode SAW, lalu menghasilkan peringkat order mana yang harus diselesaikan lebih dulu. Peringkat itu bisa diterapkan langsung ke order produksi sebagai prioritas Mendesak.

---

## Daftar Isi

- [Latar belakang](#latar-belakang)
- [Fitur utama](#fitur-utama)
- [Cara kerja prioritas SAW](#cara-kerja-prioritas-saw)
- [Peran pengguna](#peran-pengguna)
- [Teknologi](#teknologi)
- [Struktur proyek](#struktur-proyek)
- [Kebutuhan sistem](#kebutuhan-sistem)
- [Instalasi](#instalasi)
- [Data demo](#data-demo)
- [Menjalankan evaluasi terjadwal](#menjalankan-evaluasi-terjadwal)
- [Pengujian](#pengujian)
- [Deploy ke shared hosting](#deploy-ke-shared-hosting)
- [Dokumentasi](#dokumentasi)
- [Lisensi](#lisensi)

---

## Latar belakang

Di pabrik sepatu, banyak order produksi berjalan bersamaan sementara mesin, tenaga kerja, dan bahan baku terbatas. Keputusan order mana yang dikerjakan lebih dulu sering diambil berdasarkan perkiraan atau order yang paling sering ditanyakan pelanggan. Akibatnya order yang tenggatnya mepet atau bernilai besar bisa tertunda.

WEBA ERP menjawab masalah itu dengan dua hal:

1. **Pencatatan produksi yang terpusat**, sehingga status, progres, bahan, dan beban kerja setiap order bisa dilihat kapan saja.
2. **Penilaian prioritas yang terukur** dengan metode SAW. Semua order dinilai dengan kriteria dan bobot yang sama, hasilnya tersimpan, dan bisa diperiksa ulang.

## Fitur utama

### Prioritas produksi (modul khusus PT Weba)

- **Panel Kerja Harian**: halaman pembuka untuk setiap peran, berisi order terlambat, status prioritas hari ini, kekurangan bahan baku, angka ringkas, urutan prioritas, beban work center, dan status order. Diperbarui otomatis setiap 60 detik.
- **Dasbor Produksi**: ringkasan produksi, diagram order per status, beban work center, 10 order prioritas teratas, dan order terlambat.
- **Evaluasi SAW**: menjalankan perhitungan peringkat secara manual atau otomatis setiap hari pukul 06.00. Setiap hasil tersimpan sebagai riwayat yang tidak bisa diubah, lengkap dengan matriks keputusan, matriks normalisasi, bobot yang dipakai, dan peringatan data kosong.
- **Terapkan dan batalkan prioritas**: menandai N order teratas sebagai Mendesak dengan catatan otomatis di setiap order. Penerapan bisa dibatalkan tanpa menimpa perubahan yang dibuat orang lain.
- **Monitoring Order**: satu tabel untuk semua order berjalan beserta tenggat, sisa waktu, progres, ketersediaan bahan, sisa jam kerja, urgensi pelanggan, nilai order, dan peringkat SAW terakhir. Manajer dapat mengisi tenggat, urgensi, nilai order, dan menautkan sales order dari sini.
- **Kriteria dan Bobot**: mengatur kriteria SAW, tipe Benefit atau Cost, sumber data, dan bobot, dengan tombol normalisasi agar total bobot tepat 1.
- **Laporan Produksi Harian**: rencana dibandingkan realisasi per work order dalam periode tertentu, dengan efisiensi dan pengelompokan per work center atau order.
- **Ekspor Excel dan PDF**: untuk monitoring, hasil evaluasi, dan laporan harian, dengan kop perusahaan.
- **Hak akses per peran**: empat peran siap pakai dengan izin yang berbeda, ditambah penyembunyian data order dan penjualan bagi pengguna yang tidak berhak.

### Modul ERP

- **Manufaktur**: order produksi, work order (mulai, jeda, selesai), work center, bill of materials, pencatatan hasil produksi.
- **Inventaris**: stok per lokasi, penerimaan, pengiriman, transfer internal, lot, paket, scrap, penyesuaian stok.
- **Pembelian**: permintaan penawaran (RFQ), pesanan pembelian, kontrak pembelian, harga pemasok, tagihan.
- **Penjualan**: penawaran, pesanan penjualan, pengiriman, faktur, pembayaran, nota kredit.
- **Akuntansi**: jurnal, faktur, tagihan, pembayaran, rekening bank, PPN 11%.
- **Lokalisasi Indonesia**: antarmuka bahasa Indonesia, format Rupiah, format tanggal Indonesia, zona waktu WIB.

## Cara kerja prioritas SAW

Setiap order berstatus Dikonfirmasi, Sedang Dikerjakan, atau Siap Ditutup dinilai dengan enam kriteria bawaan:

| Kode | Kriteria | Tipe | Bobot awal |
|---|---|---|---|
| C1 | Sisa waktu menuju tenggat (hari) | Cost | 0,30 |
| C2 | Tingkat urgensi pelanggan (1 sampai 5) | Benefit | 0,20 |
| C3 | Ketersediaan bahan baku (%) | Benefit | 0,15 |
| C4 | Sisa durasi produksi (jam) | Cost | 0,15 |
| C5 | Progres penyelesaian (%) | Benefit | 0,10 |
| C6 | Nilai order (Rp) | Benefit | 0,10 |

Langkah perhitungan:

1. **Matriks keputusan**: nilai setiap kriteria dibaca langsung dari data produksi, stok, dan penjualan.
2. **Normalisasi**: untuk kriteria Benefit, `r = x / max(x)`. Untuk kriteria Cost, `r = min(x) / x`.
3. **Skor**: `V = Σ (w × r)`, bernilai 0 sampai 1. Makin tinggi skornya, makin perlu order itu didahulukan.
4. **Peringkat**: diurutkan dari skor tertinggi. Bila skor sama, tenggat terdekat didahulukan.

Nilai yang kosong, misalnya order tanpa tenggat, dihitung sebagai nilai terburuk dan dicatat sebagai peringatan. Bobot dan kriteria dapat diubah dari menu Kriteria dan Bobot.

## Peran pengguna

| Peran | Tugas utama di sistem |
|---|---|
| Manajer Produksi (PPIC) | Membuat order produksi, mengisi tenggat dan urgensi, menjalankan dan menerapkan SAW, mengatur kriteria, meminta pembelian bahan |
| Supervisor Produksi | Menjalankan dan menyelesaikan work order, memantau beban work center, membaca laporan harian |
| Gudang dan Pembelian | Menjaga stok, membuat RFQ dan pesanan pembelian, menerima barang, mengelola lot |
| Pimpinan | Memantau dasbor, monitoring, hasil SAW, dan laporan tanpa mengubah data |
| Administrator | Mengelola pengguna, peran, perusahaan, dan pengaturan sistem |

Rincian izin setiap peran ada di `plugins/weba/production-priority/src/Support/ProductionRoles.php` dan di buku panduan pengguna.

## Teknologi

| Komponen | Versi |
|---|---|
| PHP | 8.3 atau lebih baru |
| Laravel | 13 |
| Filament | 5 |
| Livewire | 4 |
| Filament Shield | 4 (peran dan izin) |
| Laravel Excel dan DomPDF | ekspor Excel dan PDF |
| Pest | 4 (pengujian) |
| Basis data | MySQL 8, MariaDB 10.4 ke atas, atau PostgreSQL |

## Struktur proyek

```
app/                         Kode inti aplikasi Laravel
bootstrap/  config/  routes/  Konfigurasi dan rute
database/                    Migrasi dan seeder inti
lang/                        Terjemahan Indonesia, termasuk override plugin di lang/vendor
plugins/webkul/              Modul ERP dasar (manufaktur, inventaris, penjualan, pembelian, akuntansi, dan lainnya)
plugins/weba/production-priority/
    src/Filament/            Halaman, cluster, widget, dan aksi (Panel Kerja Harian, Dasbor, SAW, Monitoring, Laporan)
    src/Services/            Logika SAW, pembacaan nilai kriteria, penerapan prioritas, laporan
    src/Support/             Peran, hak akses, dan kelas bantu
    database/                Migrasi dan seeder (kriteria, peran, PPN, data demo)
    resources/               Tampilan Blade, CSS, dan terjemahan
    tests/                   Pengujian Pest untuk modul prioritas
docs/                        PRD, daftar pekerjaan, dokumentasi teknis, dan buku panduan pengguna
mockup/                      Rancangan tampilan dalam HTML
```

Semua pengembangan khusus PT Weba berada di `plugins/weba/production-priority`, sehingga modul ERP dasar tetap utuh dan mudah diperbarui.

## Kebutuhan sistem

- PHP 8.3+ dengan ekstensi `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd`, `intl`, `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, dan `zip`
- Composer 2
- Node.js 20+ dan npm (hanya untuk membangun aset frontend)
- MySQL 8, MariaDB 10.4+, atau PostgreSQL 14+

## Instalasi

```bash
git clone https://github.com/Enjoy90/weba-erp.git
cd weba-erp

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate
```

Atur koneksi basis data di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=weba_erp
DB_USERNAME=root
DB_PASSWORD=
```

Pasang ERP dan modulnya:

```bash
php artisan erp:install
php artisan production-priority:install
php artisan sales:install
php artisan purchases:install
php artisan invoices:install
```

`erp:install` membuat akun administrator pertama. `production-priority:install` sekaligus memasang modul manufaktur dan inventaris yang dibutuhkan, lalu membuat kriteria SAW, empat peran produksi, dan PPN 11%.

Jalankan aplikasi:

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000/admin/login` dan masuk dengan akun administrator.

## Data demo

Untuk mencoba sistem dengan data yang sudah berjalan (produk sepatu, bahan baku, work center, 30 order produksi, pelanggan, pemasok, penjualan, pembelian, faktur, dan pembayaran):

```bash
php artisan db:seed --class="Weba\ProductionPriority\Database\Seeders\DemoDataSeeder"
php artisan db:seed --class="Weba\ProductionPriority\Database\Seeders\DemoBusinessSeeder"
```

Kedua seeder aman dijalankan ulang. Bila datanya sudah ada, seeder dilewati. Buat pengguna untuk setiap peran lewat menu Pengaturan, Pengguna, lalu pilih perannya di bagian Izin.

## Menjalankan evaluasi terjadwal

Evaluasi SAW otomatis dijalankan setiap hari pukul 06.00 lewat scheduler Laravel. Di server, tambahkan cron berikut:

```cron
* * * * * cd /path/ke/weba-erp && php artisan schedule:run >> /dev/null 2>&1
```

Evaluasi juga bisa dijalankan manual:

```bash
php artisan production-priority:run
```

## Pengujian

```bash
php artisan test --compact plugins/weba/production-priority/tests
```

Pengujian memakai basis data terpisah. Atur `DB_DATABASE` untuk pengujian di `phpunit.xml` sebelum menjalankannya.

## Deploy ke shared hosting

Aplikasi dapat dijalankan di shared hosting cPanel tanpa akses terminal:

- Arahkan folder publik domain ke folder `public`, atau letakkan aplikasi di folder domain dengan `.htaccess` yang membelokkan semua permintaan ke `public/`.
- Simpan `.env` di luar folder web pada `<home>/env/<nama-folder-situs>/.env`. Aplikasi otomatis membacanya dari sana bila file itu ada.
- Bila fungsi `symlink` dimatikan hosting, isi `FILESYSTEM_PUBLIC_ROOT` di `.env` dengan jalur `public/storage` agar file unggahan langsung tersimpan di folder publik.
- Pastikan PHP 8.3 aktif dan `APP_DEBUG=false`.

## Dokumentasi

- `docs/Panduan-Pengguna-WEBA-ERP.docx`: buku panduan pengguna untuk setiap peran, lengkap dengan tangkapan layar.
- `docs/Dokumentasi-Teknis-Sistem-ERP-Produksi-SAW.docx`: dokumentasi teknis sistem.
- `docs/PRD-Monitoring-Produksi-SAW.md`: kebutuhan produk dan status setiap fitur.
- `docs/TODO-Custom-Development.md`: rencana dan catatan pengerjaan per fase.

## Lisensi

Proyek ini dibangun di atas ERP open source berlisensi MIT. Lisensi lengkap ada di berkas [LICENSE](LICENSE).

---

Proyek tugas akhir, studi kasus PT Weba International.
