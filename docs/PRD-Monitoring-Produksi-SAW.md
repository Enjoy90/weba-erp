# PRD — Sistem ERP Produksi Berbasis Web dengan DSS Metode SAW

**Judul penelitian:** Rancang Bangun Sistem Enterprise Resource Planning (ERP) Produksi Berbasis Web dengan Decision Support System Metode Simple Additive Weighting (SAW) untuk Menentukan Prioritas Penyelesaian Produksi (Studi Kasus: PT. Weba International)

**Basis sistem:** Aureus ERP (Laravel 13 + Filament 5, arsitektur plugin), repo `aureuserp/aureuserp`; salinan kerja diambil dari `LanzAb/erp-weba`. Semua kode custom ada di plugin `plugins/weba/production-priority`; berkas lain yang diubah dicatat di §8.5.
**Versi:** Draft 3 (11 Okt 2026). Draft 2 berfokus pada fitur yang belum ada; Draft 3 menyelaraskan dokumen dengan pekerjaan yang sudah jadi: status tiap fitur di §4.1, struktur dan skema nyata di §8, perubahan di luar plugin di §8.5. Kriteria, bobot, dan data studi kasus masih asumsi, harus divalidasi dengan PT. Weba (§11).
**Catatan penulisan:** ejaan resmi: "International" (dikonfirmasi pengguna).

---

## 1. Latar Belakang & Tujuan

Penentuan urutan penyelesaian order produksi di PT. Weba diasumsikan masih manual (perkiraan/urutan masuk), sehingga rawan terlambat dan tidak transparan. Sistem ini adalah ERP produksi yang:

1. **Mengelola** siklus produksi end-to-end: penjualan → perencanaan → bahan baku/pembelian → produksi → hasil/stok.
2. **Memonitor** status produksi real-time (progres, keterlambatan, beban mesin, reject).
3. **Menentukan prioritas** penyelesaian order secara objektif dengan **DSS metode SAW**.

**Tujuan terukur (bab pengujian):**
- Ranking SAW ≤ 3 detik untuk ≤ 200 order aktif.
- Hasil sistem identik dengan hitungan manual (Excel).
- Dashboard memuat < 2 detik, ter-refresh ≤ 30 detik.

## 2. Status Saat Ini (per 11 Okt 2026)

| Item | Status |
|---|---|
| Aureus ERP ter-clone di `C:\xampp\htdocs\Project-Magang-Web-Monitoring-master` | ✅ |
| PHP 8.3.35, MySQL (XAMPP, db `weba_erp`), `.env`, `composer install` | ✅ |
| `erp:install` (admin `admin@weba.local`) | ✅ |
| Plugin terpasang: `accounts`, `inventories`, `invoices`, `manufacturing`, `payments`, `products`, `purchases`, `sales`, dan plugin custom `production-priority` | ✅ |
| Server lokal `serve.bat 8090` → `http://127.0.0.1:8090/admin/login` (tanpa nginx) | ✅ |
| **Fitur SAW/DSS** (A1 sampai A7) dan **monitoring** (B1 sampai B5), Panel Kerja Harian, sidebar baru | ✅ selesai dan teruji (plugin `weba/production-priority`) |
| Tes otomatis | ✅ plugin weba: 312 unit dan 200 feature lulus; manufaktur bawaan 38 lulus (11 Okt 2026) |
| Belum dikerjakan: E1 data studi kasus (data nyata PT. Weba) | ⬜ |

## 3. Ruang Lingkup

**Sudah dicakup Aureus (dipakai ulang, bukan dibuat):** order produksi, work order, work center, BoM, stok & lot, penerimaan/pengiriman, scrap, replenishment (order point), pembelian (RFQ/PO/vendor/bill/receipt), penjualan (quotation/SO), RBAC (Shield), log aktivitas (chatter), barcode, kalender.

**Perlu dibangun (inti dokumen ini):** lihat §4.

**Ditambahkan selama pengerjaan (di luar daftar awal):** halaman Panel Kerja Harian, sidebar yang disusun ulang, navigasi tanpa muat ulang, dan perbaikan aksesibilitas; lihat kelompok F di §4.

