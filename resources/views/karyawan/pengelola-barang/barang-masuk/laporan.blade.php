<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembelian Barang</title>
    <link rel="icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .filter-info {
            margin-bottom: 15px;
        }
        .summary {
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PEMBELIAN BARANG</h2>
        <p>WashUP Laundry</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="filter-info">
        <p><strong>Filter yang diterapkan:</strong></p>
        @if($filterInfo['startDate'] && $filterInfo['endDate'])
            <p>Periode: {{ \Carbon\Carbon::parse($filterInfo['startDate'])->format('d/m/Y') }} - 
               {{ \Carbon\Carbon::parse($filterInfo['endDate'])->format('d/m/Y') }}</p>
        @endif
        @if($filterInfo['minBiaya'] && $filterInfo['maxBiaya'])
            <p>Range Biaya: Rp {{ number_format($filterInfo['minBiaya']) }} - 
               Rp {{ number_format($filterInfo['maxBiaya']) }}</p>
        @endif
        @if($filterInfo['barang'])
            <p>Barang: {{ $filterInfo['barang']->nama_barang }}</p>
        @endif
    </div>

    <h3>Daftar Transaksi Pembelian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Pembelian</th>
                <th>Waktu</th>
                <th>Total Biaya</th>
                <th>Karyawan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelian as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->no_pembelian }}</td>
                <td>{{ \Carbon\Carbon::parse($p->waktu_pembelian)->format('d/m/Y H:i') }}</td>
                <td>Rp {{ number_format($p->total_biaya) }}</td>
                <td>{{ $p->karyawan->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Ringkasan Per Barang</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Total Unit</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totalPerBarang as $total)
            <tr>
                <td>{{ $total->barang->nama_barang }}</td>
                <td>{{ $total->total_jumlah }}</td>
                <td>Rp {{ number_format($total->total_biaya) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->karyawan->nama_karyawan }}</p>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>