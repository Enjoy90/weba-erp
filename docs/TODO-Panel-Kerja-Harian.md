# TODO: Penerapan Desain 5 (Panel Kerja Harian) ke Sistem

Acuan tampilan: [mockup/05-panel-kerja-harian.html](../mockup/05-panel-kerja-harian.html). Acuan umum: [PRD](PRD-Monitoring-Produksi-SAW.md), [TODO utama](TODO-Custom-Development.md), `AGENTS.md`.

Estimasi: **S** sampai 2 jam, **M** sampai 1 hari, **L** lebih dari 1 hari.
Aturan: semua kode di `plugins/weba/production-priority`, tidak mengubah `plugins/webkul/*`, test pakai Pest, format pakai Pint, semua teks lewat file terjemahan (id dan en).
Setiap butir dianggap selesai bila: tampil sesuai mockup dengan data demo, punya keadaan kosong (tanpa data), dan punya tes.

---

## Peta bagian mockup ke sistem

| Bagian di mockup | Sumber data yang sudah ada | Yang perlu dibuat |
|---|---|---|
| Sidebar biru bergradasi | Panel memakai navigasi atas (`->topNavigation()`) | Tidak dibuat sekarang (K1, tugas 6.2 ditunda) |
| Kotak cari di atas | Global search Filament sudah aktif | Tidak ada (cukup gaya) |
| Sapaan dan ringkasan | `ProductionOverview::stats()` | 4A |
| Tombol Jalankan SAW | Aksi `runEvaluation` | 4A.3 |
| Tombol Unduh laporan | Belum ada (TODO 8.3) | Tidak dibuat sampai 8.3 selesai (K6) |
| Kartu "Tangani order terlambat" | Logika `LateOrdersWidget`, filter `late` di Monitoring Order | 2.1, 4B.2 |
| Kartu "Terapkan prioritas hari ini" | Aksi `applyPriority` dan `revertPriority` | 2.6, 4B.3 |
| Kartu "Lengkapi bahan baku" | `stats()['material_short']` | 2.3, 4B.4 |
| Empat kotak angka | `stats()` dan query di `WorkCenterLoadWidget` | 2.5, 4C |
| Tab Urutan prioritas | Logika `PriorityRankingWidget` | 4D.2 sampai 4D.4 |
| Tab Beban work center | Query di `WorkCenterLoadWidget` | 2.5, 4D.5 |
| Tab Status order | Logika `OrdersByStatusChart` | 2.7, 4D.6 |
| Info evaluasi terakhir | Model `Evaluation` | 4D.7 |

---

## Fase 0: Keputusan (selesai 9 Okt 2026)

Diputuskan dengan mengikuti saran tim. Tiap keputusan menyebut dampaknya pada tugas lain.

- [x] **K1** Navigasi: awalnya **tetap navigasi atas**. **Direvisi 9 Okt 2026 oleh pemilik:** sidebar kiri bergradasi biru untuk seluruh ERP dengan grup menu produksi disusun ulang (cara 2). Dikerjakan di Fase 6B, sebelum Fase 5.
- [x] **K2** Letak: **halaman baru "Panel Kerja Harian"**, Dashboard Produksi dibiarkan. Alasan: 5 widget lama dan tesnya tetap utuh, dan keduanya bisa dibandingkan saat review.
- [x] **K3** Halaman pertama setelah login: **tetap dashboard bawaan.** Panel Kerja Harian ditaruh di grup Dashboard paling atas. Ditinjau ulang setelah halaman selesai dan dipakai pengguna.
- [x] **K4** Mode gelap: **tidak dimatikan.** Mematikannya mengubah seluruh ERP. Dampak: tugas 3.5 wajib mendefinisikan token warna terang **dan** gelap sejak awal, supaya halaman tidak rusak bagi pengguna bermode gelap. Penyempurnaan tampilan gelap tetap di 5.4.
- [x] **K5** Font: **tetap font bawaan project asli** (diputuskan pemilik, 9 Okt 2026, menggantikan keputusan awal font sistem Segoe UI). Panel Kerja Harian tidak mengatur font sendiri. Dampak: tugas 6.1 **dibatalkan**; mockup memakai Segoe UI hanya sebagai contoh, jadi lebar teks di sistem bisa sedikit berbeda.
- [x] **K6** Tombol "Unduh laporan": **disembunyikan** sampai ekspor PDF (TODO 8.3) jadi. Tombol mati tanpa penjelasan lebih membingungkan daripada tidak ada tombol. Dampak: tugas 4A.4 menjadi catatan saja.
- [x] **K7** Tombol "Buat permintaan pembelian": **arahkan ke form RFQ modul Purchases.** Pembuatan RFQ otomatis tetap di TODO 8.7. Dampak: 4B.4 harus memeriksa nama route form RFQ lebih dulu.

## Fase 1: Persiapan (selesai 9 Okt 2026)

- [x] **1.1** Baseline tes (database tes `weba_erp_test`, PHP 8.3.35, MariaDB 10.4.32):
  - unit plugin weba: **77 lulus**, 207 assertion, 1 detik
  - feature plugin weba: **84 lulus**, 253 assertion, 283 detik
  - manufaktur bawaan Aureus (`plugins/webkul/manufacturing`): **38 lulus**, 99 assertion, 129 detik (sekaligus menutup TODO 0.9)
  - Catatan: pencarian kata "fail" di log memberi positif palsu karena ada tes bernama "it fails when the weights are invalid". Hitung tes gagal dengan tanda ✕ atau ⨯, bukan dengan kata.
- [x] **1.2** `npm ci` (bukan `npm install`, supaya `package-lock.json` tidak berubah, terbukti hash sama) lalu `npm run build`: 5 file di `public/build`, exit 0. Satu peringatan minify CSS (`:is()` kosong) berasal dari kelas Tailwind di template upstream, bukan dari kode kita, tidak berpengaruh. `node_modules` dan `public/build` sudah masuk `.gitignore`.
- [x] **1.3** Branch `feature/panel-kerja-harian` dibuat dari `master` (6fa06d877). Perubahan yang belum di-commit ikut terbawa dan **belum di-commit** (menunggu persetujuan).
- [x] **1.4** `optimize:clear` dan `filament:optimize-clear` dijalankan sebelum tes.
- [x] **1.5** (tambahan, ditemukan saat 1.1) **Pengaman database tes.** Konfigurasi yang ter-cache (`php artisan optimize`, yang dipakai untuk kecepatan) mengabaikan `DB_DATABASE` dari `phpunit.xml`, sehingga tes feature menyasar database kerja dan `TestBootstrapHelper::ensureERPInstalled()` menjalankan `migrate:fresh` di sana. Tes penjaga lama hanya memeriksa variabel lingkungan sehingga tetap lulus. Perbaikan: `tests/TestCase.php` kini menghentikan run dengan pesan jelas **sebelum** helper dipanggil bila koneksi bukan database `*_test` yang dipaksa `phpunit.xml`, dan `TestDatabaseGuardTest` memeriksa ada tidaknya `bootstrap/cache/config.php`. Terbukti dengan cache yang menunjuk database fiktif: run berhenti di pengaman, data kerja utuh. Catatan: penjaga di hook `beforeEach` Pest sempat dicoba dan dibuang karena terlambat (helper berjalan di `setUp()`, sebelum hook itu). **Regresi sesudah perubahan:** unit **78 lulus** (77 lama + 1 tes penjaga baru), feature **84 lulus**, manufaktur **38 lulus**, Pint lulus, situs 5 halaman 200 dengan rata-rata 0,75 detik.

### Aturan kerja sejak Fase 1