**Di luar lingkup:** akuntansi penuh, HR/rekrutmen/time-off, website/blog, proyek, maintenance → tidak di-install.

## 4. Daftar Fitur yang Belum Ada (Gap)

Prioritas: **MVP** = wajib untuk skripsi · **EXT** = pelengkap "ERP produksi" (kerjakan jika waktu cukup) · **OPT** = nilai tambah.

### A. DSS — Prioritas Produksi dengan SAW  *(inti penelitian, MVP)*
| ID | Fitur | Prio |
|---|---|---|
| A1 | Master kriteria & bobot (tipe benefit/cost, aktif, urutan, validasi total bobot = 1) | MVP |
| A2 | Mesin hitung SAW (normalisasi, skor, ranking, edge case) | MVP |
| A3 | Atribut order: tingkat urgensi (1–5) & nilai order | MVP |
| A4 | Penghitung nilai kriteria otomatis dari data produksi (§5.1) | MVP |
| A5 | Evaluasi: jalankan manual & terjadwal, simpan snapshot | MVP |
| A6 | Halaman hasil transparan: matriks keputusan, normalisasi, skor, ranking | MVP |
| A7 | "Terapkan prioritas" ke order (top-N → Urgent) + alasan | MVP |
| A8 | Riwayat evaluasi & perbandingan dua evaluasi | EXT |
| A9 | Simulasi/analisis sensitivitas bobot | OPT |

### B. Monitoring Produksi  *(MVP)*
| ID | Fitur | Prio |
|---|---|---|
| B1 | Progres order % (work order selesai/total, fallback `quantity_producing/quantity`) | MVP |
| B2 | Sisa durasi produksi, sisa hari ke deadline, status **Terlambat** | MVP |
| B3 | Persentase ketersediaan bahan per order | MVP |
| B4 | Dashboard produksi: order per status, terlambat, jatuh tempo ≤ 3 hari, rata-rata progres | MVP |
| B5 | Widget Top-10 ranking SAW & tabel order terlambat | MVP |
| B6 | Beban & kapasitas work center | EXT |
| B7 | Notifikasi database: order terlambat / mendekati deadline | EXT |

**Definisi yang dipakai di kode (menjelaskan B1 dan B3):**
- **B1 progres:** work order dibobot menurut durasi rencananya (`expected_duration`), bukan sekadar jumlahnya; bila order tidak punya work order dipakai `quantity_producing / quantity`.
- **B3 ketersediaan bahan:** rata-rata (jumlah yang sudah **ter-reserve** atau terpakai / kebutuhan) per baris bahan. Stok yang ada di gudang tetapi belum di-reserve tidak dihitung, sehingga order yang belum menjalankan "check availability" terbaca 0 persen. Order tanpa bahan dihitung 100 persen.

### C. Fitur ERP Produksi Tambahan *(menutup kekurangan Aureus untuk judul "ERP produksi")*
| ID | Fitur | Alasan belum ada | Prio |
|---|---|---|---|
| C1 | **Laporan produksi harian** (target vs realisasi per order/mesin/shift) | Tidak ada laporan di modul manufaktur | MVP |
| C2 | **Pencatatan reject/cacat produksi** (jumlah, jenis cacat, penyebab) → ke scrap inventori | Tidak ada modul kualitas; scrap terpisah di inventori | EXT |
| C3 | **Jadwal produksi** (kalender/Gantt order & work order berdasarkan deadline) | Tidak ada Gantt; hanya plugin kalender umum | EXT |
| C4 | **Perencanaan kebutuhan bahan (MRP-lite)**: kekurangan bahan = kebutuhan order aktif − stok − PO berjalan; tombol "Buat RFQ" ke modul pembelian | Tidak ada MRP/forecast | EXT |
| C5 | **Biaya produksi (HPP) per order**: bahan + biaya work center (`costs_per_hour` sudah ada di WO) | Tidak ada roll-up biaya | EXT |
| C6 | Alur **Sales Order → Order Produksi** terverifikasi (nilai order & customer ikut terbawa) | Konfirmasi SO tidak membuat MO di Aureus ini (aturan manufacture kosong); tautan disediakan plugin kita | MVP |
| C7 | Impor data massal dari Excel (produk, BoM, order awal) | Tidak ditemukan fitur impor | EXT |
| C8 | Ekspor laporan PDF/Excel (ranking SAW, monitoring, produksi harian) | Tidak ada ekspor di manufaktur | MVP |

