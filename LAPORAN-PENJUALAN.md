# 📊 Fitur Laporan Penjualan - Cupstore

## ✨ Fitur Lengkap

### 🎯 Akses
- **Admin**: Dapat mengakses dan mencetak laporan
- **Kasir**: Dapat mengakses dan mencetak laporan
- **Pelanggan**: Tidak memiliki akses

### 🔍 Filter Laporan
Laporan dapat difilter berdasarkan:
1. **Rentang Tanggal**
   - Tanggal Mulai
   - Tanggal Akhir
   
2. **Pelanggan Spesifik**
   - Dropdown semua pelanggan
   - Filter transaksi per pelanggan
   
3. **Produk Spesifik**
   - Dropdown semua produk
   - Filter transaksi yang mengandung produk tertentu

### 📈 Statistik yang Ditampilkan
- **Total Transaksi**: Jumlah transaksi berdasarkan filter
- **Total Pendapatan**: Total revenue dari transaksi
- **Total Item Terjual**: Jumlah item yang terjual

### 📋 Tabel Transaksi
Menampilkan detail:
- No Invoice
- Tanggal & Waktu
- Nama Pelanggan
- Daftar Produk (dengan quantity)
- Jumlah Item
- Total Pembayaran
- Pagination (20 per halaman)

### 🖨️ Cetak Laporan
- Tombol "Cetak Laporan" muncul ketika ada filter aktif
- Format print-friendly dengan logo Cupstore
- Menampilkan:
  - Informasi filter yang digunakan
  - Statistik ringkasan
  - Detail setiap transaksi dengan produk
  - Grand Total
  - Tempat tanda tangan Manager & Pembuat laporan
  - Footer perusahaan

## 🚀 Cara Menggunakan

### Untuk Admin:
1. Login sebagai Admin
2. Di Dashboard Admin, klik "Laporan Penjualan"
3. Pilih filter yang diinginkan (tanggal, pelanggan, atau produk)
4. Klik "Tampilkan Laporan"
5. Untuk mencetak, klik "🖨️ Cetak Laporan"

### Untuk Kasir:
1. Login sebagai Kasir
2. Di Dashboard Kasir, klik "📊 Laporan Penjualan"
3. Gunakan filter sesuai kebutuhan analisis
4. Klik "Tampilkan Laporan"
5. Cetak laporan dengan tombol "🖨️ Cetak Laporan"

## 📍 Route URL

```
Admin & Kasir:
- /reports           → Halaman laporan dengan filter
- /reports/print     → Halaman cetak (popup/tab baru)
```

## 🎨 Fitur UI

### Halaman Laporan
- ✅ Filter form dengan date picker
- ✅ Dropdown pelanggan & produk
- ✅ Statistics cards (3 kartu info)
- ✅ Tabel responsif dengan hover effect
- ✅ Pagination dengan maintain filter
- ✅ Button "Reset Filter"
- ✅ Button "Cetak Laporan" (conditional)

### Halaman Print
- ✅ Clean print layout (no navbar/footer)
- ✅ Header dengan logo Cupstore
- ✅ Info filter yang diterapkan
- ✅ Statistics cards dengan gradient
- ✅ Tabel detail transaksi
- ✅ Grand total di akhir
- ✅ Section tanda tangan
- ✅ Button "Cetak" di pojok kanan atas
- ✅ Responsive untuk print & screen

## 🔧 Technical Details

### Controller: `ReportController.php`
- `index()` - Menampilkan laporan dengan filter
- `print()` - Generate halaman print

### Views:
- `report/index.blade.php` - Halaman laporan utama
- `report/print.blade.php` - Halaman print-ready

### Middleware:
- `role:admin,kasir` - Hanya admin dan kasir yang bisa akses

## 💡 Tips Penggunaan

1. **Analisis Harian**: Set tanggal mulai = tanggal akhir = hari ini
2. **Analisis Mingguan**: Set rentang 7 hari terakhir
3. **Analisis Pelanggan**: Pilih pelanggan tanpa filter tanggal untuk melihat semua transaksi customer
4. **Analisis Produk**: Pilih produk untuk melihat performa penjualan item tertentu
5. **Kombinasi Filter**: Gabungkan filter untuk analisis yang lebih spesifik

## 🎯 Use Cases

### Admin:
- Monitoring performa penjualan keseluruhan
- Analisis produk terlaris
- Tracking revenue per periode
- Membuat laporan untuk manajemen

### Kasir:
- Cek transaksi shift sendiri
- Verifikasi penjualan harian
- Monitoring stok terjual
- Cetak rekap kasir untuk serah terima shift

---

**Dibuat untuk Cupstore - Sistem Kasir Modern** 🛒
