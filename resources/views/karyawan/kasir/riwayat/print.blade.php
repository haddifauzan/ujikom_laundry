<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - WashUP Laundry</title>
    <link rel="icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}" type="image/png">
    <style>
        @page {
            size: A4 portrait;
            margin: 2.5cm 2cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            margin: 0;
            padding: 32px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 16pt;
        }
        .header p {
            margin: 0;
            font-size: 12pt;
        }
        .info {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px 0;
            border: none;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: auto;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
        }
        .data-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: center;
        }
        .data-table td {
            text-align: left;
        }
        .data-table td.number {
            text-align: right;
        }
        .summary {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .summary-table {
            width: 50%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .summary-table th, .summary-table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .summary-table th {
            text-align: left;
            font-weight: bold;
            background-color: #f4f4f4;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            page-break-inside: avoid;
        }
        .footer p {
            margin: 5px 0;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN TRANSAKSI LAUNDRY</h2>
        <p>WashUP Laundry</p>
        <p>Jl.Abdul Halim No.82, Cigugur Tengah, Cimahi</p>
        <p>Telp: 0813-1326-4584</p>
    </div>

    <div class="info">
        <table class="info-table">
            <tr>
                <td width="120">Nama Kasir</td>
                <td width="10">:</td>
                <td>{{ $karyawan->nama_karyawan }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Semua' }} 
                   {{ $endDate ? '- '.\Carbon\Carbon::parse($endDate)->format('d/m/Y') : '' }}</td>
            </tr>
            <tr>
                <td>Waktu Cetak</td>
                <td>:</td>
                <td>{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No Transaksi</th>
                <th width="15%">Waktu</th>
                <th width="20%">Konsumen</th>
                <th width="15%">Subtotal</th>
                <th width="15%">Diskon</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $transaksi)
            <tr>
                <td class="number">{{ $index + 1 }}</td>
                <td>{{ $transaksi->no_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('d/m/Y H:i') }}</td>
                <td>{{ $transaksi->konsumen->nama_konsumen }}</td>
                <td class="number">Rp {{ number_format($transaksi->subtotal + $transaksi->diskon, 0, ',', '.') }}</td>
                <td class="number">Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                <td class="number">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <table class="summary-table">
            <tr>
                <th width="60%">Total SemuaTransaksi</th>
                <td class="number">{{ $totalTransaksi }} transaksi</td>
            </tr>
            <tr>
                <th width="60%">Total Transaksi Selesai</th>
                <td class="number">{{ $totalTransaksiSelesai }} transaksi</td>
            </tr>
            <tr>
                <th>Total Transaksi Gagal</th>
                <td class="number">{{ $totalTransaksiGagal }} transaksi</td>
            </tr>
            <tr>
                <th>Total Pendapatan</th>
                <td class="number">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>{{ now()->format('d F Y') }}</p>
        <p style="margin-top: 50px;">{{ $karyawan->nama_karyawan }}</p>
        <p>Kasir</p>
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Cetak Laporan
        </button>
    </div>
</body>
</html>