1. **Sebelum menjalankan tes:** `php artisan optimize:clear` (pengaman akan menolak run bila lupa).
2. **Sesudah tes dan sebelum menunjukkan hasil:** `php artisan optimize` dan `php artisan filament:optimize` supaya halaman cepat lagi. Baris `views ... FAIL` pada `optimize` normal: komponen `native-top-bar-action` milik upstream tidak punya view, dan tidak berpengaruh.
3. **Sebelum memeriksa komponen baru di browser:** `php artisan optimize:clear` dan `php artisan filament:optimize-clear`.
4. **Jangan menjalankan dua run tes feature bersamaan** (merusak database tes).
5. Cadangan database kerja berisi data demo: `D:\erp-server\backup-weba_erp-dengan-demo.sql`.

## Fase 2: Data (service, belum ada tampilan) (selesai 9 Okt 2026)

Semua bagian halaman mengambil data dari `ProductionOverview` (sudah `scoped`, jadi order dimuat sekali per request).

- [x] **2.1** `lateOrders()`: order terbuka lewat deadline, paling lama terlambat di atas. Jumlahnya selalu sama dengan `stats()['late']` (diuji). **S**
- [x] **2.2** `dueSoonOrders(int $days = 3)`: memakai aturan yang sama dengan `stats()['due_soon']` lewat `ProductionStatsCalculator::isDueSoon()` (satu sumber aturan, tidak ada definisi kedua). Urut dari deadline terdekat. Mockup menghitung per hari, sistem menghitung per jam; ikuti sistem. **S**
- [x] **2.3** `materialShortOrders()` (paling kosong di atas) dan `materialShortages()` / `largestMaterialShortage()`. Aturan urutan bahan: **jumlah order yang tertahan dulu, baru jumlah kekurangan**, karena kuantitas beda satuan tidak bisa dibandingkan. Baris bahan yang dibatalkan atau selesai tidak dihitung. Jumlah query tetap untuk 1 order maupun banyak (diuji). **M**
- [x] **2.4** `toCloseCount()`. **S**
- [x] **2.5** `workCenterLoad()` (objek `WorkCenterLoad`: menit tersisa, jumlah order tanpa dobel hitung, jumlah work order berjalan) dan `remainingWorkHours()` (tambahan, dipakai tile ringkasan). Satu query agregat. Tiga widget lama (`WorkCenterLoadWidget`, `OrdersByStatusChart`, `PriorityRankingWidget`) sudah memakai service ini. **M**
- [x] **2.6** `latestEvaluation()` (memuat `applier`, sekali per request) dan `topRanked(int $limit = 5)` (memuat `order.product`, tanpa query tambahan saat dibaca). Status diterapkan memakai `Evaluation::isApplied()`, `applied_at`, `applier`. **S**
- [x] **2.7** `ordersPerState()`: 5 status berurutan, selalu lengkap walau kosong; order selesai dibatasi `DONE_WINDOW_DAYS` (30 hari). **S**
- [x] **2.8** Tes: 13 unit baru (aturan `isDueSoon` dan `isMaterialShort`) dan 26 feature baru di `tests/Feature/ProductionOverviewTest.php`. **M**

**Regresi sesudah Fase 2:** unit **91 lulus**, feature **110 lulus** (84 lama + 26 baru, `DashboardTest` utuh setelah widget dipindah ke service), Pint lulus.

## Fase 3: Kerangka halaman (selesai 9 Okt 2026)

- [x] **3.1** `WorkPanel` di `src/Filament/Pages/WorkPanel.php`: slug `work-panel` (URL `/admin/work-panel`), grup Dashboard, `navigationSort` -3 (di atas Dashboard bawaan yang -2), tanpa ikon seperti `ProductionDashboard`. Dashboard lama tidak diubah. **S**
- [x] **3.2** Permission `page_production_priority_work_panel` lewat `HasPageShield` dan `getPagePermission()`. Tidak perlu entri di `config/filament-shield.php` plugin (file itu hanya untuk resource dan pengecualian). Permission dibuat dengan `shield:generate --all --option=permissions --panel=admin` (1159 permission, tidak ada policy baru), sudah ada di database kerja. Super admin lolos lewat gate bawaan; role lain harus diberi permission ini lewat layar Role. Izin Dashboard lama tidak membuka panel baru (diuji). **S**
- [x] **3.3** View `resources/views/filament/pages/work-panel.blade.php` memakai `x-filament-panels::page` dan `x-filament::section`. Isinya sementara satu kalimat penanda; **hapus kalimat itu (kunci `skeleton.notice`) di tugas 4A.1**. **S**
- [x] **3.4** `resources/dist/work-panel.css` didaftarkan di `ProductionPriorityServiceProvider::registerWorkPanelCss()` lewat `FilamentAsset::register` (paket `production-priority`), lalu `php artisan filament:assets`. Hasil publikasi ada di `public/css/production-priority/work-panel.css` dan **harus ikut di-commit**, seperti `public/css/chatter` milik plugin lain (folder `public/css` dilacak git). Setiap kali CSS berubah, jalankan `filament:assets` lagi. Semua class diawali `wp-`. **S**
- [x] **3.5** Token warna terang dan gelap (`.wp-root` dan `.dark .wp-root`). Hasil pemeriksaan kontras (teks minimal 4,5; grafik minimal 3):
  - Biru aksen **mengikuti `--primary-*` milik Filament** (terang: 50, 600, 700, 900; gelap: 400, 300, 200), supaya sama dengan tombol bawaan (K4). Biru mockup `#2a78d6` sengaja ditinggalkan karena berbeda dari `Color::Blue` panel (`#155dfc`).
  - Semua pasangan teks lulus di kedua tema (terendah 4,73 untuk teks pudar di atas putih).
  - Ikon peringatan terang dinaikkan dari `#c98500` (2,81) ke `#9a6600` (4,49).
  - Deret 5 warna status versi gelap disusun ulang karena yang pertama gagal (2,55); sekarang 3,22 sampai 12,68, selisih antarlangkah 1,24 sampai 1,77.
  - **Catatan jujur:** deret status versi terang (`#86b6ef`, `#5598e7`) tetap di bawah 3:1 terhadap putih (2,11 dan 2,99), sama seperti mockup. Aman hanya selama setiap segmen punya label dan angka; ini menjadi syarat di tugas 4D.6. **S**
- [x] **3.6** `resources/lang/{id,en}/filament/work-panel.php` (judul menu dan kalimat penanda). Teks lain ditambahkan per bagian di Fase 4. **S**
- [x] **3.7** 12 tes di `tests/Feature/WorkPanelTest.php`: terbuka untuk admin dan untuk user ber-permission, ditolak (403, lewat Livewire dan lewat HTTP penuh) untuk user tanpa permission, menu tersembunyi untuk user itu, izin Dashboard lama tidak cukup, posisi menu, label dua bahasa, halaman penuh memuat `wp-root` dan tautan `work-panel.css`, CSS terang dan gelap punya set token yang sama, aksen mengikuti warna primer panel. **S**

**Regresi sesudah Fase 3:** unit **91 lulus**, feature **122 lulus** (110 + 12 baru), manufaktur bawaan **38 lulus**, Pint lulus. Di dev server: `/admin/work-panel` mengarah ke login (302) bila belum masuk, CSS dilayani 200.

## Fase 4: Bagian halaman, satu per satu (selesai 9 Okt 2026)

Semua bagian sudah tampil di `/admin/work-panel` dengan data demo, terang dan gelap, dan diperiksa lewat screenshot browser nyata (Edge) serta 33 tes baru.

