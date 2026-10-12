# TODO — Pengembangan Fitur Custom ERP Produksi + DSS SAW

Acuan: [PRD-Monitoring-Produksi-SAW.md](PRD-Monitoring-Produksi-SAW.md) (ID fitur A1…E4 merujuk §4 PRD).
Estimasi: **S** ≤ 2 jam · **M** ≤ 1 hari · **L** > 1 hari. Prioritas: **MVP** wajib · **EXT** pelengkap · **OPT** nilai tambah.

> Konvensi (`AGENTS.md`): ikuti struktur file saudara; jangan ubah dependensi tanpa persetujuan; jangan edit `plugins/webkul/*` (kode custom di `plugins/weba/*`); test pakai Pest; format pakai Pint.

---

## Fase 0 — Lingkungan & Instalasi

- [x] **0.1** PHP 8.3.35 terpasang di `D:\php83` + ekstensi (PHP bawaan XAMPP 8.2 tidak boleh dipakai untuk artisan atau composer; pakai `D:\php83\php.exe` atau taruh `D:\php83` paling depan di PATH)
- [x] **0.2** Database `weba_erp` (MySQL XAMPP) + `.env`
- [x] **0.3** `composer install`
- [x] **0.4** `key:generate` + `erp:install` (admin `admin@weba.local`)
- [x] **0.5** Plugin terpasang: `products`, `inventories`, `manufacturing`, `sales`
- [x] **0.6** Server lokal: `serve.bat 8090` di folder project (server bawaan PHP dengan OPcache, tanpa nginx) lalu buka `http://127.0.0.1:8090/admin/login`. Login lokal: `admin@weba.local`
- [x] **0.7** `npm ci` lalu `npm run build` (5 berkas di `public/build`; satu peringatan minify CSS dari kelas Tailwind upstream, tidak berpengaruh) **S**
- [x] **0.8** Plugin `purchases` terpasang (terlihat di Plugin Manager; formulir RFQ `/admin/purchase/orders/quotations/create` terbuka) **S**
- [x] **0.9** Baseline tes hijau, 9 Okt 2026: manufaktur bawaan 38 lulus (99 assertion); sekarang plugin weba unit 312 dan feature 200 lulus. Jalankan feature dengan `php vendor/bin/pest` (bukan `artisan test`) dan **selalu `php artisan optimize:clear` dulu**, karena konfigurasi ter-cache membuat tes menyasar database kerja (ada pengaman di `tests/TestCase.php`) **S**
- [ ] **0.10** Fork/buat repo sendiri; `origin` masih upstream, simpan upstream sebagai `upstream`; commit `.env.example`, `serve.bat`, `docs/` **S** *Catatan 11 Okt:* belum ada satu pun commit; semua pekerjaan Panel Kerja dan sidebar masih berkas belum ter-commit. Rencana commit per fase ada di [TODO-Panel-Kerja-Harian.md](TODO-Panel-Kerja-Harian.md) tugas 7.6 dan menunggu persetujuan.
- [ ] **0.11** Ganti password admin; buat `.env` produksi terpisah nanti **S** *Catatan 11 Okt:* password admin di database kerja lokal sekarang `tes123` (hanya untuk lokal). Password dan `.env` produksi belum dibuat.
- [x] **0.12** Jelajahi alur Sales Order → Manufacturing Order → Work Order → selesai (input untuk C6). Temuan (11 Okt 2026, dari membaca kode): konfirmasi Sales Order **tidak membuat Order Produksi**, karena aturan "manufacture" di `ProcurementRunner` (`runManufactureRules`) masih kosong; form Order Produksi juga tidak punya kolom asal. Jadi tidak ada tautan otomatis dari SO ke MO, dan tautan itu disediakan plugin kita lewat atribut order. Hasilnya menentukan 4.5 dan 8.4. **M**

## Fase 1 — Lokalisasi & Identitas  *(D1–D3)*

- [x] **1.0** Dihitung (12 Okt 2026): aplikasi inti dan 14 plugin yang dipakai memuat sekitar 8.300 kalimat (25 ribu kata) di 670 berkas; Filament dan Filament Shield sudah membawa terjemahan Indonesia sendiri. Diputuskan: draf terjemahan dikerjakan paralel per kelompok plugin dengan glosarium bersama, lalu diperiksa otomatis (berkas lengkap, sintaks PHP, kunci sama persis, placeholder `:nama` dan bentuk jamak sama, tidak ada kalimat Inggris panjang yang tertinggal) **S**

