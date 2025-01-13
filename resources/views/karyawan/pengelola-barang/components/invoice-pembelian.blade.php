<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembelian - {{ $pembelian->no_pembelian }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        @media print {
            body {
                margin: 20px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">WashUP Laundry</div>
        <div>Jl. Kebon Jeruk Raya No. 27, Jakarta Barat</div>
        <div>Telp: (021) 1234567</div>
    </div>

    <div class="invoice-title">
        INVOICE PEMBELIAN BARANG<br>
        {{ $pembelian->no_pembelian }}
    </div>

    <table class="info-table">
        <tr>
            <td width="120">Tanggal</td>
            <td width="10">:</td>
            <td>{{ date('d/m/Y H:i', strtotime($pembelian->waktu_pembelian)) }}</td>
        </tr>
        <tr>
            <td>Karyawan</td>
            <td>:</td>
            <td>{{ $pembelian->karyawan->nama_karyawan }}</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelian->rincianPembelian as $index => $rincian)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $rincian->barang->nama_barang }}</td>
                <td>{{ $rincian->barang->kategori_barang }}</td>
                <td>{{ $rincian->jumlah }}</td>
                <td>Rp {{ number_format($rincian->barang->harga_satuan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($rincian->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align: right">Total Biaya:</td>
                <td>Rp {{ number_format($pembelian->total_biaya, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div style="margin-bottom: 80px;">Hormat Kami,</div>
        <div>{{ $pembelian->karyawan->nama_karyawan }}</div>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px;">Cetak Invoice</button>
    </div>
</body>
</html>