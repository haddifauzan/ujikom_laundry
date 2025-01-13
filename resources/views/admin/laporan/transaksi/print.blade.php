<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi - Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body { padding: 20px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="text-center mb-4">
            <h2>Laporan Transaksi Laundry</h2>
            <p>Periode: {{ request('start_date', date('Y-m-d')) }} s/d {{ request('end_date', date('Y-m-d')) }}</p>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Konsumen</th>
                    <th>Karyawan</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->no_transaksi }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->waktu_transaksi)->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->konsumen->nama_konsumen }}</td>
                    <td>{{ $item->karyawan->nama_karyawan }}</td>
                    <td>{{ ucfirst($item->status_transaksi) }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-end fw-bold">Total Pendapatan:</td>
                    <td class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-6 text-end">
                <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
                <br><br><br>
                <p>(_____________________)</p>
                <p>Admin</p>
            </div>
        </div>

        <button class="btn btn-primary no-print" onclick="window.print()">Print</button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>