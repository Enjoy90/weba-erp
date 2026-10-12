# Menu sebelum sidebar (potret B0.1)

Diambil 9 Okt 2026 dari database kerja, sebelum navigasi atas diganti sidebar. Dipakai sebagai acuan tes "tidak ada menu yang hilang" (B2.3 dan B3.3). Bahasa aplikasi: Inggris. Dibuat dengan skrip yang membaca `Filament::getNavigation()` untuk admin, lalu untuk user buatan sementara tanpa role (dihapus lagi dalam transaksi).

## Admin (role Admin, semua izin)

Jumlah grup: 9. Jumlah item: 35.

### Dashboard

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Daily Work Panel | `/admin/work-panel` | -3 | - | 0 |
| Production Dashboard | `/admin/production-priority` | -2 | - | 0 |

### Sales

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Orders | `/admin/sale/orders` | -1 | - | 0 |
| To Invoice | `/admin/sale/invoice` | -1 | - | 0 |
| Products | `/admin/sale/products` | 0 | - | 0 |
| Configurations | `/admin/sale/configurations` | 1 | - | 0 |
| Settings | `/admin/sale/settings` | 5 | - | 0 |

### Purchase

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Orders | `/admin/purchase/orders` | 2 | - | 0 |
| Products | `/admin/purchase/products` | 2 | - | 0 |
| Configurations | `/admin/purchase/configurations` | 3 | - | 0 |
| Settings | `/admin/purchase/settings` | 4 | - | 0 |

### Manufacturing

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Operations | `/admin/manufacturing/operations` | 1 | - | 0 |
| Products | `/admin/manufacturing/products` | 2 | - | 0 |
| Configurations | `/admin/manufacturing/configurations` | 3 | - | 0 |
| Settings | `/admin/manufacturing/settings` | 4 | - | 0 |
| Production Priority | `/admin/manufacturing/production-priority` | 4 | - | 0 |

### Inventory

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Overview | `/admin/inventory/overview` | 0 | - | 0 |
| Operations | `/admin/inventory/operations` | 1 | - | 0 |
| Products | `/admin/inventory/products` | 2 | - | 0 |
| Reporting | `/admin/inventory/reporting` | 3 | - | 0 |
| Configurations | `/admin/inventory/configurations` | 4 | - | 0 |
| Settings | `/admin/inventory/settings` | 5 | - | 0 |

### Invoices

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Customers | `/admin/invoices/customers` | -1 | - | 0 |
| Vendors | `/admin/invoices/vendors` | -1 | - | 0 |
| Configurations | `/admin/invoices/configurations` | 0 | - | 0 |
| Settings | `/admin/invoice/settings` | 4 | - | 0 |

### Plugins

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Plugin | `/admin/plugins` | -1 | - | 0 |

### Settings

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Roles | `/admin/shield/roles` | -1 | - | 0 |
| Companies | `/admin/companies` | 2 | - | 0 |
| Teams | `/admin/teams` | 3 | - | 0 |
| Users | `/admin/users` | 4 | - | 0 |
| Custom Fields | `/admin/fields` | 5 | - | 0 |
| Sequences | `/admin/sequences` | 10 | - | 0 |
| Settings | `/admin/settings` | 1000 | - | 0 |

### Help

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Help | `/admin/help` | 1 | - | 0 |

## User terbatas (tanpa role dan tanpa izin)

Jumlah grup: 2. Jumlah item: 2.

### Settings

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Sequences | `/admin/sequences` | 10 | - | 0 |

### Help

| Item | Alamat | Urutan | Lencana | Sub-item |
|---|---|---|---|---|
| Help | `/admin/help` | 1 | - | 0 |