### D. Lokalisasi & Identitas
| ID | Fitur | Prio |
|---|---|---|
| D1 | Bahasa Indonesia (`id`) — aplikasi inti + plugin yang dipakai + plugin custom | MVP |
| D2 | Rupiah (IDR), WIB, format tanggal/angka Indonesia, PPN 11% (jika pembelian/penjualan dipakai) | MVP |
| D3 | Logo, favicon, warna PT. Weba | EXT |

### E. Data, Akses, & Kualitas
| ID | Fitur | Prio |
|---|---|---|
| E1 | Seeder data PT. Weba (produk, BoM, work center, vendor, customer, order uji) | MVP |
| E2 | Peran & permission: Admin, Manajer Produksi/PPIC, Supervisor, Pimpinan, Gudang/Pembelian | MVP |
| E3 | Uji otomatis (Pest) mesin SAW, resolver kriteria, otorisasi | MVP |
| E4 | Deploy ke server Linux, backup DB, panduan pengguna | OPT |

### F. Antarmuka Kerja Harian  *(ditambahkan 10 Okt 2026, selesai)*
| ID | Fitur | Prio | Status |
|---|---|---|---|
| F1 | **Panel Kerja Harian**: halaman tugas PPIC. Sapaan, tiga kartu tugas (order terlambat, terapkan prioritas hari ini, lengkapi bahan baku), empat kotak angka, panel tiga tab (urutan prioritas dengan saringan, beban work center, status order), penyegaran otomatis 60 detik | EXT | ✅ |
| F2 | **Sidebar tersusun**: grup Dashboard, Manufacturing, Inventory di atas dengan pintasan berikon, lencana jumlah order terlambat, seluruh menu asli tetap ada, kotak sub-menu cluster pindah ke sidebar | EXT | ✅ |
| F3 | **Navigasi tanpa muat ulang** (mode SPA) di panel admin | EXT | ✅ |
| F4 | **Responsif dan aksesibilitas** Panel Kerja: satu kolom di layar sempit, tab dengan pola `tablist` dan navigasi panah, batang progres bernama, fokus keyboard, ukuran sentuh 24 px, kontras teks 4,5 di terang dan gelap | EXT | ✅ |