### 4A. Kepala halaman
- [x] **4A.1** Sapaan lewat `getHeading()` bawaan Filament (bukan blok sendiri): pagi 04.00 sampai 10.59, siang 11.00 sampai 14.59, sore 15.00 sampai 17.59, selain itu malam; nama dari user yang login. Aturan jam ada di enum `DayPeriod` (diuji per jam). Kalimat penanda Fase 3 sudah dihapus. Catatan: jam mengikuti zona waktu aplikasi, bukan zona waktu browser. **S**
- [x] **4A.2** `getSubheading()`: tanggal panjang, jumlah terlambat, jumlah jatuh tempo (angka sama dengan `stats()`). Redaksi sengaja netral jumlah ("Order terlambat: 3") supaya benar untuk 1 maupun banyak. **S**
- [x] **4A.3** Tombol Jalankan SAW = aksi header `runEvaluation` (`RunEvaluationAction`, kini punya opsi tidak berpindah halaman). Tersembunyi untuk user tanpa izin membuat evaluasi (diuji). Setelah jalan, halaman tetap di panel dan kartu langsung berubah. **S**
- [x] **4A.4** Tidak ada tombol Unduh laporan (K6). **S**

### 4B. Tiga kartu tugas
- [x] **4B.1** Komponen `x-production-priority::work-panel.task-card` (nada merah, biru, kuning; chip maksimal 4 lalu "dan N lainnya"; slot tombol). **S**
- [x] **4B.2** Kartu terlambat: chip menuju detail order, tombol menuju Monitoring Order dengan filter `late` aktif. Tautan itu **diuji benar-benar menyaring** (hanya order terlambat yang tampil). Kosong: "Tidak ada order terlambat." **S**
- [x] **4B.3** Kartu prioritas, tiga keadaan: belum ada evaluasi (tombol Jalankan SAW), siap diterapkan (tombol memakai aksi `applyPriority`, nilai awal 5 atau kurang), sudah diterapkan (menyebut siapa, kapan, berapa order; tombol Batalkan memakai `revertPriority` dengan konfirmasi). Aksi Terapkan dan Batalkan dipindah dari `ViewEvaluation` ke kelas `ApplyPriorityAction` dan `RevertPriorityAction` supaya dipakai bersama; 18 tes lama halaman evaluasi tetap lulus. Tombol hanya muncul bagi yang punya izin ubah evaluasi. **M**
- [x] **4B.4** Kartu bahan baku: jumlah order kurang bahan, bahan dengan kekurangan terbesar. Route form RFQ dicek: `filament.admin.purchase.orders.resources.quotations.create` (`/admin/purchase/orders/quotations/create`). Tombol disembunyikan bila plugin `purchases` tidak terpasang atau user tidak boleh membuat (diuji untuk kasus tidak terpasang). **Kasus terpasang diperiksa manual di server dev** (tautan menjawab 200), belum lewat tes Pest karena database tes tidak memasang `purchases`. **S**

### 4C. Kotak angka
- [x] **4C.1** Komponen `stat-tile`: order aktif, jatuh tempo 3 hari, rata-rata progres, sisa beban kerja (jam). **S**
- [x] **4C.2** Tanda tanya dengan tooltip Filament (`x-tooltip`), ditambah teks yang sama untuk pembaca layar dan label tombol. **S**

### 4D. Panel bertab
- [x] **4D.1** Tab Filament dengan jumlah di lencana. Tab aktif tersimpan di alamat (`?tab=work-centers`), tab yang tidak dikenal jatuh ke tab pertama. Saringan baris juga di alamat (`?show=attention`). **S**
- [x] **4D.2** Tabel Filament: prioritas, order (nomor, artikel, jumlah dan satuan), status (titik warna dan label), deadline (lencana berikon, memakai aturan yang sama dengan kartu), progres (batang), skor 4 desimal. Paginasi 25 per halaman. Penjelasan skor ada di bar alat (pengganti tooltip di kepala kolom, yang tidak didukung langsung). **M**
- [x] **4D.3** Saringan Semua, Perlu perhatian (terlambat atau jatuh tempo, memakai `ProductionOverview`), Sedang dikerjakan. **S**
- [x] **4D.4** Aksi baris "Buka" menuju detail order. Berbeda dari mockup: **selalu terlihat**, tidak hanya saat kursor di atas baris, supaya terjangkau layar sentuh dan keyboard. **S**
- [x] **4D.5** Tab beban work center: batang horizontal (jam tersisa, dengan angka) dan tabel order menunggu dan berjalan. **S**
- [x] **4D.6** Tab status order: batang bertumpuk dengan legenda berangka (jumlah dan persen) sehingga warna bukan satu-satunya pembawa informasi (syarat catatan 3.5 terpenuhi). **S**
- [x] **4D.7** Bagian bawah: nama dan waktu evaluasi terakhir, tautan ke halaman Hasil Evaluasi SAW. **S**

### 4E. Penyegaran data
- [x] **4E.1** `wire:poll.60s.visible` di akar halaman: memuat ulang tiap 60 detik hanya saat tab browser terlihat. Tab dan saringan yang dipilih tetap (diuji dengan `$refresh`). Kekurangan yang diketahui: poll ikut jalan saat modal terbuka (data modal tidak hilang, tetapi layar di belakangnya ikut menyegar). **S**

### Temuan selama Fase 4 (untuk reviewer)

1. **Izin halaman baru tidak otomatis sampai ke role.** Shield hanya membagikan izin saat plugin dipasang, sehingga di instalasi yang sudah jalan admin mendapat 403. Dibuat migrasi `2026_10_09_000001_grant_work_panel_permission` (didaftarkan di service provider): setiap role yang boleh membuka Dashboard Produksi otomatis boleh membuka Panel Kerja Harian. Aman diulang (diuji). Sudah dijalankan di database kerja setelah cadangan `D:\erp-serverackup-weba_erp-sebelum-fase4.sql`. **Saat deploy ke hosting: jalankan `php artisan migrate`.**
2. **Kelas `sr-only` tidak ada** di CSS bawaan Filament, sehingga judul bagian tak terlihat ikut tampil dan menggeser kartu. Diganti kelas sendiri `wp-sr-only`. Ditemukan lewat screenshot, bukan lewat tes.
3. **Cache CSS browser.** Filament memberi alamat aset `work-panel.css?v=<versi Filament>`, yang tidak berubah saat CSS kita berubah, jadi browser pengguna bisa memakai CSS lama setelah pembaruan. Belum ditangani (usul: tambahkan hash isi file pada alamat aset) dan dicatat sebagai risiko kecil.
4. **Server dev memakai OPcache tanpa cek perubahan file**, jadi view Blade baru tidak terbaca sampai `D:\erp-server\stop.bat` lalu `start.bat` dijalankan. Tidak berlaku untuk tes.
5. **Pelajaran tes** (agar tes berikutnya tidak mengulang): (a) user buatan factory tidak aktif sehingga ditolak panel dengan 403 sebelum izin halaman diperiksa; dua tes akses Fase 3 sebelumnya sebenarnya menguji hal yang salah dan sudah diperbaiki; (b) `SecurityHelper` mem-flush registrar izin Spatie, sedangkan aplikasi memakai `Webkul\Security\PermissionRegistrar`, jadi izin yang baru diberikan tidak terbaca sampai registrar itu di-flush; (c) `ProductionOverview` bersifat scoped dan bertahan antar `Livewire::test` dalam satu tes, jadi hitung query harus memanggil `forgetScopedInstances()` dulu; (d) membuat order mendaftarkan callback notifikasi chatter yang dijalankan ulang tiap request berakhir, jadi harus dikosongkan agar jumlah query tidak ikut membesar.
6. Jumlah query halaman **tetap** untuk 1 order maupun 6 order (diuji, termasuk tabel).

**Regresi sesudah Fase 4:** unit **102 lulus**, feature **155 lulus** (122 + 33 baru), manufaktur bawaan **38 lulus**, Pint lulus. Semua tautan di halaman live menjawab 200.

## Fase 5: Responsif dan aksesibilitas (selesai 11 Okt 2026)

