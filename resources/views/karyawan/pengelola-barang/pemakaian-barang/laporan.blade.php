<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemakaian Barang</title>
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
        .header p {
            margin: 5px 0;
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
        <h2>LAPORAN PEMAKAIAN BARANG</h2>
        <p>WashUP Laundry</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="filter-info">
        @if($startDate && $endDate)
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        @endif
        @if($selectedBarang)
            <p>Filter Barang: {{ $selectedBarang->nama_barang }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal & Waktu</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <th>Karyawan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemakaianBarang as $index => $pemakaian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pemakaian->waktu_pemakaian)->format('d/m/Y H:i') }}</td>
                    <td>{{ $pemakaian->barang->nama_barang }}</td>
                    <td>{{ $pemakaian->jumlah }}</td>
                    <td>{{ $pemakaian->keterangan }}</td>
                    <td>{{ $pemakaian->karyawan->nama_karyawan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Ringkasan Pemakaian Barang</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Total Pemakaian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($totalPemakaian as $total)
                    <tr>
                        <td>{{ $total['nama_barang'] }}</td>
                        <td>{{ $total['total_jumlah'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->karyawan->nama_karyawan}}</p>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>