### 4.1 Status implementasi per ID (11 Okt 2026)
| ID | Status | Keterangan |
|---|---|---|
| A1 | ✅ | `CriterionResource`: CRUD, urut seret, total bobot, tombol normalisasi |
| A2 | ✅ | `SawCalculator` murni, 16 dataset uji, contoh §5.4 |
| A3 | ✅ | urgensi dan nilai order lewat tombol per baris di Monitoring Order |
| A4 | ✅ | `CriterionValueResolver`, jumlah query tetap |
| A5 | ✅ | manual dan terjadwal 06:00 (`production-priority:run`), snapshot tidak bisa diubah |
| A6 | ✅ | detail evaluasi: matriks keputusan, normalisasi, skor dan ranking |
| A7 | ✅ | terapkan dan batalkan prioritas, alasan, catatan di chatter order |
| A8 | sebagian | riwayat ✅; perbandingan dua evaluasi ⬜ |
| A9 | ⬜ | simulasi bobot (OPT) |
| B1 sampai B5 | ✅ | `OrderProgressService`, `ProductionOverview`, lima widget, Dashboard Produksi |
| B6 | sebagian | beban jam per work center ✅; perbandingan dengan kapasitas ⬜ |
| B7 | ⬜ | notifikasi terjadwal |
| C1 | ✅ | halaman Laporan produksi harian (rencana vs realisasi per work order, filter periode dan work center, kelompok per work center atau order); belum per shift |
| C8 | ✅ | ekspor Excel dan PDF (kop dari data Company) untuk peringkat SAW, monitoring order, dan laporan harian; mengikuti filter tabel |
| C2, C3, C7 | ⬜ | **ditunda** (keputusan 11 Okt) |
| C4 | sebagian | kekurangan bahan per bahan sudah tampil di Panel Kerja dengan tombol RFQ; perhitungan lengkap (stok, PO berjalan) **dipilih**, setelah MVP |
| C5 | ⬜ | **dipilih**, setelah MVP |
| C6 | ✅ | SO ditautkan ke order produksi lewat atribut order; nilai SO (baris produk yang sama) masuk C6, selain itu nilai manual; asal nilai dan pelanggan tampil di Monitoring. SO tidak otomatis menjadi MO |
| D1 | ✅ | locale `id` terdaftar dan menjadi bawaan; terjemahan inti, pesan Laravel, dan 14 plugin (7.322 kalimat) di `lang/vendor/<plugin>/id/` tanpa mengubah plugin bawaan; sisa dua kata breadcrumb dari nama kelas |
| D2 | ✅ | Rupiah dengan pemisah Indonesia, format tanggal "11 Okt 2026", zona waktu WIB, PPN 11% untuk penjualan dan pembelian |
| D3 | ⬜ | logo, favicon, warna |
| E1 | sebagian | `DemoDataSeeder` (30 order, 5 work center, 4 artikel); data nyata PT. Weba belum ada |
| E2 | ✅ | empat peran dibuat (Manajer Produksi, Supervisor Produksi, Gudang dan Pembelian, Pimpinan) dengan izin sendiri; aksi terapkan, urgensi, dan ekspor punya izin sendiri; audit otorisasi dan 31 tes (Fase 9) |
| E3 | ✅ | Pest: 312 unit dan 200 feature |
| E4 | ⬜ | deploy dan panduan (OPT) |

## 5. Metode SAW — Spesifikasi Perhitungan

### 5.1 Kriteria default (usulan — **wajib divalidasi** dengan PT. Weba)

| Kode | Kriteria | Tipe | Sumber data | Bobot awal |
|---|---|---|---|---|
| C1 | Sisa waktu menuju deadline (hari) | Cost | `deadline_at − now()` | 0,30 |
| C2 | Tingkat urgensi pelanggan (1–5) | Benefit | atribut order (A3) | 0,20 |
| C3 | Ketersediaan bahan baku (%) | Benefit | B3 | 0,15 |
| C4 | Sisa durasi produksi (jam) | Cost | Σ(`expected_duration` − `duration`) WO belum selesai | 0,15 |
| C5 | Progres penyelesaian (%) | Benefit | B1 | 0,10 |
| C6 | Nilai order (Rp) | Benefit | Sales Order yang ditautkan, selain itu atribut order | 0,10 |
| | **Total** | | | **1,00** |

Kriteria berupa **konfigurasi** (aktif/nonaktif, tipe, bobot), bukan hardcode. Total bobot aktif = 1 (validasi, atau normalisasi otomatis).

**Implementasi:** `CriterionSeeder` mengisi enam kriteria dan bobot di atas, ditandai sementara sampai divalidasi. Tabel kriteria dipisah per company.

### 5.2 Rumus
1. Matriks keputusan **X**: baris = order aktif (`confirmed`, `progress`, `to_close`), kolom = kriteria aktif.
2. Normalisasi: benefit `r = x / max(x)`; cost `r = min(x) / x`.
3. Skor: `V_i = Σ w_j · r_ij`.
4. Ranking menurun; rank 1 = prioritas tertinggi.

### 5.3 Edge case
| Kasus | Penanganan |
|---|---|
| `max(x)=0` (benefit) | semua `r=0` untuk kriteria itu |
| `x=0` (cost) | `r=1` |
| Deadline lewat | sisa hari = 0 → `r=1`, ditandai **Terlambat** |
| Deadline kosong | nilai terbesar di himpunan (prioritas terendah C1) + peringatan |
| 1 order | skor = Σ bobot, rank 1 |
| Skor sama | tie-break: `deadline_at` terawal, lalu `id` terkecil |
| Presisi | simpan 6 desimal, tampil 4 |