- [x] **1.1** Locale `id` (Bahasa Indonesia) terdaftar di `config/app.php` dengan bendera `public/flags/id.svg`; muncul di pemilih bahasa profil dan pengguna **S**
- [x] **1.2** `lang/id/`: menu grup (`admin.php`), halaman depan (`welcome.php`), dan pesan bawaan Laravel (`validation.php`, `auth.php`, `passwords.php`, `pagination.php`). Teks panel Filament sudah Indonesia dari paket Filament **L**
- [x] **1.3** Terjemahan 14 plugin (support, security, plugin-manager, table-views, chatter, fields, partners, products, inventories, manufacturing, purchases, sales, accounts, invoices): 668 berkas, 7.322 kalimat, semuanya lolos pemeriksa dengan 0 masalah. Diletakkan sebagai *override* di `lang/vendor/<plugin>/id/`, jadi berkas plugin bawaan tidak diubah sama sekali (terverifikasi: `git status plugins/webkul` kosong). Istilah diseragamkan memakai glosarium (mis. Order Produksi, Pesanan Penjualan, Permintaan Penawaran, Pemasok, Tenggat, Dasbor, Nilai Sebelum Pajak). *Sisa diketahui:* dua kata di breadcrumb, "Operations" dan "Orders", berasal dari nama kelas *cluster* di kode plugin bawaan, bukan dari berkas bahasa, sehingga tidak dapat diterjemahkan tanpa mengubah plugin bawaan; nama satuan "Units" adalah data, bukan teks antarmuka **L**
- [x] **1.4** `APP_LOCALE=id` dan `APP_FAKER_LOCALE=id_ID` di `.env.example` (dan `.env` lokal). Pengguna tetap bisa memilih bahasa lain di profil. Pengujian dikunci ke bahasa Inggris di `phpunit.xml` (`APP_LOCALE=en`, `APP_FAKER_LOCALE=en_US`) karena tes bawaan dan tes plugin memeriksa teks Inggris **S**
- [x] **1.5** Rupiah: mata uang perusahaan dan `APP_CURRENCY` sudah IDR; dengan bahasa Indonesia angka otomatis memakai pemisah Indonesia (`Rp 1.234.567,50`). Format tanggal Indonesia ("11 Okt 2026 08:00") dipasang di tabel, infolist, dan pemilih tanggal, hanya saat bahasanya Indonesia (`ProductionPriorityServiceProvider::useIndonesianDateFormats`). Zona waktu Asia/Jakarta **S**
- [x] **1.6** PPN 11% untuk penjualan dan pembelian dibuat `IndonesianTaxSeeder` (dijalankan saat plugin dipasang dan oleh migrasi `2026_10_12_000002_add_indonesian_vat`), dengan grup pajak sendiri dan baris distribusi yang memakai akun yang sama dengan pajak bawaan. Pajak 15% bawaan tidak dihapus. Catatan: tarif PPN mengikuti ketentuan yang berlaku saat sistem dipakai; ubah di menu pajak bila berbeda **S**
- [ ] **1.7** (D3, EXT) Logo/favicon/warna utama (`public/images/logo.svg`, `AdminPanelProvider::colors`) **S**

## Fase 2 — Scaffolding Plugin `weba/production-priority`

- [x] **2.1** **Spike:** plugin kosong di `plugins/weba/production-priority` (pola `plugins/webkul/manufacturing`), `composer dump-autoload`, pastikan ter-discover & muncul di Plugin Manager, bisa `production-priority:install`. Gagal → fallback `plugins/webkul/` + namespace `Webkul\ProductionPriority` **M**
- [x] **2.2** `hasDependencies(['manufacturing','sales'])` (+ `purchases` untuk C4), `hasViews/Translations/Migrations`, install & uninstall command **S**
- [x] **2.3** Navigasi: halaman plugin ada di cluster "Production Priority" dalam grup Manufacturing (tanpa menambah enum). Sejak 10 Okt sidebar menyusun pintasan Order produksi, Work order, Prioritas SAW, Monitoring order, Kriteria dan bobot di atas grup itu; detailnya di [TODO-Panel-Kerja-Harian.md](TODO-Panel-Kerja-Harian.md) Fase 6B **S**
- [x] **2.4** `lang/en` & `lang/id` plugin **S**

## Fase 3 — Mesin SAW  *(A1, A2 — inti penelitian, MVP)*