- [x] **5.1** Di bawah 1180 px kartu tugas satu kolom dan kotak angka dua kolom (aturan sudah ada dari Fase 3). Diukur di browser pada 1440, 1100, 768, dan 500 px: kolom kartu 3, 1, 1, 1; kolom kotak angka 4, 2, 2, 2; **halaman tidak pernah melebar ke samping**. Ditambah tes yang menjaga aturan CSS-nya. **Bukti:** pengukuran dan screenshot 500 dan 768 px. **S**
- [x] **5.2** Di HP (500 px) deretan tab bisa digeser ke samping (isi 1 baris lebih lebar dari wadahnya) dan wadah tabel punya `overflow-x: auto`; yang bergeser hanya wadahnya, bukan halaman. Edge headless tidak mau lebih sempit dari 500 px, jadi 390 px belum dicoba. **Bukti:** pengukuran dan screenshot. **S**
- [x] **5.3** Aksesibilitas, diukur di browser: (a) **tab** kini memakai pola tab sungguhan: `role="tablist"`, `role="tab"`, `aria-selected`, `aria-controls`, hanya tab terbuka yang ada di urutan Tab (`tabindex`), panel `role="tabpanel"` yang menunjuk tab terbuka lewat `aria-labelledby`, dan navigasi **panah kiri dan kanan, Home, End** (diuji dengan tombol sungguhan di browser: tab dan isi panel ikut berpindah, tanpa error JS); (b) **23 batang progres** kini punya nama ("Progres order MO/00001", dua bahasa); (c) status selalu berupa **teks di samping titik atau ikon** (lencana deadline memakai ikon dan teks); (d) **fokus keyboard**: seluruh 40 elemen yang bisa difokus di panel (chip, tombol, tanda tanya, tab, saringan, aksi Buka) menampilkan garis fokus 2 px; (e) **ukuran sentuh**: chip order dinaikkan dari 22 ke 24 px, dan area tanda tanya penjelasan diperbesar ke 24 px lewat `::after` tanpa mengubah tampilannya (pengukur otomatis masih melaporkannya 16 px karena hanya mengukur elemennya, bukan area `::after`); (f) judul berurutan H1, H2, H3, dan ada landmark `main`. **Bukti:** pengukuran browser dan 5 tes. **S**
- [x] **5.4** Mode gelap diperiksa dengan pengukur kontras otomatis di browser (warna dibaca lewat kanvas karena Filament memakai oklch): **0 teks yang gagal dari 410 teks per tema** (253 + 85 + 72 di tiga tab; 4,5 untuk teks biasa, 3 untuk teks besar), terang dan gelap, ditambah screenshot gelap di 500 px. Tidak ada warna yang perlu diubah. **Catatan:** kontras ikon dan batang (3 banding 1) sudah dihitung di 3.5, bukan di pengukur ini. **Bukti:** hasil pengukuran. **M**

**Regresi sesudah Fase 5:** unit **312 lulus**, feature **200 lulus** (191 + 8 tes aksesibilitas dan responsif + 1 tes kecil lain), manufaktur **38 lulus**, Pint lulus.

## Fase 6: Tampilan global

- [x] **6.1** ~~Font sistem untuk seluruh panel~~ **Dibatalkan** (K5): font tetap bawaan project asli. Tidak ada perubahan font di panel mana pun.
- [ ] **6.2** Sidebar kiri: dipecah menjadi tugas B0 sampai B5 di Fase 6B di bawah (keputusan pemilik 9 Okt 2026). **M**
- [x] **6.3** Angka order terlambat di menu: dikerjakan di **B3.9**. **S**

## Fase 6B: Sidebar kiri bergradasi biru (cara 2, grup disusun ulang)

**Keputusan pemilik, 9 Okt 2026:** K1 diubah. Menu atas diganti sidebar kiri untuk seluruh ERP, dengan grup menu produksi disusun mirip mockup 5 (cara 2). Aturan emas: **tidak ada menu yang hilang**, hanya dipindah dan diurutkan ulang. Dikerjakan **sebelum Fase 5** karena sidebar memengaruhi tampilan HP. Font tidak berubah (K5).

Setiap butir punya **Bukti selesai** supaya bisa diaudit satu per satu. Butir baru dianggap selesai bila buktinya ada.

### Fakta awal (hasil pemeriksaan kode, belum ada perubahan)

- Panel admin memakai `->topNavigation()` di `app/Providers/Filament/AdminPanelProvider.php` baris 52. Panel pelanggan (`CustomerPanelProvider`) juga memakai menu atas dan **tidak diubah**.
- Menu asli sekarang 9 grup: Dashboard, Sales, Purchase, Manufacturing, Inventory, Invoices, Plugins, Settings, Help. Banyak item berupa cluster ("Operations", "Products", "Configurations", "Settings") yang membuka sub-menu sendiri di dalam halaman, bukan daftar halaman datar seperti di mockup.
- Repo sudah siap untuk sidebar: ada aturan RTL untuk `.fi-sidebar` di `resources/css/app.css`, dan `SupportPlugin` menggulir item sidebar yang aktif ke tengah.
- Filament punya `Panel::navigation(Closure)` (susunan buatan sendiri) dan `NavigationManager` (daftar item bawaan). Cara mana yang dipakai diputuskan di spike B1.
- Mockup menampilkan "Laporan produksi", yang **belum punya halaman** (TODO 8.x). Menunya tidak dibuat sampai halamannya ada.

### Pemetaan menu (disahkan di B0.3)

| Grup | Item di mockup | Halaman asli | Catatan |
|---|---|---|---|
| Dashboard | Panel kerja harian | `WorkPanel` | |
| Dashboard | Dashboard produksi | `ProductionDashboard` | |
| Manufaktur | Order produksi | `ManufacturingOrderResource` (daftar) | lencana merah jumlah order terlambat |
| Manufaktur | Work order | `WorkOrderResource` | |
| Manufaktur | Prioritas SAW | `EvaluationResource` | hasil evaluasi |
| Manufaktur | (tambahan) Monitoring order | `OrderMonitoringResource` | tidak ada di mockup, tetapi fitur nyata |
| Manufaktur | Kriteria dan bobot | `CriterionResource` | |
| Manufaktur | sisa item asli | Products, Configurations, Settings modul manufaktur | tetap, di bawah item pilihan |
| Persediaan | Stok bahan | Quantities atau Overview modul inventori | dipastikan di B0.3 |
| Persediaan | sisa item asli | tetap | di bawah item pilihan |
| Pembelian | Pembelian | Purchase Orders | |
| Pembelian | sisa item asli | tetap | di bawah item pilihan |
| Laporan | Laporan produksi | belum ada | tidak dibuat |
| Grup lain | Sales, Invoices, Plugins, Settings, Help | tidak berubah | tampil di bawah grup di atas |

### B0. Persiapan dan baseline (tidak mengubah kode)