### 5.4 Contoh hitung (jadi unit test & bahan bab pembahasan)
C1 cost (bobot 0,6), C2 benefit (bobot 0,4):

| Order | C1 sisa hari | C2 urgensi |
|---|---|---|
| A | 2 | 3 |
| B | 5 | 5 |
| C | 10 | 1 |

Normalisasi C1 (min=2): A=1,000 · B=0,400 · C=0,200. Normalisasi C2 (max=5): A=0,600 · B=1,000 · C=0,200.
**V_A = 0,840 · V_B = 0,640 · V_C = 0,200 → A > B > C.**

## 6. Kebutuhan Fungsional Ringkas
Seluruh fitur pada §4 adalah kebutuhan fungsional; ID tabel (A1…E4) dipakai sebagai referensi tunggal di todolist dan pengujian. Peran pengguna:

| Peran | Akses |
|---|---|
| Admin Sistem | penuh |
| Manajer Produksi / PPIC | kriteria, evaluasi SAW, order, jadwal, MRP |
| Supervisor Produksi | order & work order, laporan harian, reject |
| Gudang / Pembelian | stok, penerimaan, RFQ/PO |
| Pimpinan | dashboard & laporan (baca saja) |

Peran ini sudah dibuat (Fase 9) dengan nama Manajer Produksi, Supervisor Produksi, Gudang dan Pembelian, dan Pimpinan; isi izinnya di `Support/ProductionRoles`. Izin khusus: terapkan prioritas, atur urgensi dan nilai order, ekspor laporan.

## 7. Kebutuhan Non-Fungsional
- **Kinerja:** SAW ≤ 3 dtk @200 order; dashboard < 2 dtk (query agregat, tanpa N+1). *Terukur sementara (data demo 30 order):* halaman admin 0,2 sampai 0,8 dtk di server lokal, jumlah query halaman Panel Kerja tetap untuk 1 maupun banyak order (diuji). *Terukur @200 order (11 Okt 2026, panel todo 7.4):* SAW 0,38 dtk, Panel Kerja 0,63 sampai 0,85 dtk, tiap widget dashboard 0,05 sampai 0,19 dtk, jumlah query tidak bertambah dengan jumlah order.
- **Akurasi:** seluruh hitungan SAW di satu service murni yang bisa diuji unit.
- **Keamanan:** Shield + policy; multi-company scoping; ubah bobot hanya peran berwenang.
- **Audit:** perubahan bobot tercatat; snapshot evaluasi immutable.
- **Maintainability:** kode custom hanya di plugin sendiri; **tidak mengubah `plugins/webkul/*`** kecuali menambah file bahasa. Satu pengecualian kecil pada berkas bantu tes (§8.5). Berkas milik aplikasi inti yang diubah tercatat lengkap di §8.5 agar update upstream mudah dirunut.
- **Kompatibilitas:** PHP 8.3 (PHP bawaan XAMPP 8.2 tidak bisa menjalankan artisan atau composer proyek ini), MariaDB 10.4 (XAMPP, pengembangan) atau MySQL 8 (produksi), browser modern, responsif (diukur di 500 sampai 1440 px).
- **Aksesibilitas:** teks minimal kontras 4,5 di tema terang dan gelap, fokus keyboard terlihat, tab dapat dioperasikan dengan papan ketik, status tidak hanya berupa warna (Panel Kerja Harian).

## 8. Rancangan Teknis