> **Status:** inti selesai; sisa berkas Excel (3.5) dan form/validasi simpan (3.6, lewat Fase 6.1). Kode: `plugins/weba/production-priority`. Tes: `php artisan test --compact plugins/weba/production-priority/tests/Unit` (40 lulus). Catatan 3.6: validasi bobot ada di `SawCalculator::validateCriteria()` + `normalizeWeights()`; tombol UI-nya dikerjakan di Fase 6.1.
>
> **PERINGATAN tes Feature:** `TestBootstrapHelper` menjalankan `migrate:fresh` + `erp:install`. `phpunit.xml` sekarang memaksa `DB_DATABASE=weba_erp_test` (dibuat manual) dan ada tes penjaga. Jangan hapus override itu, atau tes akan menghapus database dev.

- [x] **3.1** Migrasi `production_priority_criteria` + model `Criterion` + enum `CriterionType`/`CriterionSource` **M**
- [x] **3.2** Seeder 6 kriteria C1–C6 (bobot 0,30/0,20/0,15/0,15/0,10/0,10) — **tandai sementara** **S**
- [x] **3.3** `Services/SawCalculator` (murni): normalisasi, skor, ranking, semua edge case PRD §5.3 **M**
- [x] **3.4** **Unit test Pest** `SawCalculatorTest`: contoh §5.4 (0,840/0,640/0,200 → A>B>C), tiap edge case, validasi total bobot **M**
- [~] **3.5** ≥ 10 dataset uji (**16 kasus selesai**, dihitung independen dengan Python/Fraction di `tests/Fixtures/saw_cases.json`). *Sisa:* file Excel dengan rumus hidup sebagai bukti hitung manual untuk bab pengujian **M**
- [x] **3.6** Validasi bobot: total aktif = 1. `validateCriteria()` di kalkulator (teruji), indikator total bobot di halaman Kriteria, tombol "Normalisasi bobot" (`CriterionWeightNormalizer`, total tepat 1,0000), dan SAW menolak berjalan bila total bobot bukan 1 **S**

## Fase 4 — Data Kriteria & Monitoring Dasar  *(A3, A4, B1–B3)*

> **Status:** 4.1–4.5 selesai; 4.6 menunggu. Kode: `OrderAttribute`, `OrderProgressCalculator` (murni), `OrderProgressService`, `CriterionValueResolver`.
> **Definisi "tersedia" (4.3):** bahan dianggap tersedia bila sudah **ter-reserve** pada move bahan baku order, bukan sekadar ada stok di gudang. Order yang belum di-*check availability* terbaca 0%.
>
> **Cara menjalankan tes:**
> - Unit (cepat, tanpa database): `php artisan test --compact plugins/weba/production-priority/tests/Unit`
> - Feature (±80 dtk, memakai database `weba_erp_test`): `php vendor/bin/pest --colors=never plugins/weba/production-priority/tests/Feature`. **Jangan** pakai `php artisan test` untuk Feature: proses induk artisan kena `set_time_limit(300)` dari `AdminPanelProvider` sehingga run yang lama tampak gagal semua. Jangan jalankan dua run Feature bersamaan (merusak database tes).

- [x] **4.1** (A3) Migrasi + model `OrderAttribute` (1:1 MO: `urgency_level`, `order_value`); relasi ke `Order` via `resolveRelationUsing` (pola `Product::resolveRelationUsing` di `ManufacturingServiceProvider`) **M**
- [x] **4.2** (B1, B2) `OrderProgressService`: progres %, sisa durasi, `daysToDeadline()`, `isLate()`; unit test **M**
- [x] **4.3** (B3) Ketersediaan bahan % dari `rawMaterialMoves` (reserved/needed), fallback `reservation_state`; test **M**
- [x] **4.4** (A4) `CriterionValueResolver`: map `source` → nilai; satu pass, eager loading; test jumlah query **M**
- [x] **4.5** (C6) Nilai order: dari Sales Order yang ditautkan bila ada dan bernilai, selain itu input manual. Karena SO tidak otomatis menjadi MO, tautannya kolom `sale_order_id` di atribut order (tanpa foreign key karena plugin `sales` opsional). Dihitung oleh `OrderValueResolver`: baris SO untuk produk yang sama dengan MO (tanpa baris down payment), bila tidak ada baris itu maka total SO sebelum pajak. **Bukti:** `OrderValueTest` **M**
- [x] **4.6** (A3) UI input urgensi & nilai order: contribution ke form MO bila ada hook; jika tidak → tab/halaman "Atribut Prioritas" sendiri **M**