- [x] **B0.1** Potret menu lama ada di `docs/arsip/menu-sebelum-sidebar.md`: admin 9 grup dan 35 item; user tanpa role 2 grup dan 2 item (Sequences dan Help). User sementara dibuat lalu dihapus dalam transaksi, jumlah user tetap 1. **Bukti:** berkas ada. **S**
- [x] **B0.2** Cadangan: `D:\erp-server\backup-weba_erp-sebelum-sidebar.sql` (1,2 MB). **Cara kembali ke menu atas** (semua perubahan sidebar belum di-commit): (1) `git checkout -- app/Providers/Filament/AdminPanelProvider.php resources/views/vendor/filament-panels/livewire/sidebar.blade.php`; (2) `php artisan optimize:clear`; (3) `D:\erp-server\stop.bat` lalu `start.bat`. Perubahan berikutnya (B3, B4) menambah berkas baru di plugin weba; cara kembalinya dicatat di tugas masing-masing. **Bukti:** berkas dan langkah. **S**
- [x] **B0.3** Pemetaan disahkan lewat skrip yang memanggil `getUrl()` tiap class (semua ada, semua tampil di menu). **Dua koreksi dari rencana awal:** (a) di gambar sidebar mockup, **"Pembelian" adalah item di bawah grup Persediaan**, bukan grup sendiri; (b) "Stok bahan" = `QuantityResource` modul inventori, `/admin/inventory/operations/quantities`. Usulan untuk "Pembelian": `/admin/purchase/orders` (item "Orders" bawaan modul Purchase, dipindah); keputusan akhir di audit sebelum B3.2. Order produksi `/admin/manufacturing/operations/manufacturing-orders`, Work order `/admin/manufacturing/operations/work-orders`, Prioritas SAW `.../production-priority/evaluations`, Monitoring order `.../monitoring`, Kriteria dan bobot `.../criteria`. **Bukti:** daftar class dan alamat. **S**
- [x] **B0.4** Baseline tes: unit 102, feature 155, manufaktur 38, semuanya lulus. Waktu muat (median 5 kali, server dev ber-cache): login 0,20 detik, Dashboard Produksi 0,25, Panel Kerja 0,28, Order Produksi 0,24, Inventori 0,27. **Bukti:** angka. **S**
- [x] **B0.5** Screenshot sebelum: 9 gambar (Panel Kerja, Dashboard Produksi, Order Produksi, Inventori; terang, gelap, HP) di folder kerja sementara `shots-before`, bukan di repo. Catatan: Edge headless tidak mau lebih sempit dari 500 px, jadi "HP" diambil di 500 px, bukan 390. **Bukti:** berkas gambar. **S**

### B1. Spike teknis (kode coba, dibuang bila gagal, tidak masuk produksi)

- [x] **B1.1** Cara builder `Panel::navigation(Closure)` **ditolak lewat pemeriksaan API, tidak dibuat prototipe penuh**: `NavigationBuilder` hanya punya `group`, `item`, `groups`, `items`, `getNavigation`, `when`, `unless`, tanpa akses ke daftar bawaan, dan memanggil `NavigationManager::get()` dari dalam builder akan berputar karena `get()` memanggil builder bila ada. Memakainya berarti menyalin logika pengelompokan, pengurutan, dan visibilitas Filament (sekitar 90 baris) yang bisa melenceng saat Filament naik versi. **Bukti:** daftar metode dan bacaan `NavigationManager::get()`. **M**
- [x] **B1.2** Cara yang dicoba sebagai pengganti (berbeda dari rencana awal `navigationItems`): **subclass `NavigationManager` yang menimpa `get()`**, memanggil `parent::get()` lalu mengatur hasilnya. Diuji dengan skrip: setelah dipasang (scoped, di-rebind di container) hasil `Filament::getNavigation()` **identik** dengan bawaan (35 item, 9 grup), dan urutan item Manufacturing bisa dibalik tanpa menambah atau menghilangkan item. **Bukti:** keluaran skrip uji coba. **M**
- [x] **B1.3** **Keputusan K8:** pakai subclass `NavigationManager` (cara B1.2). Alasan: seluruh logika izin, visibilitas, lencana, dan urutan Filament tetap dipakai, kita hanya mengatur hasil akhirnya. Pemasangannya (rebind di service provider plugin weba) dikerjakan di B3.7. **Bukti:** keputusan ini. **S**
- [x] **B1.4** Cluster di mode sidebar: sub-menu cluster ("Operations: Manufacturing Orders, Work Orders") tetap tampil di dalam halaman. **Bukti:** screenshot `shots-b2/order-terang.png`. **S**

### B2. Mode sidebar bawaan (tanpa gaya khusus)

- [x] **B2.1** `AdminPanelProvider`: `->topNavigation()` diganti `->sidebarWidth('15.75rem')` (lebar 252 px seperti mockup). Kolaps di desktop tidak diaktifkan (banyak item tanpa ikon akan hilang saat menciut). Panel pelanggan tidak berubah (diuji). **Bukti:** satu baris di satu berkas, tes `SidebarTest`. **S**
- [x] **B2.2** Diperiksa: pencarian, notifikasi, dan menu pengguna tetap di topbar. **Belum sesuai rencana:** logo dan ikon kotak-kotak (pengganti modul) tetap di topbar, bukan di atas sidebar; pemindahan logo dikerjakan di B4.4. **Bukti:** screenshot. **S**
- [x] **B2.3** Semua grup dan item muncul di sidebar (lihat B2.6 untuk penyebab dan perbaikannya). Daftar menu dari `Filament::getNavigation()` tidak berubah (B2 tidak menyentuhnya). Diuji dengan `SidebarTest`: setiap grup dan setiap alamat item muncul di HTML halaman; tiap grup berlabel sekali; item halaman terbuka ditandai aktif; user tanpa izin hanya melihat miliknya. **Terbukti mendeteksi:** dengan view lama dua tes pertama gagal. **Bukti:** 5 tes. **S**
- [x] **B2.4** Enam halaman diperiksa di Edge: semua terbuka, 35 sampai 38 item dan 9 label grup di tiap halaman. Satu error JS di konsol pada semua halaman: `Cannot read properties of null (reading 'offsetTop')` dari skrip `SupportPlugin` (milik upstream, `plugins/webkul`, tidak boleh diubah). Penyebab: skrip mencari kelas `.fi-sidebar-item-active` yang tidak ada di Filament 5 (kelas yang benar `fi-active`). **Menurut pembacaan kode, error ini sudah ada sebelum sidebar** (di mode menu atas elemen `nav.fi-sidebar-nav` tidak ada, sehingga memicu TypeError juga); tidak diuji ulang di mode lama. Tidak berdampak: Filament sendiri sudah menggulir sidebar. **Bukti:** log. **S**
- [x] **B2.5** Item aktif selalu terlihat setelah halaman dimuat, termasuk yang jauh di bawah (Help: nav tergulir 1284 px dari 2120; Production Priority: 462 px). Yang bekerja adalah pengguliran bawaan Filament, bukan skrip `SupportPlugin` (lihat B2.4). **Bukti:** pengukuran di browser. **S**
- [x] **B2.6** (baru, ditemukan di B2) Sidebar admin bawaan upstream hanya menampilkan **item grup yang aktif**; grup lain dicapai lewat ikon kotak-kotak (pengganti modul, gaya Odoo). Penyebabnya view yang ditimpa `resources/views/vendor/filament-panels/livewire/sidebar.blade.php` dengan `if ($isAdminPanel && ! $isGroupActive) { continue; }`. Perubahan: syarat itu dihapus dan tiap grup diberi label `wp-sidebar-group-label`. Diff 4 baris tambah, 3 baris hapus. **Bukti:** `git diff` berkas itu dan tes B2.3. **S**
- [x] **B2.7** Ikon kotak-kotak pengganti modul di topbar **dibiarkan** (tidak mengubah view `topbar.blade.php` milik upstream). Diputuskan memakai usulan saya karena pemilik meminta lanjut tanpa menjawab tiga pertanyaan audit; bila ingin disembunyikan, itu satu aturan CSS di B4. Pembuktian bahwa ikon itu tetap bekerja dengan menu baru: tes halaman penuh lulus (view topbar memanggil `getItems()->first()` pada tiap grup). **Bukti:** tes B3.7 dan B3.8. **S**

**Regresi sesudah B2:** unit **102 lulus**, feature **160 lulus** (155 + 5 tes `SidebarTest`), manufaktur **38 lulus**, Pint lulus. **Berhenti di sini untuk audit sebelum B3** (permintaan pemilik).

### B3. Susunan menu mirip mockup