### 8.1 Struktur plugin (kondisi nyata, 11 Okt 2026)
```
plugins/weba/production-priority/          # namespace Weba\ProductionPriority
├── composer.json                          # ikut ter-merge via plugins/*/*/composer.json
├── config/filament-shield.php             # pengecualian Shield (cluster, monitoring)
├── database/
│   ├── migrations/                        # 5 berkas: 4 tabel + pemberian izin Panel Kerja
│   ├── seeders/                           # CriterionSeeder, DemoDataSeeder, DatabaseSeeder
│   └── factories/
├── resources/
│   ├── lang/{en,id}/                      # filament/, enums/, models/, services/
│   ├── views/                             # filament/pages, filament/tables/columns, components/work-panel
│   └── dist/                              # work-panel.css, sidebar.css
├── src/
│   ├── ProductionPriorityPlugin.php, ProductionPriorityServiceProvider.php
│   ├── Enums/        CriterionType, CriterionSource, EvaluationTrigger, DayPeriod
│   ├── Models/       Criterion, Evaluation, EvaluationItem, OrderAttribute
│   ├── Services/     SawCalculator (murni), CriterionValueResolver, CriterionWeightNormalizer,
│   │                 OrderProgressCalculator (murni), OrderProgressService, EvaluationService,
│   │                 PriorityApplier, ProductionOverview, ProductionStatsCalculator
│   ├── Support/      OrderProgress, SawCriterion, SawResult, MaterialShortage, WorkCenterLoad,
│   │                 MaterialMoveSnapshot, WorkOrderSnapshot
│   ├── Navigation/   SidebarArrangement (murni), SidebarDefinition, WorkNavigationManager,
│   │                 ClusterSubMenu, SidebarIcons, LateOrderBadge
│   ├── Filament/     Clusters/ProductionPriority (Criterion, Evaluation, OrderMonitoring),
│   │                 Pages (WorkPanel, ProductionDashboard), Widgets (5), Actions
│   ├── Console/      RunEvaluationCommand
│   └── Policies/     CriterionPolicy, EvaluationPolicy
└── tests/{Unit,Feature,Fixtures}
```
Sudah ada untuk C8: `Exports/ReportTableExport`, `Services/Reports/*ReportBuilder`, `Support/ReportTable`, `Support/Letterhead`, `Filament/Actions/ExportReportAction`, tampilan `pdf/report`.

Belum ada (menunggu fitur terkait): `MaterialShortageService` (C4, perhitungan kekurangan bahan sementara ada di `ProductionOverview`), `ProductionCostService` (C5), model `DefectLog` (C2, ditunda). Plugin manager tidak terkunci ke folder `webkul`: plugin di `plugins/weba` ter-discover lewat composer merge-plugin dan terdaftar di `bootstrap/providers.php` (terverifikasi, TODO 2.1).

### 8.2 Skema database (tabel ekstensi; tidak mengubah tabel inti)
Sudah ada (kolom sesuai migrasi nyata):
- **`production_priority_criteria`**: `id, company_id, creator_id, code, name, type(benefit|cost), source, weight decimal(6,4), is_active, sort`
- *(C1 tidak punya tabel sendiri: laporan harian membaca `manufacturing_work_orders` dan `manufacturing_work_center_productivity_logs`. Tabel `production_priority_daily_reports` pada rancangan awal tidak dibuat.)*
- **`production_priority_order_attributes`** (1:1 MO): `manufacturing_order_id (unique), creator_id, urgency_level 1–5, order_value, sale_order_id (tanpa foreign key, plugin sales opsional), notes`
- **`production_priority_evaluations`**: `id, company_id, name, evaluated_at, evaluated_by, trigger(manual|scheduled), criteria_snapshot json, warnings json, order_count, notes, applied_at, applied_by, applied_top_n`
- **`production_priority_evaluation_items`**: `evaluation_id, manufacturing_order_id, raw_values json, normalized_values json, score decimal(10,6), rank, applied, previous_priority` (index `(evaluation_id, rank)`; kolom `previous_priority` dan `applied` boleh berubah, sisanya tidak bisa diubah setelah dibuat)

Belum dibuat:
- **`production_priority_defect_logs`** (C2, ditunda): `manufacturing_order_id, work_order_id nullable, defect_type, quantity, cause, recorded_by, recorded_at`
- **`production_priority_daily_reports`** (C1, bila perlu snapshot): `report_date, manufacturing_order_id, work_center_id, shift, target_qty, actual_qty, notes`