## Fase 5 — Evaluasi & Penerapan  *(A5, A7, A8)*

> **Status:** 5.1–5.5 selesai; 5.6 (perbandingan dua evaluasi, EXT) belum. Kode: `Evaluation`, `EvaluationItem` (snapshot tidak bisa diubah), `EvaluationService`, `PriorityApplier`, command `production-priority:run`, jadwal harian 06:00.
> **Cara kerja:** hanya order berstatus `confirmed`/`progress`/`to_close` yang dinilai. "Terapkan prioritas" hanya mengubah order yang benar-benar berubah (Normal → Urgent) dan mencatat prioritas lamanya, sehingga pembatalan tidak menimpa perubahan manual orang lain. Tiap penerapan meninggalkan catatan di chatter order.
> **Catatan lingkungan tes:** helper bawaan Aureus (`TestBootstrapHelper`) punya bug di Windows (regex jalur memakai `/`), sehingga tes Feature gagal selang-seling. Sudah diperbaiki 1 baris di `plugins/webkul/support/tests/Helpers/TestBootstrapHelper.php` (juga mengenali folder `plugins/weba`). Jika memperbarui dari upstream dan helper tertimpa, perbaikan ini harus diterapkan ulang.

- [x] **5.1** Migrasi + model `Evaluation` & `EvaluationItem` (snapshot kriteria, nilai mentah, ternormalisasi, skor, rank) **M**
- [x] **5.2** Service jalankan evaluasi: order aktif → resolver → calculator → simpan dalam satu transaksi **M**
- [x] **5.3** Command `production-priority:run` + jadwal harian 06:00 WIB **S**
- [x] **5.4** (A7) Aksi "Terapkan prioritas": top-N → `priority = URGENT` + catatan chatter; bisa dibatalkan **M**
- [x] **5.5** Feature test: snapshot tidak berubah saat bobot diubah; scoping per company **M**
- [ ] **5.6** (A8, EXT) Perbandingan dua evaluasi (perubahan rank) **M**

## Fase 6 — Antarmuka DSS  *(A1, A6, A9)*

> **Status:** 6.1–6.3 selesai (6.4 simulasi bobot, OPT, belum). Menu: **Manufacturing → Prioritas Produksi** dengan tiga halaman: *Monitoring Order* (juga tempat mengisi urgensi dan nilai order lewat tombol per baris), *Kriteria & Bobot*, dan *Hasil Evaluasi SAW*.
> **Verifikasi:** 18 tes Livewire (render halaman, form, semua aksi). Sudah dilihat di browser (screenshot terang, gelap, dan HP) lewat pekerjaan Panel Kerja Harian.
> **Akses:** permission `<aksi>_production_priority_criterion` / `_evaluation` dibuat oleh `production-priority:install`. Monitoring Order mengikuti permission order produksi bawaan. Evaluasi tidak bisa dihapus (jejak audit).

- [x] **6.1** `CriterionResource`: CRUD, urut drag, indikator total bobot **M**
- [x] **6.2** `EvaluationResource`: riwayat, tombol **Jalankan SAW**, detail dengan tab *Matriks Keputusan · Normalisasi · Skor & Ranking* **L**
- [x] **6.3** Daftar order versi monitoring: bar progres, sisa hari, badge **Terlambat**, skor & rank terakhir, filter status **M**
- [ ] **6.4** (A9, OPT) Simulasi bobot (what-if tanpa simpan) **M**

## Fase 7 — Dashboard Monitoring  *(B4–B7)*

> **Status:** 7.1–7.5 selesai, 7.6 sebagian, 7.7 (notifikasi, EXT) belum. Menu: **Dashboard → Dashboard Produksi** (lima widget: ringkasan, order per status, beban work center, 10 ranking SAW teratas, order terlambat). Data order dimuat sekali per request (`ProductionOverview`) dan semua widget memperbarui diri tiap 30–60 detik.
> **Aturan penting untuk widget:** judul dan konfigurasi tabel widget **tidak boleh mengquery database**. Filament Shield menyusun tabel setiap widget untuk membaca labelnya saat `shield:generate` (termasuk dari `erp:install`), sebelum tabel plugin ada. Ada tes regresi untuk ini.

