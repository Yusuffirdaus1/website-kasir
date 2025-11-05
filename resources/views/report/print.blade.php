<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Cupstore</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #2563eb;
            font-size: 32px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .info-section {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-card.purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .stat-label {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .product-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .product-list li {
            padding: 2px 0;
            font-size: 12px;
        }

        .total-row {
            font-weight: bold;
            background: #f3f4f6;
            font-size: 14px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            padding: 0 50px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #333;
            padding-top: 5px;
            min-width: 200px;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }

            @page {
                margin: 20mm;
            }
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
        }

        .print-button:hover {
            background: #1e40af;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak Laporan</button>

    <!-- Header -->
    <div class="header">
        <h1>CUPSTORE</h1>
        <p>Laporan Penjualan</p>
        <p style="font-size: 12px; margin-top: 5px;">Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Filter Information -->
    <div class="info-section">
        <h3 style="margin-bottom: 15px; color: #2563eb;">Informasi Filter:</h3>
        <div class="info-row">
            <span class="info-label">Periode:</span>
            <span class="info-value">
                @if($filterInfo['start_date'] || $filterInfo['end_date'])
                    {{ $filterInfo['start_date'] ? \Carbon\Carbon::parse($filterInfo['start_date'])->format('d M Y') : 'Awal' }}
                    s/d
                    {{ $filterInfo['end_date'] ? \Carbon\Carbon::parse($filterInfo['end_date'])->format('d M Y') : 'Sekarang' }}
                @else
                    Semua Periode
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Pelanggan:</span>
            <span class="info-value">{{ $filterInfo['customer'] ? $filterInfo['customer']->name : 'Semua Pelanggan' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Produk:</span>
            <span class="info-value">{{ $filterInfo['product'] ? $filterInfo['product']->name : 'Semua Produk' }}</span>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ $totalTransactions }}</div>
        </div>
        <div class="stat-card green">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card purple">
            <div class="stat-label">Total Item Terjual</div>
            <div class="stat-value">{{ $totalItems }}</div>
        </div>
    </div>

    <!-- Transactions Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Qty</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $transaction->invoice_number }}</td>
                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>
                        <ul class="product-list">
                            @foreach($transaction->items as $item)
                                <li>• {{ $item->product->name }} ({{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="text-align: center;">{{ $transaction->items->sum('quantity') }}</td>
                    <td style="text-align: right; font-weight: 600; color: #059669;">
                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        Tidak ada data transaksi
                    </td>
                </tr>
            @endforelse
            
            @if($transactions->count() > 0)
                <tr class="total-row">
                    <td colspan="5" style="text-align: right;">GRAND TOTAL:</td>
                    <td style="text-align: center;">{{ $totalItems }}</td>
                    <td style="text-align: right; color: #059669;">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <p style="margin-bottom: 10px;">Mengetahui,</p>
            <div class="signature-line">
                <strong>Manager</strong>
            </div>
        </div>
        <div class="signature-box">
            <p style="margin-bottom: 10px;">Dibuat oleh,</p>
            <div class="signature-line">
                <strong>{{ Auth::user()->name }}</strong>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>CUPSTORE</strong> - Sistem Kasir & Penjualan</p>
        <p style="margin-top: 5px;">Dokumen ini dicetak secara otomatis dan sah tanpa tanda tangan</p>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = () => window.print();
    </script>
</body>
</html>