### 8.3 Komponen kunci
- **`SawCalculator`**: murni (tanpa DB), diuji dengan contoh §5.4 dan 16 dataset.
- **`CriterionValueResolver`**: map `source` → nilai per order, eager loading.
- **`OrderProgressCalculator` dan `OrderProgressService`**: satu sumber kebenaran progres, sisa durasi, hari ke deadline, terlambat, dan ketersediaan bahan, untuk dashboard dan resolver.
- **`EvaluationService`**: menjalankan evaluasi dalam satu transaksi dan menyimpan snapshot; **`PriorityApplier`**: menerapkan dan membatalkan prioritas Urgent, hanya pada order yang benar-benar berubah.
- **`ProductionOverview`** (scoped per request) dan **`ProductionStatsCalculator`**: memuat order terbuka sekali lalu melayani semua widget dan Panel Kerja (terlambat, jatuh tempo, kekurangan bahan, beban work center, status, evaluasi terakhir).
- **Navigasi**: `WorkNavigationManager` mengganti pembangun menu Filament dengan subclass yang hanya menyusun ulang hasilnya; `SidebarArrangement` murni dan diuji acak (tidak ada menu yang hilang atau ganda).
- **Dashboard**: widget mengikuti pola `projects` (`StatsOverviewWidget`, chart, tabel) + `HasWidgetShield`.
- **Belum ada:** `MaterialShortageService` (C4), `ProductionCostService` (C5).

### 8.4 Alur pengguna
1. Admin mengatur kriteria & bobot → 2. Order dibuat dari Sales/Manufacturing, PPIC mengisi urgensi & nilai → 3. Sistem menghitung kekurangan bahan, gudang/pembelian membuat RFQ → 4. PPIC menjalankan **SAW** (manual / jadwal harian 06:00 WIB) → 5. Ranking tampil, PPIC **Terapkan prioritas** → 6. Supervisor mengerjakan sesuai ranking, mengisi laporan harian & reject → 7. Pimpinan memantau dashboard & laporan.

Sehari-hari PPIC memulai dari **Panel Kerja Harian** (menu Dashboard, paling atas): kartu tugas menunjukkan order terlambat, hasil SAW yang siap diterapkan, dan bahan yang kurang, dengan satu klik ke halaman kerjanya.

### 8.5 Perubahan di luar plugin `weba`

Prinsip "kode custom hanya di plugin sendiri" dilanggar secara terbatas pada berkas berikut. Semuanya dicatat agar update dari upstream bisa dirunut dan diterapkan ulang.

| Berkas | Perubahan | Alasan |
|---|---|---|
| `bootstrap/providers.php` | mendaftarkan `ProductionPriorityServiceProvider` | memasang plugin custom |
| `.env.example` | nama aplikasi, zona waktu `Asia/Jakarta`, mata uang `IDR` | identitas dan lokalisasi (D2) |
| `app/Providers/Filament/AdminPanelProvider.php` | `sidebarWidth()` dan `spa()`; menu atas dilepas untuk panel admin | sidebar dan navigasi tanpa muat ulang (F2, F3); panel pelanggan tidak berubah |
| `resources/views/vendor/filament-panels/livewire/sidebar.blade.php` | menampilkan semua grup, label grup, garis pemisah, kelas item aktif | sidebar tersusun (F2) |
| `resources/views/vendor/filament-panels/livewire/topbar.blade.php` | ikon pengganti modul disembunyikan bila sidebar memuat semua grup | menu ganda |
| `resources/views/vendor/filament-panels/components/page/sub-navigation/{sidebar,mobile-menu}.blade.php` | kotak sub-menu cluster disembunyikan bila isinya pindah ke sidebar | F2 |
| `phpunit.xml`, `tests/TestCase.php` | suite tes plugin, `DB_DATABASE=weba_erp_test` dipaksa, tes berhenti bila bukan database `*_test` | mencegah tes menghapus database kerja |
| `plugins/webkul/support/tests/Helpers/TestBootstrapHelper.php` | satu baris: regex jalur yang benar di Windows dan mengenali `plugins/weba` | bug upstream di Windows |
| `serve.bat` | server lokal bawaan PHP dengan OPcache | kecepatan pengembangan lokal |

## 9. Risiko