- [x] **7.1** `ProductionStatsWidget`: total aktif, terlambat, jatuh tempo ≤ 3 hari, rata-rata progres (polling 30 dtk) **M**
- [x] **7.2** `OrdersByStatusChart` **S**
- [x] **7.3** `PriorityRankingWidget`: Top 10 SAW terakhir **M**
- [x] **7.4** `LateOrdersTable` **M**
- [x] **7.5** Halaman Dashboard Produksi + permission widget (`HasWidgetShield`) **S**
- [~] **7.6** (B6, EXT) `WorkCenterLoadWidget`: sisa jam kerja per work center dari order berjalan. *Sisa:* membandingkan dengan kapasitas work center (belum, karena butuh kalender kerja dan kapasitas) **M**
- [ ] **7.7** (B7, EXT) Notifikasi database terjadwal untuk terlambat/mendekati deadline **M**
- [~] **7.8** Panel Kerja Harian (desain mockup 5): **selesai** Fase 0 sampai 5 dan Fase 6B (sidebar), dengan 200 tes feature lulus. *Sisa:* tinjauan pemilik terhadap sidebar (B5.7); Fase 7 sudah selesai termasuk commit. Rincian di [TODO-Panel-Kerja-Harian.md](TODO-Panel-Kerja-Harian.md) **L**

## Fase 8 — Fitur ERP Produksi Tambahan  *(C1–C8)*

- [x] **8.1** (C1, MVP) Laporan produksi harian: target vs realisasi per order/mesin (halaman + filter tanggal). Dibuat sebagai halaman Filament `DailyProductionReport` di cluster Production Priority (menu Manufacturing, "Laporan harian"), tanpa tabel baru: datanya dibaca dari work order dan log produktivitas yang sudah ada. Satu baris = satu work order yang dikerjakan (ada log waktu) atau selesai pada periode (bawaan hari ini; filter dari dan sampai). Kolom: order, produk, operasi, work center, status, jumlah order (target), terproduksi, rencana menit (`expected_duration`), realisasi menit (`duration`), efisiensi (rencana dibagi realisasi, hanya untuk work order selesai) dan menit yang dicatat di dalam periode. Bisa dikelompokkan per work center atau per order; total rencana dan realisasi hanya menjumlah work order yang selesai. Izin halaman `page_production_priority_daily_report` (migrasi memberikannya ke peran yang boleh membuka dashboard produksi). 14 tes di `DailyProductionReportTest`. *Batas yang diketahui:* ERP tidak menyimpan jumlah produksi per hari, jadi jumlah dan menit pada baris adalah total work order sampai saat ini; "shift" belum ada karena jam shift PT. Weba belum diketahui (pertanyaan terbuka); halaman sudah siap diekspor di 8.2 dan 8.3. **L**
- [x] **8.2** (C8, MVP) Ekspor Excel (Maatwebsite): ranking SAW, monitoring, laporan harian. Tiga laporan (peringkat SAW di halaman hasil evaluasi, Monitoring order, Laporan produksi harian) dibangun lebih dulu sebagai tabel polos `ReportTable` oleh tiga builder di `Services/Reports/`, sehingga file Excel dan PDF memuat isi yang sama. Tombol "Ekspor ke Excel" dan "Ekspor ke PDF" ada di header ketiga halaman (`ExportReportAction`) dan mengikuti filter yang sedang dipakai di tabel. Angka tetap berupa angka di Excel (bisa dijumlah), judul dan keterangan di atas baris judul kolom yang dicetak tebal dan dibekukan. **Bukti:** `ReportExportTest` (isi berkas dibaca ulang dengan PhpSpreadsheet) **M**
- [x] **8.3** (C8, MVP) Ekspor PDF (DomPDF) dengan kop perusahaan, A4 mendatar, keterangan "dicetak oleh". Kop (`Letterhead`) dibaca dari data Company (nama, alamat, telepon, email), jadi **nama perusahaan di Pengaturan harus diisi "PT. Weba International"**; data demo sekarang masih "My Company". Font PDF DejaVu Sans (bawaan DomPDF, mendukung Unicode); font tampilan aplikasi tidak diubah. *Belum diperiksa mata:* tampilan PDF di PDF reader, karena alat render PDF tidak ada di lingkungan kerja; isi dan pembentukan dokumen sudah diuji **M**
- [x] **8.4** (C6, MVP) Alur Sales Order → Order Produksi: Temuan (11 Okt 2026, dari membaca kode): konfirmasi Sales Order **tidak membuat Order Produksi**, karena aturan "manufacture" di `ProcurementRunner` (`runManufactureRules`) masih kosong; form Order Produksi juga tidak punya kolom asal. Jadi tidak ada tautan otomatis dari SO ke MO, dan tautan itu disediakan plugin kita lewat atribut order. Dikerjakan: pilihan "Sales order" di aksi "Set urgency & value" pada Monitoring (hanya SO terkonfirmasi, bisa dicari), kolom Nilai order menampilkan asal nilai (dari SO atau manual) dan kolom Pelanggan (tersembunyi secara bawaan), nilai itu masuk kriteria C6, tetap jalan tanpa plugin `sales`. 16 tes baru di `OrderValueTest`. *Belum:* tautan otomatis dari SO ke MO bila nanti aturan manufacture bawaan dilengkapi **M**
- [ ] **8.5** (C2, EXT) Migrasi/model `DefectLog` + form catat reject (jumlah, jenis, penyebab) terhubung ke scrap inventori **L** **[DITUNDA, lihat Keputusan Lingkup]**
- [ ] **8.6** (C3, EXT) Jadwal produksi: kalender/Gantt order & work order (pakai plugin `full-calendar`) **L** **[DITUNDA]**
- [ ] **8.7** (C4, EXT) `MaterialShortageService` + halaman kekurangan bahan: kebutuhan − stok − PO berjalan; tombol "Buat RFQ" ke `purchases` **L** **[DIPILIH]** Kartu "Lengkapi bahan baku" di Panel Kerja sudah memakai `ProductionOverview::materialShortages()` (kekurangan per bahan) dan tombol RFQ; 8.7 melengkapinya dengan stok dan PO berjalan.
- [ ] **8.8** (C5, EXT) `ProductionCostService`: HPP per order = bahan + biaya work center (`costs_per_hour × duration`); tampil di detail order & laporan **L** **[DIPILIH]**
- [ ] **8.9** (C7, EXT) Impor Excel (produk, BoM, order awal) dengan template & validasi **L** **[DITUNDA]**

