<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang - Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}" type="image/png">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="text-center mb-4">
            <h2>Laporan Inventaris Barang</h2>
            <p>Periode: {{ request('start_date', date('Y-m-d')) }} s/d {{ request('end_date', date('Y-m-d')) }}</p>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga Satuan</th>
                    <th>Supplier</th>
                    <th>Total Pemakaian</th>
                    <th>Total Pembelian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori_barang }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $item->supplier->nama_supplier }}</td>
                    <td>{{ $item->pemakaianBarang->sum('jumlah') }}</td>
                    <td>{{ $item->rincianPembelian->sum('jumlah') }}</td>
                </tr>
                @endforeach
            </tbody>
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