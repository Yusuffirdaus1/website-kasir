# 🧾 Fitur Struk Belanja & Pembayaran - Cupstore

## ✨ Fitur Lengkap (Seperti Indomaret)

### 🛒 Proses Checkout

#### 1. **Pilih Metode Pembayaran**
- **Cash / Tunai** - Dengan input jumlah uang & hitung kembalian otomatis
- **Debit Card** - Pembayaran kartu debit
- **Credit Card** - Pembayaran kartu kredit
- **QRIS** - Pembayaran digital

#### 2. **Input Jumlah Bayar (Khusus Cash)**
Ketika memilih Cash, muncul:
- **Input Jumlah Uang**: Field untuk masukkan uang yang dibayar
- **Hitung Kembalian Otomatis**: Real-time menghitung kembalian
- **Tombol Cepat**:
  - **"Pas"** - Set pas sesuai total
  - **Pembulatan ke atas** - Rp 10.000, Rp 50.000, dll
- **Validasi**: Tidak bisa checkout jika uang kurang

#### 3. **Auto Kurangi Stok**
Setelah checkout berhasil:
- ✅ Stok produk otomatis berkurang sesuai quantity
- ✅ Keranjang otomatis dikosongkan
- ✅ Transaksi tersimpan di database

#### 4. **Cetak Struk Belanja**
Redirect otomatis ke halaman struk dengan format seperti Indomaret:

---

## 🧾 Format Struk Belanja

### Header
```
      CUPSTORE
Sistem Kasir & Penjualan Modern
   Jl. Contoh No. 123, Jakarta
     Telp: (021) 1234-5678
================================
```

### Info Transaksi
```
No Invoice:    INV-20251029-0001
Kode Transaksi: TRX-ABC123DEF
Tanggal:       29/10/2025 10:30:15
Kasir:         Admin Cupstore
Pelanggan:     Yusuf Firdaus
================================
```

### Daftar Barang
```
Air Mineral 600ml
  2 x Rp 5.000        Rp 10.000

Snack Keripik
  3 x Rp 8.000        Rp 24.000

Sabun Mandi
  1 x Rp 12.000       Rp 12.000
================================
```

### Total & Pembayaran
```
Subtotal:            Rp 46.000
Diskon:              Rp 0
PPN (0%):            Rp 0
--------------------------------
TOTAL:               Rp 46.000
================================

Metode Bayar:        CASH
Jumlah Bayar:        Rp 50.000
KEMBALIAN:           Rp 4.000
================================
```

### Footer
```
||||| TRX-ABC123DEF |||||

    *** TERIMA KASIH ***
    ATAS KUNJUNGAN ANDA
  BARANG YANG SUDAH DIBELI
   TIDAK DAPAT DIKEMBALIKAN

Powered by Cupstore POS System
    29 Oktober 2025 10:30:15
```

---

## 🎯 Fitur Detail

### 💰 Pembayaran Cash
1. Pilih metode "Cash / Tunai"
2. Muncul form input jumlah bayar
3. Ketik jumlah uang (atau klik tombol cepat)
4. Kembalian muncul otomatis:
   - ✅ **Hijau** jika uang cukup
   - ❌ **Merah** jika uang kurang
5. Validasi sebelum submit:
   - Alert jika uang tidak cukup
   - Tombol "Proses Pembayaran" aktif

### 🎨 Tombol Pembayaran Cepat
```
[  Pas  ] [ Rp 50.000 ] [ Rp 100.000 ]
```
- **Pas**: Set tepat sesuai total belanja
- **Pembulatan**: Auto pembulatan ke nominal mudah (10rb, 50rb, 100rb)

### 🖨️ Struk Belanja
**Fitur Struk:**
- ✅ Layout 80mm (ukuran struk thermal printer standar)
- ✅ Font monospace seperti printer kasir
- ✅ Info lengkap: Invoice, tanggal, kasir, pelanggan
- ✅ Detail produk dengan quantity & harga
- ✅ Subtotal, diskon, pajak (siap untuk pengembangan)
- ✅ Grand total dengan pembayaran & kembalian
- ✅ Barcode transaksi (ASCII art)
- ✅ Footer dengan ucapan terima kasih

**Tombol Aksi:**
- 🖨️ **Cetak Struk** - Print langsung
- 🏠 **Kembali Belanja** - Ke homepage
- 📊 **Dashboard** - Ke dashboard user

### 📉 Auto Kurangi Stok
```php
// Update stock otomatis
$product->decrement('stock', $item['quantity']);
```
- Menggunakan database transaction untuk keamanan
- Rollback otomatis jika terjadi error
- Stok real-time update

---

## 🚀 Cara Penggunaan

### Untuk Pelanggan:
1. **Pilih Produk** di homepage
2. **Tambah ke Keranjang** dengan klik "Tambah ke Keranjang"
3. **Buka Keranjang** dari navbar
4. **Atur Quantity** jika perlu
5. **Pilih Metode Bayar**
6. **Jika Cash**:
   - Masukkan jumlah uang
   - Atau klik tombol cepat
   - Lihat kembalian