## Fase 9 — Hak Akses & Keamanan  *(E2)*

- [x] **9.1** Policy + permission Shield: Criterion, Evaluation, OrderAttribute, halaman, widget, ekspor. Audit otorisasi seluruh plugin (11 Okt 2026) menemukan celah yang sudah ditutup: (1) Terapkan dan Batalkan prioritas mengubah order tanpa izin order dan tanpa cek kepemilikan; sekarang semua order yang disentuh harus terlihat dan boleh diubah pengguna, bila tidak **tidak ada yang diubah** (semua atau tidak sama sekali), hanya evaluasi terbaru yang bisa diterapkan, ada kunci baris, penerapan yang tidak mengubah apa pun ditolak, dan pembatalan tidak menyentuh order yang sudah selesai. (2) Laporan harian membaca work order tanpa batas perusahaan atau kepemilikan; sekarang hanya work order dari order yang terlihat. (3) Izin halaman dan widget saja sudah membuka data order; sekarang halaman dan widget juga butuh izin baca order (laporan harian dan beban work center juga izin work order), dan evaluasi tidak tampil tanpa izin baca evaluasi. (4) Tautan Sales Order: pilihan hanya muncul bagi yang boleh membaca sales order, hanya SO terkonfirmasi yang terlihat oleh pengguna yang bisa ditautkan (divalidasi di server), dan nilai serta pelanggan SO disembunyikan dari yang tidak berhak. (5) Tombol Terapkan/Batalkan dari Panel Kerja memakai evaluasi yang dilihat pengguna, bukan "yang terbaru saat tombol ditekan". (6) Ekspor Excel tidak lagi menjalankan teks berawalan "=" sebagai rumus; ekspor dibatasi 5000 baris dan tanggal filter yang rusak tidak membuat halaman error. (7) Normalisasi bobot, total bobot dan urutan kriteria hanya untuk perusahaan pengguna. (8) Nilai kriteria per order pada hasil evaluasi dan ekspornya disembunyikan untuk order yang tidak terlihat pengguna. (9) Batas isian: nilai order, catatan, alasan. Tiga izin baru di luar Shield (`apply_production_priority_evaluation`, `set_attributes_production_priority_order`, `export_production_priority_report`) dibuat migrasi dan diberikan ke Admin. **Bukti:** `AuthorizationTest` **M**
- [x] **9.2** Seeder peran. Empat peran dibuat `ProductionRoleSeeder` (dipanggil saat plugin dipasang dan oleh migrasi untuk instalasi yang sudah jalan): Manajer Produksi (PPIC), Supervisor Produksi, Gudang dan Pembelian, Pimpinan (hanya baca). Peran Admin sudah ada. Isi izin tiap peran ada di `Support/ProductionRoles`; peran yang sudah ada tidak ditimpa, jadi perubahan lewat editor peran aman. Ringkas: Manajer = kriteria, jalankan dan terapkan SAW, atur urgensi dan nilai, ekspor, semua halaman; Supervisor = order dan work order (ubah), Panel Kerja, laporan harian, lihat hasil SAW, ekspor, tanpa kriteria dan tanpa terapkan prioritas; Gudang/Pembelian = stok, penerimaan, pengiriman, RFQ/PO, hanya lihat order dan Panel Kerja; Pimpinan = lihat semuanya (dashboard, laporan, hasil SAW, kriteria) dan ekspor, tanpa mengubah apa pun **M**
- [x] **9.3** Test otorisasi per peran + isolasi data. 31 tes di `AuthorizationTest`: matriks fitur per peran, halaman dan widget butuh izin data, order tersembunyi (jangkauan "individual") tidak ikut terubah, terdampak, atau terlihat nilainya, pilihan Sales Order, ekspor, dan bobot per perusahaan. Catatan penguji: aturan kepemilikan data tidak berlaku di konsol, jadi tes yang menguji data tersembunyi menandai dirinya sebagai permintaan web **M**