- [x] **B3.1** `src/Navigation/SidebarArrangement.php`, kelas murni tanpa Filament: menerima menu lama (grup dan alamat item) dan grup pilihan, mengembalikan susunan baru. Dua jenis item pilihan: `consume` (mengambil alih item bawaan yang alamatnya sama, dilewati bila tidak ada) dan pintasan tambahan. **Bug ditemukan oleh tes acak dan sudah diperbaiki:** sisa item sebuah grup dihitung sebelum grup pilihan berikutnya mengambil item itu, sehingga item muncul dua kali (18 dari 200 kasus acak gagal); kini semua item pilihan ditentukan lebih dulu. Ada tes khusus untuk kasus itu. **Bukti:** 210 tes unit (10 aturan dan 200 kasus acak). **M**
- [x] **B3.2** Definisi susunan di `src/Navigation/SidebarDefinition.php` (satu tempat, berisi class tujuan, ikon, jenis item), label item di `resources/lang/{id,en}/filament/sidebar.php`. Label grup memakai label grup bawaan (`NavigationGroup` enum) supaya sama dengan menu lama. Keputusan Pembelian: item "Orders" modul Purchase (`/admin/purchase/orders`) dipindah ke grup Persediaan dan diberi nama "Pembelian". **Bukti:** berkas definisi dan bahasa. **S**
- [x] **B3.3** Tidak ada menu hilang: tes feature membandingkan seluruh alamat menu bawaan (dibangun Filament) dengan menu hasil susunan: tidak ada yang kurang, tidak ada duplikat, dan jumlahnya bertambah (pintasan tambahan). Ditambah sifat acak di B3.1. **Bukti:** tes. **S**
- [x] **B3.4** Urutan: Dashboard, Manufacturing, Inventory di atas, grup lain setelahnya sesuai urutan asli; di Manufacturing lima item pilihan (Order produksi, Work order, Prioritas SAW, Monitoring order, Kriteria dan bobot) lalu item asli. **Bukti:** tes urutan. **S**
- [x] **B3.5** Izin: pintasan tambahan hanya muncul bila class-nya terdaftar di panel dan `canAccess()` benar; item `consume` hanya muncul bila item bawaannya muncul (yang sudah disaring Filament). User tanpa izin tidak melihat satu pun pintasan dan tidak ada grup Manufacturing. **Bukti:** tes user terbatas. **S**
- [x] **B3.6** Plugin tidak terpasang: di database tes modul purchases tidak terpasang, dan pintasan "Purchasing" tidak muncul tanpa error. Pemasangan susunan sendiri hanya terjadi bila plugin weba terpasang. **Bukti:** tes. **S**
- [x] **B3.7** `src/Navigation/WorkNavigationManager.php` (subclass `NavigationManager`, memanggil `parent::get()` lalu menyusun hasilnya), dipasang scoped di `ProductionPriorityServiceProvider::arrangeSidebar()`. Bila ada dua grup berlabel sama atau dua item beralamat sama, menu dikembalikan **tanpa diubah** (diuji). **Dua bug ditemukan oleh tes saat menyambungkan:** `getItems()` mengembalikan Collection, bukan array; dan item grup harus Collection karena view topbar memanggil `->first()` (tanpa tes ini ikon kotak-kotak di topbar akan error 500). **Bukti:** 12 tes `ArrangedMenuTest`. **S**
- [x] **B3.8** Item pintasan aktif bila alamat halaman dimulai dengan alamatnya (halaman daftar dan halaman di bawahnya). Diuji lewat halaman penuh. **Catatan:** item bawaan "Operations" (cluster) ikut aktif di halaman yang sama, jadi dua item menyala sekaligus di grup Manufacturing; dibiarkan karena keduanya memang menuju bagian yang sama. **Bukti:** tes dan HTML. **S**
- [x] **B3.9** Lencana merah di "Order produksi": `src/Navigation/LateOrderBadge.php`, satu query hitung (order terbuka yang deadline-nya lewat), nol tidak ditampilkan, hanya terlihat oleh yang boleh melihat order (item pintasannya sendiri sudah disaring izin), jumlahnya sama dengan angka terlambat di Panel Kerja. Tugas 6.3 tercakup di sini. **Bukti:** 4 tes (angka, nol, warna, satu query untuk tiga pemanggilan). **M**
- [x] **B3.10** Label dua bahasa (id dan en) diuji. **Bukti:** tes. **S**

### B4. Gaya biru bergradasi

