<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Laundry</title>
    <link rel="icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}" type="image/png">
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            width: 80mm; /* Standard thermal receipt width */
            margin: 0 auto;
            padding: 8px;
            font-size: 12px;
        }

        /* Header styles */
        .invoice-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ccc;
        }

        .invoice-header h1 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .invoice-header p {
            font-size: 12px;
            margin: 2px 0;
        }

        /* Customer and order details */
        .info-section {
            margin-bottom: 15px;
        }

        .info-section h3 {
            font-size: 12px;
            margin-bottom: 5px;
            padding-bottom: 2px;
            border-bottom: 1px solid #eee;
        }

        .customer-details p, 
        .order-details p {
            margin: 3px 0;
            font-size: 11px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
        }

        th, td {
            padding: 4px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .text-end {
            text-align: right;
        }

        /* Total section */
        .total-section {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }

        /* Important notice */
        .important-notice {
            margin: 10px 0;
            padding: 8px;
            font-size: 10px;
            border: 1px solid #eee;
            border-style: dashed;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
        }

        .payment-details {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }

        .barcode-section {
            text-align: center;
            margin: 15px 0;
            padding: 10px 0;
            border-top: 1px dashed #ccc;
        }
        
        .barcode-container {
            margin: 10px auto;
        }
        
        .barcode-number {
            font-family: monospace;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Print specific styles */
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 5px;
            }

            .no-print {
                display: none;
            }

            /* Ensure page breaks don't occur within sections */
            .info-section,
            table,
            .total-section,
            .important-notice,
            .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>WashUP Laundry</h1>
        <p id="invoice-number">{{ $transaksi->no_transaksi }}</p>
        <p>{{ date('d/m/Y H:i', strtotime($transaksi->waktu_transaksi)) }}</p>
    </div>

    <div class="info-section">
        <h3>Detail Konsumen</h3>
        <p>Nama: {{ $transaksi->konsumen->nama_konsumen }}</p>
        <p>Kode: {{ $transaksi->konsumen->kode_konsumen }}</p>
        <p>No. HP: {{ $transaksi->konsumen->noHp_konsumen }}</p>
        @if($transaksi->konsumen->alamat_konsumen)
        <p>Alamat: {{ $transaksi->konsumen->alamat_konsumen }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th class="text-end">Harga</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->rincianTransaksi as $rincian)
            <tr>
                <td>
                    @if($rincian->tarifLaundry && $rincian->tarifLaundry->jenisLaundry)
                        {{ $rincian->tarifLaundry->jenisLaundry->nama_jenis }}
                    @elseif($rincian->layananTambahan)
                        {{ $rincian->layananTambahan->nama_layanan }}
                    @endif
                </td>
                <td>{{ $rincian->jumlah }}</td>
                <td class="text-end">{{ number_format($rincian->subtotal/$rincian->jumlah, 0, ',', '.') }}</td>
                <td class="text-end">{{ number_format($rincian->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($transaksi->voucher)
        <div class="total-row">
            <span>Diskon</span>
            <span>-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="total-row">
            <strong>Total Bayar</strong>
            <strong>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="payment-details">
        <div class="payment-row">
            <span>Pembayaran</span>
            <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div class="payment-row">
            <span>Kembalian</span>
            <span>Rp {{ number_format($transaksi->bayar - $transaksi->subtotal, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="important-notice">
        *PENTING*
        - Simpan struk ini sebagai bukti pengambilan
        - Pengambilan wajib membawa struk
        @if(!$transaksi->konsumen->member)
        - Sebutkan kode konsumen saat pengambilan
        @endif
        - Laundry tidak diambil >30 hari diluar tanggung jawab kami
    </div>

    <div class="barcode-section">
        <div class="barcode-container">
            <!-- QR Code will be generated based on transaction number -->
            @php
                $qrCodeValue = $transaksi->no_transaksi;
            @endphp
            
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrCodeValue) }}" alt="QR Code" width="80" height="80">
        </div>
        <div class="barcode-number">{{ $transaksi->no_transaksi }}</div>
    </div>

    <div class="footer">
        <p>Kasir: {{ $transaksi->karyawan->nama_karyawan }}</p>
        <p>Terima kasih telah menggunakan jasa kami</p>
        <button onclick="window.print()" class="no-print" style="padding: 8px 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer; margin-top: 10px; font-size: 12px;">Print Struk</button>
        <a href="{{ route('transaksi.step1') }}" class="no-print" style="padding: 8px 16px; background-color: #007bff; color: white; text-decoration: none; border: none; cursor: pointer; margin-top: 10px; font-size: 12px;">Kembali ke Kasir</a>
    </div>
</body>
</html>