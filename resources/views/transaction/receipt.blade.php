<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja - {{ $transaction->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
            background: white;
            font-size: 12px;
        }

        .receipt {
            border: 1px dashed #333;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .store-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .store-info {
            font-size: 10px;
            margin-top: 5px;
            line-height: 1.4;
        }

        .transaction-info {
            border-bottom: 1px dashed #333;
            padding-bottom: 8px;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .transaction-info div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .items-section {
            border-bottom: 1px dashed #333;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .item {
            margin-bottom: 8px;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }

        .totals {
            border-bottom: 1px dashed #333;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .total-row.grand-total {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 5px;
        }

        .payment-info {
            border-bottom: 1px dashed #333;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .payment-row.change {
            font-weight: bold;
            font-size: 13px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 10px;
        }

        .footer-message {
            margin: 8px 0;
            line-height: 1.4;
        }

        .barcode {
            text-align: center;
            margin: 10px 0;
            font-size: 10px;
            letter-spacing: 2px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            font-family: 'Segoe UI', sans-serif;
            z-index: 1000;
        }

        .print-button:hover {
            background: #1e40af;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .action-buttons a,
        .action-buttons button {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .receipt {
                border: none;
            }

            .print-button,
            .action-buttons {
                display: none;
            }

            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="action-buttons no-print">
        <button onclick="window.print()" class="btn-primary">🖨️ Cetak Struk</button>
        <a href="{{ route('home') }}" class="btn-secondary">Kembali Belanja</a>
        <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard</a>
    </div>

    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="store-name">CUPSTORE</div>
            <div class="store-info">
                Sistem Kasir & Penjualan Modern<br>
                Jl. Contoh No. 123, Jakarta<br>
                Telp: (021) 1234-5678
            </div>
        </div>

        <!-- Transaction Info -->
        <div class="transaction-info">
            <div>
                <span>No Invoice:</span>
                <span><strong>{{ $transaction->invoice_number }}</strong></span>
            </div>
            <div>
                <span>Kode Transaksi:</span>
                <span>{{ $transaction->transaction_code }}</span>
            </div>
            <div>
                <span>Tanggal:</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</span>
            </div>
            <div>
                <span>Kasir:</span>
                <span>{{ $transaction->user->name }}</span>
            </div>
            <div>
                <span>Pelanggan:</span>
                <span>{{ $transaction->user->name }}</span>
            </div>
        </div>

        <!-- Items -->
        <div class="items-section">
            @foreach($transaction->items as $item)
            <div class="item">
                <div class="item-name">{{ $item->product->name }}</div>
                <div class="item-detail">
                    <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Diskon:</span>
                <span>Rp 0</span>
            </div>
            <div class="total-row">
                <span>PPN (0%):</span>
                <span>Rp 0</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="payment-row">
                <span>Metode Bayar:</span>
                <span>{{ strtoupper($transaction->payment_method) }}</span>
            </div>
            @if($transaction->payment_method === 'cash')
            <div class="payment-row">
                <span>Jumlah Bayar:</span>
                <span>Rp {{ number_format($transaction->cash_amount, 0, ',', '.') }}</span>
            </div>
            <div class="payment-row change">
                <span>KEMBALIAN:</span>
                <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
            </div>
            @else
            <div class="payment-row">
                <span>Jumlah Bayar:</span>
                <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        <!-- Barcode -->
        <div class="barcode">
            ||||| {{ $transaction->transaction_code }} |||||
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-message">
                *** TERIMA KASIH ***<br>
                ATAS KUNJUNGAN ANDA<br>
                BARANG YANG SUDAH DIBELI<br>
                TIDAK DAPAT DIKEMBALIKAN
            </div>
            <div style="margin-top: 10px; font-size: 9px;">
                Powered by Cupstore POS System<br>
                {{ now()->format('d F Y H:i:s') }}
            </div>
        </div>
    </div>

    <script>
        // Auto print on load (optional - uncomment if you want auto print)
        // window.onload = () => window.print();
    </script>
</body>
</html>