- [x] **B4.1** `resources/dist/sidebar.css` didaftarkan lewat `FilamentAsset` (`registerWorkPanelCss()`), hanya aturan untuk `.fi-main-sidebar`, tanpa `font-family`. Dipublikasikan ke `public/css/production-priority/sidebar.css` (ikut di-commit). **Bukti:** 2 tes (aset terdaftar; tidak ada font, ada gradasi dan label grup). **S**
- [x] **B4.2** Kontras dihitung dengan skrip pada tiga titik gradasi (`#061633`, `#0b2350`, `#123f86`): teks item `#c9d8f0` 7,00 sampai 12,44; teks putih (hover dan aktif) 10,09 sampai 17,94 dan 6,89 di atas latar aktif; lencana putih di atas `#c62f2f` 5,46. **Satu penyimpangan dari mockup:** label grup mockup `#7f9cc9` gagal di ujung bawah gradasi (3,60), diganti `#9fb6da` (4,89 sampai 8,70). Sidebar sama gelapnya di tema terang dan gelap. **Bukti:** hasil hitung. **S**
- [x] **B4.3** Item aktif menyala (latar putih transparan 14 persen, teks tebal), hover memakai 7 persen, fokus keyboard memakai garis putih 2 px. **Belum diuji:** penelusuran dengan tombol Tab di browser (hanya aturan CSS-nya yang ada). Tambahan (dari screenshot): hanya satu item yang menyala per halaman (item cluster bawaan dipadamkan bila pintasannya aktif, diuji), dan garis tipis memisahkan pintasan dari sisa item asli supaya sisa item tidak tampak seperti anak dari pintasan terakhir (diuji). **Bukti:** screenshot dan 2 tes. **S**
- [x] **B4.4** Logo asli tetap di topbar, kiri atas, tepat di atas sidebar; **nama perusahaan tidak ditambahkan** dan logo tidak dipindah ke dalam sidebar (view topbar milik upstream tidak diubah, lihat B2.7). Huruf "W" tiruan mockup tidak dipakai. Selisih ini dicatat untuk tinjauan B5.7. **Bukti:** screenshot. **S**
- [x] **B4.5** Menu panjang tergulir di dalam sidebar (tinggi isi 2120 px pada jendela 836 px), dengan bilah gulir tipis berwarna transparan putih. **Bukti:** pengukuran dan screenshot. **S**
- [x] **B4.6** CSS memakai properti logis (`padding-inline-start`) dan tidak menyentuh arah teks; aturan RTL lama di `resources/css/app.css` tidak diubah. **Belum ada screenshot RTL** (tinjauan dari kode saja). **Bukti:** tinjau CSS. **S**
- [x] **B4.7** (baru, dari masukan pemilik 10 Okt) Halaman tidak lagi terseret melewati ujung saat scroll touchpad mentok (celah putih di atas topbar): `overscroll-behavior: none` pada halaman dan `contain` pada menu sidebar. Nilai terbaca di browser (`none` dan `contain`); gerakan touchpad sendiri tidak bisa ditiru di browser headless, jadi hasilnya menunggu konfirmasi pemilik. Catatan: browser pemilik menyimpan CSS lama karena alamat aset bersifat tetap, perlu Ctrl+F5 (risiko cache di Fase 4 belum ditangani). **Bukti:** nilai komputasi di browser dan tes. **S**
- [x] **B4.8** (baru, dari masukan pemilik 10 Okt, "bagian jelek" tanpa penunjuk, dikerjakan sesuai rekomendasi) Sisa item asli di sidebar dibuat lebih kecil dan redup (kontras 5,83 di ujung terang gradasi), dan semua bilah gulir panel dibuat tipis (`scrollbar-width: thin`, ibu jari abu dengan kontras sekitar 3 di dua tema). **Tidak dilakukan:** sub-menu cluster di dalam halaman tidak disembunyikan karena itu satu-satunya jalan ke halaman seperti Work Centers dan Configurations; kolom tabel yang terpotong dibiarkan (perilaku tabel lebar). **Bukti:** screenshot dan tes. **S**
- [x] **B4.9** (baru, dari masukan pemilik 10 Okt: "ini masukkan ke sidebar aja") Kotak sub-menu cluster di dalam halaman (mis. "Operations: Manufacturing Orders, Work Orders") dipindah ke sidebar. Cara kerja: `src/Navigation/ClusterSubMenu.php` memutuskan daftar mana yang pindah; `WorkNavigationManager::moveActiveClusterMenuIntoSidebar()` memasang halaman cluster yang sedang dibuka sebagai anak item cluster di sidebar (hanya cluster yang aktif, jadi biayanya satu cluster per halaman); dua view `resources/views/vendor/filament-panels/components/page/sub-navigation/{sidebar,mobile-menu}.blade.php` menyembunyikan kotak lama hanya bila daftarnya sudah pindah. **Aturan pindah:** (a) hanya untuk panel admin dan bila plugin weba terpasang; (b) hanya daftar tanpa judul grup atau dengan satu judul saja (Configurations pindah); daftar dengan beberapa judul tetap di halaman (Settings punya empat item bernama "Manage Products" di bawah judul berbeda, Inventory Operations punya Transfers dan Adjustments), karena tanpa judul item tidak bisa dibedakan; (c) daftar satu record (lihat, ubah, tagihan satu penawaran) tidak pernah pindah; (d) halaman yang sudah menjadi pintasan di sidebar tidak diulang sebagai anak (Order Produksi dan Work Order: kotak hilang dan tidak ada anak). **Bug ditemukan saat mencoba di browser, bukan oleh tes yang ada:** blok `use` Blade tidak boleh di dalam `@if` (500), item induk yang punya anak wajib berikon (500, kini diberi ikon `rectangle-stack` bila belum punya), pemeriksaan ikon harus dilakukan sebelum anak dipasang, dan daftar mentah cluster membawa judul grup di tiap item, bukan sebagai objek grup (Settings sempat ikut pindah). **Bukti:** 7 tes `ClusterSubMenuTest` dan screenshot Order Produksi, Work Centers, Receipts, Settings. **Cara kembali:** hapus dua berkas view di atas dan panggilan `moveActiveClusterMenuIntoSidebar` di `WorkNavigationManager::get()`. **M**
- [x] **B4.10** (baru, dari masukan pemilik 10 Okt: "jangan ada refresh, langsung saja") Pindah halaman lewat sidebar tanpa muat ulang: `AdminPanelProvider` memakai `->spa()` (Livewire `wire:navigate`; tanpa prefetch). Panel pelanggan tidak diubah. **Bukti di browser** (Edge, 6 klik berturut-turut di sidebar): tiap klik memakai `wire:navigate`, **0 halaman dimuat penuh**, dan nilai yang disimpan di jendela browser tetap ada. Setelah pindah halaman tanpa muat ulang diperiksa: Panel Kerja (3 kartu, 4 kotak angka, 23 baris), klik tab Livewire (legenda status 5 baris), modal Terapkan prioritas terbuka, grafik Inventory Overview tampil (2 canvas), tabel Order Produksi (10 baris, 9 tab), semuanya tanpa error JS. **Efek samping yang ditemukan dan diperbaiki:** skrip upstream `SupportPlugin` (mencari kelas `.fi-sidebar-item-active` yang tidak ada di Filament 5) kini terdaftar ulang tiap navigasi dan melempar error yang bertambah banyak (2, 7, 5, 13 error per klik); item aktif (atau induk dari anak yang aktif) sekarang diberi kelas itu di view sidebar, sehingga skrip bekerja (sidebar tergulir ke item aktif) dan errornya hilang, juga untuk muat penuh pertama yang sebelumnya selalu error. **Diperiksa juga** (server tidak sedang sibuk): Plugins, Users, Help, Work Orders, Sales, Settings, dan tiga akar cluster yang mengarahkan ke halaman pertamanya (Sales, Configurations, Inventory Operations): semuanya 0 muat penuh dan tanpa error JS. **Catatan:** saat server sedang sibuk (tes berjalan bersamaan) beberapa klik jatuh kembali ke muat penuh; itu perilaku bawaan Livewire bila respons gagal atau terlambat, bukan kesalahan menu. **Belum diperiksa:** skrip plugin pihak ketiga yang mungkin memakai `DOMContentLoaded` (barcode, chatter, tidak terpasang di data demo); bila ada yang rusak, tambahkan ke `spaUrlExceptions`. **Cara kembali:** hapus `->spa()` di `AdminPanelProvider`. **Bukti tes:** 2 tes baru di `SidebarTest`. **S**
- [x] **B4.11** (baru, dari masukan pemilik 10 Okt: "kok masih ada menu itu") Ikon kotak-kotak pengganti modul di topbar disembunyikan, karena sidebar sudah memuat semua grup dan menu itu menjadi salinan kedua dari menu yang sama. Ini **mengubah keputusan B2.7** (dulu dibiarkan). Perubahan: `resources/views/vendor/filament-panels/livewire/topbar.blade.php`, blok pengganti modul hanya tampil bila manajer menu bukan `WorkNavigationManager` (jadi kembali otomatis bila plugin weba dilepas). Logo tetap di kiri atas. **Bukti:** tes `SidebarTest` (tidak ada `fi-topbar-item-btn`) dan screenshot. **Cara kembali:** hapus syarat `! $sidebarListsEveryGroup` di berkas itu. **S**
- [x] **B4.12** (baru, ditemukan saat B4.11) **Menu "Work orders" sempat hilang dan halamannya 404**, bukan karena sidebar. Pengaturan `enable_work_orders` modul manufaktur bernilai **false** di database kerja sejak instalasi (8 Okt), padahal data demo berisi 150 work order. Selama ini terbaca true dari cache pengaturan; `php artisan optimize:clear` ikut menghapus cache itu, sehingga nilai aslinya terbaca dan fitur Work Orders mati. Perbaikan: pengaturan diaktifkan di database kerja, dan `DemoDataSeeder` kini mengaktifkannya sendiri (idempotent, juga bila data demo sudah ada). **Pelajaran:** `optimize:clear` bisa mengubah perilaku aplikasi yang bergantung pada cache pengaturan; setelah menjalankannya, periksa menu dan halaman utama. **Bukti:** halaman Work Orders 200 dan tautannya ada di sidebar. **S**
- [x] **B4.13** (baru, dari masukan pemilik 11 Okt: "banyak yang tidak ada ikonnya") Item asli modul yang dikirim tanpa ikon (Operations, Products, Configurations, Settings, Roles, Users, dan seterusnya) kini diberi ikon sesuai artinya oleh `WorkNavigationManager::giveIconsToItemsWithoutOne()`, memakai pemetaan di `src/Navigation/SidebarIcons.php` (dari bagian terakhir alamat halaman, jadi tidak tergantung bahasa; halaman yang tidak dikenal mendapat ikon cadangan, sehingga tidak ada item tanpa ikon). Harus berjalan sebelum anak item dipasang karena Filament menolak induk beranak tanpa ikon. **Bukti:** 13 tes unit `SidebarIconsTest`, 1 tes feature (setiap item menu berikon), dan screenshot. Regresi penuh belum dijalankan ulang setelah perubahan ini; tes berkas menu (38) lulus. **S**

### B5. HP dan verifikasi

