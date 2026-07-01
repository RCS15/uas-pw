<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaction->id }}</title>
    <style>
        /* Ukuran Kertas A5 (148.5 x 210 mm) */
        @page {
            size: A5;
            margin: 0;
        }

        body {
            font-family: 'Inter', 'Arial', sans-serif;
            margin: 0;
            padding: 20mm; /* Margin standar untuk A5 di layar */
            background-color: #f3f4f6;
            -webkit-print-color-adjust: exact;
        }

        .receipt-container {
            width: 108.5mm; /* 148.5mm - (20mm * 2) */
            margin: 0 auto;
            background: white;
            padding: 10mm;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 8mm;
        }

        .header h1 {
            font-size: 24pt;
            margin: 0;
            color: #10b981; /* Emerald 500 */
        }

        .header p {
            margin: 1mm 0;
            font-size: 10pt;
            color: #6b7280;
        }

        .divider {
            border-top: 1px dashed #d1d5db;
            margin: 5mm 0;
        }

        .details table {
            width: 100%;
            font-size: 11pt;
            margin-bottom: 5mm;
        }

        .details td {
            padding: 1mm 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
        }

        .items-table th {
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
            padding: 2mm 0;
            color: #374151;
        }

        .items-table td {
            padding: 3mm 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .text-right {
            text-align: right;
        }

        .grand-total {
            margin-top: 8mm;
            padding-top: 5mm;
            border-top: 2px solid #10b981;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 14pt;
            font-weight: bold;
            color: #374151;
        }

        .total-value {
            font-size: 18pt;
            font-weight: 800;
            color: #10b981;
        }

        .footer {
            margin-top: 10mm;
            text-align: center;
            font-size: 9pt;
            color: #9ca3af;
        }

        /* Khusus saat mencetak */
        @media print {
            @page {
                size: A5;
                margin: 0;
            }
            html, body {
                height: 100%;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }
            .receipt-container {
                box-shadow: none !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 10mm !important; /* Jaga margin dalam struk */
                border: none !important;
            }
            .no-print {
                display: none !important;
            }
        }

        /* Custom Animation */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
            50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="receipt-container" id="printable">
        <div class="header">
            <h1>FINBIZ</h1>
            <p>Smart Financial Management</p>
            <p>Struk Pembelian #TRX-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td style="color: #6b7280;">Waktu:</td>
                    <td class="text-right">{{ date('d M Y, H:i', strtotime($transaction->created_at)) }}</td>
                </tr>
                <tr>
                    <td style="color: #6b7280;">Kasir:</td>
                    <td class="text-right font-bold">{{ $transaction->user->name ?? 'User' }}</td>
                </tr>
                <tr>
                    <td style="color: #6b7280;">Metode:</td>
                    <td class="text-right">{{ strtoupper($transaction->tipe_transaksi) }}</td>
                </tr>
            </table>
        </div>

        <div class="divider"></div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->details as $detail)
                    <tr>
                        <td>{{ $detail->product->nama_barang ?? 'Produk Dihapus' }}</td>
                        <td class="text-right">{{ $detail->jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="grand-total">
            <span class="total-label">TOTAL AKHIR</span>
            <span class="total-value">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</span>
        </div>

        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Nota ini adalah bukti pembayaran yang sah.</p>
        </div>
    </div>

    <div class="no-print fixed bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-4 bg-white/80 backdrop-blur-md p-2 rounded-2xl border border-gray-200 shadow-2xl shadow-emerald-900/10 transition-all hover:bg-white">
        <a href="{{ route('nonadmin.transactions.history') }}" 
           class="flex items-center gap-2 px-5 py-3 text-gray-500 hover:text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-50 transition-all group">
            <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
        <div class="w-px h-6 bg-gray-200"></div>
        <button onclick="window.print()" 
                class="flex items-center gap-3 px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-500/20 transition-all active:scale-95 group">
            <svg class="w-5 h-5 animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Struk
        </button>
    </div>

    <script>
        // Memastikan hanya elemen #printable yang diproses oleh pencetakan browser
        // (Sudah dihandle oleh @media print .no-print { display: none; })
    </script>
</body>
</html>