## Fase 10 — Data Studi Kasus  *(E1)*

- [ ] **10.1** Kumpulkan data PT. Weba: produk, BoM, mesin/stasiun, vendor, customer, contoh order **M** *(butuh narasumber)*
- [ ] **10.2** Seeder master data PT. Weba (atau dummy terdokumentasi bila data nyata belum ada) **M**
- [ ] **10.3** Seeder data uji ≥ 30 order: beberapa terlambat, variasi progres/urgensi/bahan **M**
- [ ] **10.4** Validasi kriteria & bobot dengan PT. Weba (wawancara/kuesioner/AHP) → perbarui seeder 3.2 **M** *(butuh narasumber)*

## Fase 11 — Pengujian & Validasi (bahan Bab Pengujian)

- [ ] **11.1** Uji fungsional black-box: skenario × hasil untuk seluruh fitur MVP **M**
- [ ] **11.2** Uji akurasi: sistem vs Excel (≥ 10 dataset) → selisih 0 **S**
- [x] **11.3** Uji kinerja, 11 Okt 2026 (200 order terbuka, `PerformanceTest`): SAW **0,38 dtk** (target 3 dtk); Panel Kerja **0,63 sampai 0,85 dtk**; tiap widget Dashboard Produksi **0,05 sampai 0,19 dtk** (target 2 dtk); jumlah query tetap untuk 10 dan 200 order **S**
- [ ] **11.4** Perbandingan prioritas manual PPIC vs SAW pada data historis (kesesuaian %, keterlambatan) **M** *(butuh data PT. Weba)*
- [ ] **11.5** UAT + kuesioner (mis. SUS) dengan PPIC/pimpinan **M**
- [ ] **11.6** Regresi: `php artisan test plugins/webkul/manufacturing plugins/weba/production-priority`; `vendor/bin/pint --dirty` **S**

## Fase 12 — Dokumentasi & Penutup  *(E4)*

- [ ] **12.1** Diagram skripsi: use case, activity, ERD (PRD §8.2), flowchart SAW, arsitektur plugin **M**
- [ ] **12.2** Panduan pengguna singkat dengan tangkapan layar **M**
- [ ] **12.3** README proyek (nama, cara install khusus PT. Weba) **S**
- [ ] **12.4** (OPT) Deploy ke server Linux + backup DB **L**

---

## Keputusan Lingkup (11 Okt 2026)

Dijawab untuk pertanyaan PRD §11 nomor 4 dan 5 dari daftar di bawah, supaya urutan kerja tidak menunggu narasumber.