- [x] **B5.1** HP: sidebar menjadi laci dengan tombol menu di topbar, memuat semua grup dan menggulir ke item aktif (Help). Halaman 500 px tidak melebar. Edge headless tidak mau lebih sempit dari 500 px, jadi 390 px belum dicoba. **Bukti:** screenshot `drawer2`, `hp`. **S**
- [x] **B5.2** Sales, Inventory, Settings, Plugins di terang dan gelap: 8 screenshot diambil, 4 dilihat satu per satu (Sales gelap, Inventory terang, Settings gelap, Plugins terang) dan rapi; 4 lainnya hanya diambil. **Bukti:** screenshot. **S**
- [x] **B5.3** Waktu muat (median 5 kali) dengan server bawaan PHP: login 0,51, Dashboard Produksi 0,66, Panel Kerja 0,67, Order Produksi 0,54, Inventori 0,62 detik. **Tidak sebanding langsung dengan baseline B0.4** (0,20 sampai 0,28 detik) karena baseline memakai nginx dengan OPcache dan sekarang memakai `php -S`. Pembanding yang adil: rasio terhadap halaman login (tanpa sidebar): baseline 1,25 sampai 1,40, sekarang 1,06 sampai 1,31, jadi sidebar tidak menambah biaya yang terukur. Satu query hitung tambahan per halaman (lencana). **Bukti:** angka. **S**
- [x] **B5.4** Regresi akhir Fase 6B: unit 312 lulus, feature 180 lulus (176 + 4 tes baru: 2 CSS sidebar, 1 hanya satu item menyala, 1 garis pemisah), manufaktur 38 lulus, Pint lulus. Run feature 620 detik. **Bukti:** angka. **S**
- [x] **B5.5** Pencarian ulang kode yang bergantung pada menu atas: hanya aturan RTL (`.fi-topbar`), skrip `SupportPlugin` (error bawaan, lihat B2.4), dan panel pelanggan yang memang tetap memakai menu atas. Tidak ada tes yang bergantung padanya. **Bukti:** hasil pencarian. **S**
- [x] **B5.6** Cache dipulihkan (`optimize`, `filament:optimize`, `filament:assets`). **Catatan deploy ke hosting:** (1) unggah berkas baru plugin weba dan `resources/views/vendor/filament-panels/livewire/sidebar.blade.php`, `app/Providers/Filament/AdminPanelProvider.php`, `public/css/production-priority/*`; (2) jalankan `php artisan migrate` (migrasi izin Panel Kerja dari Fase 4; Fase 6B sendiri tidak menambah migrasi); (3) `php artisan filament:assets` dan `optimize:clear`. **Bukti:** catatan. **S**
- [ ] **B5.7** Tinjau bersama pemilik terhadap gambar sidebar mockup, catat selisih, dan sesuaikan. **Bukti:** daftar selisih selesai. **S**

**Regresi sesudah B3:** unit **312 lulus** (102 + 210 tes `SidebarArrangementTest`), feature **176 lulus** (160 + 16 tes `ArrangedMenuTest`), manufaktur **38 lulus**, Pint lulus. Run feature penuh 537 detik: lambat karena database tes diinstal ulang tiap run (70 sampai 170 detik) dan tiap tes membuat order lewat factory ERP (1 sampai 5 detik); saat pengembangan cukup jalankan berkas yang relevan.

**Regresi sesudah B4.7 sampai B4.9:** unit **312 lulus**, feature **189 lulus** (180 + 2 tes CSS + 7 tes `ClusterSubMenuTest`), manufaktur **38 lulus**, Pint lulus.

**Regresi sesudah B4.10:** feature **191 lulus** (189 + 2 tes baru), manufaktur **38 lulus**, unit tidak berubah (312), Pint lulus.

**Aturan henti:** bila spike B1 menunjukkan tidak ada cara yang aman untuk mempertahankan semua menu, berhenti dan lapor sebelum masuk B2.

## Fase 7: Verifikasi akhir (selesai 11 Okt 2026)

- [x] **7.1** Celah tes yang ditemukan lalu ditutup: nilai di **empat kotak angka** (sebelumnya hanya labelnya yang diperiksa), **angka di tiap kartu** (3 terlambat, 4 untuk diterapkan, 3 kurang bahan), batas **lima order** pada kartu prioritas, dan halaman **tanpa satu pun order** (kartu kosong, nol di semua kotak). Angka harapan dihitung tangan lebih dulu (mis. progres rata-rata 17 persen dari 50, 0, 0). Aksi terapkan dan batalkan serta tab dan saringan sudah tercakup tes Fase 4. **Bukti:** 4 tes baru di `WorkPanelContentTest` (kelompok `numbers`). **M**
- [x] **7.2** Regresi penuh 11 Okt 2026: unit **325 lulus**, feature **210 lulus**, manufaktur bawaan **38 lulus**. **S**
- [x] **7.3** Dibandingkan dengan mockup memakai data demo (screenshot browser, terang, gelap, HP). Selisih yang tercatat, bukan kesalahan: (a) logo tetap di topbar dan tanpa nama perusahaan di sidebar; (b) grup sidebar memuat semua modul, bukan hanya empat grup mockup, dan grup "Laporan" belum ada karena halamannya belum dibuat (Fase 8, 8.1); (c) bahasa tampilan Inggris karena locale `id` belum terdaftar (todo custom Fase 1); (d) font mengikuti project (K5), bukan Segoe UI; (e) tombol "Buka" di tiap baris selalu terlihat, bukan hanya saat hover; (f) tombol "Unduh laporan" tidak ada (K6) dan **baru bisa dibuat setelah ekspor 8.2 dan 8.3**; (g) topbar memakai pencarian bawaan Filament tanpa petunjuk Ctrl K dan tanpa nama pengguna di samping avatar. Tinjauan pemilik terhadap sidebar tetap di B5.7. **S**
- [x] **7.4** Kinerja dengan **200 order terbuka** (database tes, data digandakan dari satu order yang dibuat normal; tes di `PerformanceTest`): **SAW 200 order 0,38 dtk** (target PRD 3 dtk); **Panel Kerja 0,63 sampai 0,85 dtk** (target 2 dtk); **tiap widget Dashboard Produksi 0,05 sampai 0,19 dtk** (widget dimuat lazy, satu permintaan masing-masing, jadi diukur sendiri-sendiri); jumlah query **tetap** untuk 10 dan 200 order (Panel Kerja 24; lima widget 169 di antaranya). Temuan di tengah jalan: muat halaman utuh Dashboard Produksi hanya mengukur cangkangnya (3 query), jadi tes diubah mengukur widget. **Bukti:** 5 tes kinerja. **S**
- [x] **7.5** `vendor/bin/pint --dirty` lulus; `optimize` dan `filament:optimize` dijalankan. Catatan: langkah `views` pada `artisan optimize` gagal karena tampilan plugin `barcode` bawaan Aureus memakai komponen `native-top-bar-action` dari paket NativePHP yang tidak terpasang. Itu bukan kode kita dan tidak memengaruhi aplikasi (tampilan tetap dikompilasi saat dibuka); konfigurasi, rute, dan event tetap ter-cache. **S**
- [x] **7.6** Commit dengan persetujuan pemilik (11 Okt 2026): tiga commit, yaitu kode (`b4bdd56bf`), dokumen (`c8b275f21`), dan mockup (`450a1c16e`). Tidak dipisah per fase karena beberapa berkas (provider, definisi sidebar, berkas bahasa) dipakai bersama oleh beberapa fase dan commit per fase tidak akan bisa dijalankan sendiri-sendiri. **S**

---

## Urutan kerja

`0 → 1 → 2 → 3 → 4A → 4C → 4B → 4D → 4E → 6B (B0 sampai B5) → 5 → 7`. Tugas 6.1 (font) dibatalkan. Sidebar (6.2 dan 6.3) dikerjakan di Fase 6B sebelum Fase 5.

## Di luar cakupan dokumen ini

- Isi fitur tombol "Unduh laporan" (TODO 8.3) dan pembuatan RFQ otomatis (TODO 8.7). Halaman ini hanya menyiapkan tombolnya.