| Risiko | Mitigasi |
|---|---|
| Cakupan "ERP produksi" terlalu luas untuk waktu skripsi | Kerjakan **MVP** dulu; EXT/OPT hanya jika sisa waktu; fitur dasar sudah dari Aureus |
| Dosen mempertanyakan orisinalitas karena basis open-source | Sebut Aureus sebagai basis; tonjolkan kontribusi A, B, C1, C4, D dan studi kasus |
| Data PT. Weba belum ada | Data dummy terdokumentasi; validasi ulang saat data nyata ada |
| Update upstream merusak kustom | Kode custom terisolasi + test regresi |
| Modul manufaktur kompleks (rute, lokasi, stok) | Seeder master data + panduan singkat |
| `artisan serve` mati setelah 300 dtk (`set_time_limit` di `AdminPanelProvider`) | Pakai `serve.bat` (server bawaan PHP dengan OPcache, tanpa batas itu) |
| Tes feature menghapus database kerja bila konfigurasi ter-cache (`migrate:fresh`) | `phpunit.xml` memaksa `weba_erp_test`; `tests/TestCase.php` menolak jalan bila bukan database `*_test`; jalankan `optimize:clear` sebelum tes |
| `optimize:clear` ikut menghapus cache pengaturan sehingga pengaturan modul (mis. `enable_work_orders`) terbaca nilai aslinya dan fitur hilang | `DemoDataSeeder` mengaktifkan pengaturan itu; setelah `optimize:clear` periksa menu utama |
| Update upstream menimpa berkas milik inti yang kita ubah | daftar lengkap di §8.5; tes sidebar dan menu menangkap perubahan perilaku |

## 10. Kriteria Penerimaan (status 11 Okt 2026)
- [x] Contoh §5.4 → 0,840 / 0,640 / 0,200 lulus di unit test.
- [~] Hasil sistem = Excel pada ≥ 10 dataset: 16 dataset dihitung independen (Python/Fraction, `tests/Fixtures/saw_cases.json`) dan cocok; berkas Excel dengan rumus hidup untuk Bab Pengujian belum dibuat (TODO 3.5).
- [ ] Seluruh fitur **MVP** berfungsi sesuai peran: A, B, C1, C6, C8, D1, D2, dan E2 selesai; E1 belum (data nyata PT. Weba).
- [x] UI Bahasa Indonesia: locale id menjadi bawaan; plugin custom, aplikasi inti, dan 14 plugin yang dipakai sudah diterjemahkan (12 Okt 2026). Sisa: dua kata breadcrumb dari nama kelas plugin bawaan.
- [x] Performa sesuai §7: terukur dengan 200 order terbuka, SAW 0,38 dtk (target 3 dtk), Panel Kerja dan tiap widget di bawah 1 dtk (target 2 dtk), query tetap; diuji otomatis di `PerformanceTest`.
- [x] Test hijau: plugin custom 325 unit + 291 feature (setelah Fase 1 dan 9), manufaktur bawaan 38 (11 Okt 2026).

## 11. Pertanyaan Terbuka (konfirmasi ke PT. Weba)
1. Kriteria sebenarnya yang dipakai PPIC? Bobot ditetapkan lewat wawancara/kuesioner/AHP? Siapa respondennya?
2. Jenis produk & proses produksi (make-to-order/stock)? Ada berapa mesin/tahap?
3. Data historis order (≥ 30–50) untuk uji manual vs SAW?
4. Apakah pembelian bahan, reject, dan HPP memang dikelola sistem (menentukan EXT mana yang dikerjakan)?
5. ~~Ejaan resmi nama perusahaan~~ — sudah dikonfirmasi: "International".

**Jawaban sementara (11 Okt 2026):** butir 1 dan 2 masih memakai kriteria default dan data demo (5 work center); butir 3 data historis belum ada, 11.4 dicatat sebagai keterbatasan bila tidak terpenuhi; butir 4 diputuskan: pembelian (C4) dan HPP (C5) masuk lingkup setelah semua MVP, reject (C2) ditunda. Lihat bagian "Keputusan Lingkup" di `TODO-Custom-Development.md`.