7. **Klik "Proses Pembayaran"**
8. **Struk Muncul** otomatis
9. **Cetak** jika perlu

### Untuk Kasir/Admin:
Sama seperti pelanggan, plus:
- Bisa lihat history transaksi
- Akses laporan penjualan
- Monitor stok real-time

---

## 🗄️ Database Structure

### Table: `transactions`
| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `user_id` | bigint | ID pelanggan |
| `transaction_code` | varchar | Kode unik transaksi |
| `invoice_number` | varchar | Nomor invoice (INV-YYYYMMDD-0001) |
| `total_amount` | decimal | Total belanja |
| `cash_amount` | decimal | Jumlah uang dibayar (cash) |
| `change_amount` | decimal | Kembalian |
| `payment_method` | varchar | cash/debit/credit/qris |
| `status` | varchar | completed |
| `created_at` | timestamp | Waktu transaksi |

### Table: `transaction_items`
| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `transaction_id` | bigint | FK to transactions |
| `product_id` | bigint | FK to products |
| `quantity` | int | Jumlah beli |
| `price` | decimal | Harga saat beli |
| `subtotal` | decimal | Quantity × Price |

---

## 💻 Technical Details

### Controller: `TransactionController.php`

#### Method: `checkout()`
```php
- Validasi: payment_method, cash_amount
- Hitung total dari cart
- Validasi uang cukup (jika cash)
- Generate invoice_number otomatis
- Simpan transaksi dengan DB transaction
- Buat transaction_items
- Update stok produk
- Clear cart
- Redirect ke struk
```

#### Method: `receipt()`
```php
- Load transaction dengan relasi
- Return view struk
```

### View: `cart/index.blade.php`
- Form checkout dengan select metode bayar
- Section cash payment (conditional)
- Input jumlah bayar dengan validasi
- Display kembalian real-time
- Tombol pembayaran cepat
- JavaScript untuk:
  - Toggle cash section
  - Hitung kembalian
  - Format number
  - Validasi form

### View: `transaction/receipt.blade.php`
- Layout 80mm width
- CSS print-ready
- Font monospace
- Auto formatting angka
- Barcode ASCII
- Print button

---

## 🎨 UI/UX Features

### Pembayaran
- ✅ Real-time change calculation
- ✅ Visual feedback (hijau/merah)
- ✅ Quick amount buttons
- ✅ Form validation
- ✅ Alert jika uang kurang
- ✅ Auto hide/show cash section

### Struk
- ✅ Clean layout
- ✅ Professional design
- ✅ Print-optimized CSS
- ✅ Fixed width 80mm
- ✅ Dashed borders
- ✅ Clear typography
- ✅ Action buttons (tidak tercetak)

---

## 📱 Responsive & Print

### Screen View
- Struk di tengah layar
- Action buttons visible
- Bisa scroll
- Readable on mobile

### Print View
- Auto hide buttons
- Remove borders
- Optimal 80mm width
- No margins
- Fit thermal printer

---

## 🔧 Customization

### Edit Informasi Toko
File: `transaction/receipt.blade.php`
```php
<div class="store-name">CUPSTORE</div>
<div class="store-info">
    Sistem Kasir & Penjualan Modern<br>
    Jl. Contoh No. 123, Jakarta<br>
    Telp: (021) 1234-5678
</div>
```

### Edit Footer Message
```php
<div class="footer-message">
    *** TERIMA KASIH ***<br>
    ATAS KUNJUNGAN ANDA<br>
    BARANG YANG SUDAH DIBELI<br>
    TIDAK DAPAT DIKEMBALIKAN
</div>
```

### Tambah Diskon/Pajak
Di controller:
```php
$discount = 0; // Implement discount logic
$tax = $total * 0.10; // 10% tax
$grand_total = $total - $discount + $tax;
```

---

## 🎯 Testing

### Test Cash Payment:
1. Login sebagai pelanggan
2. Tambah produk ke cart
3. Checkout → Pilih Cash
4. Test cases:
   - Uang pas ✓
   - Uang lebih ✓
   - Uang kurang (alert) ✓
   - Klik tombol cepat ✓

### Test Other Payment:
1. Pilih Debit/Credit/QRIS
2. Cash section hidden ✓
3. Direct checkout ✓

### Test Struk:
1. Checkout berhasil
2. Redirect ke struk ✓
3. Info lengkap ✓
4. Print preview ✓
5. Kembali ke home ✓

---

## 🚀 Future Enhancements

- [ ] Support discount/promo code
- [ ] Support PPN/Pajak
- [ ] QR Code generator untuk struk
- [ ] Email struk ke customer
- [ ] Integrasi thermal printer
- [ ] Multiple payment method
- [ ] Split payment
- [ ] Member/loyalty points
- [ ] Export struk ke PDF

---

**Dibuat untuk Cupstore - POS System Modern** 🛒