- **Fitur tambahan (EXT) yang dikerjakan setelah semua MVP selesai:** C4 (kekurangan bahan, task 8.7) dan C5 (HPP per order, task 8.8). Alasan: C4 langsung menyuplai kriteria ketersediaan bahan pada SAW dan sudah punya kartu serta tombol RFQ di Panel Kerja; C5 murah karena `costs_per_hour` dan durasi work order sudah ada dan melengkapi sebutan "ERP".
- **Ditunda:** C2 reject (butuh tabel dan formulir baru, tidak memengaruhi SAW), C3 jadwal Gantt, C7 impor Excel. Dikerjakan hanya bila waktu tersisa.
- **Data studi kasus:** data nyata PT. Weba **belum ada**. Dipakai data demo terdokumentasi (`DemoDataSeeder`: 30 order, 5 work center, 4 artikel). Bila data nyata datang, seeder diganti dan hasil SAW dihitung ulang.
- **Kriteria dan bobot:** tetap default C1 sampai C6 sampai divalidasi, ditandai sementara di skripsi.

### Urutan kerja terkini untuk sisa MVP

1. Rapikan dokumen, selesaikan Fase 7 Panel Kerja (regresi akhir, uji 200 order), lalu commit per fase **(menunggu persetujuan commit)**.
2. **C6:** selesai 11 Okt (0.12, 4.5, 8.4).
3. **C1 dan C8:** 8.1 laporan produksi harian, lalu 8.2 ekspor Excel dan 8.3 ekspor PDF (`maatwebsite/excel` dan `dompdf` sudah terpasang, tidak perlu dependensi baru).
4. **E2:** 9.1 sampai 9.3 peran dan hak akses (izin Shield sudah ada; sekarang baru satu peran, Admin).
5. **D1 dan D2:** selesai 12 Okt (1.0 sampai 1.6). Sisa 1.7 logo dan warna (EXT).
6. **E1:** 10.2 sampai 10.3 (seeder sudah ada sebagian), lalu Fase 11 pengujian dan Fase 12 dokumentasi.
7. Setelah semua MVP: 8.7 dan 8.8.

## Urutan Kerja yang Disarankan

**Jalur MVP (skripsi):** `0.7–0.12 → 2.1 → 3 → 4 → 5 → 6 → 7.1–7.5 → 8.1–8.4 → 1.1–1.6 → 9 → 10 → 11 → 12`
**Jika waktu sisa (EXT):** `8.5 → 8.7 → 8.6 → 8.8 → 7.6/7.7 → 8.9 → 5.6 → 1.7`
**OPT:** `6.4`, `12.4`

Fase 3 dikerjakan lebih awal dari UI karena merupakan inti penelitian dan bisa diuji tanpa data manufaktur lengkap.

## Pertanyaan yang harus dijawab (PRD §11)

- [ ] Kriteria & bobot sebenarnya di PT. Weba — mengganti default 3.2 *(sementara memakai default)*
- [ ] Jenis produksi & jumlah mesin/tahap — menentukan 10.2 *(sementara memakai data demo: 5 work center)*
- [x] Ketersediaan data historis: **belum ada** (11 Okt). Dipakai data demo terdokumentasi; 11.4 menunggu data nyata dan dicatat sebagai keterbatasan bila tidak ada
- [x] Apakah pembelian, reject, dan HPP dikelola sistem: **diputuskan** (11 Okt): pembelian (C4) dan HPP (C5) masuk lingkup setelah MVP; reject (C2) ditunda
- [x] Ejaan resmi nama perusahaan: "International" (dikonfirmasi)

## Catatan Keamanan yang Diketahui (setelah Fase 9)

- Pembatasan kepemilikan data (`users.resource_permission`: global, group, individual) berlaku per **pengguna**, bukan per peran. Peran memberi fitur, jangkauan data diatur di profil pengguna. Supervisor yang ingin dibatasi ke ordernya sendiri harus diberi jangkauan "individual".
- Inti Aureus (di luar plugin kita): bila pengguna jangkauan "group" tidak punya tim, `OwnershipScope` tidak membatasi sama sekali (gagal terbuka). Belum diubah karena bukan kode kita; pastikan setiap pengguna "group" punya tim.
- Hasil evaluasi adalah catatan seluruh perusahaan: peringkat dan skor semua order tetap terlihat oleh yang berhak membaca evaluasi, tetapi nama order dan nilai kriterianya disembunyikan untuk order yang tidak terlihat pengguna.
- Pembatalan penerapan prioritas menghapus catatan "diterapkan oleh siapa" dari evaluasi; jejaknya tetap ada di catatan (chatter) tiap order. Riwayat terpisah belum dibuat.
- Evaluasi terjadwal 06:00 memakai SO dari semua perusahaan karena berjalan di konsol; evaluasi manual memakai perusahaan aktif pengguna. Dengan satu perusahaan keduanya sama.
