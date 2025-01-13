<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th>No Pembelian</th>
                    <td>:</td>
                    <td>{{ $pembelian->no_pembelian }}</td>
                </tr>
                <tr>
                    <th>Waktu Pembelian</th>
                    <td>:</td>
                    <td>{{ $pembelian->waktu_pembelian }}</td>
                </tr>
                <tr>
                    <th>Karyawan</th>
                    <td>:</td>
                    <td>{{ $pembelian->karyawan->nama_karyawan }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
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
                <tr>
                    <th colspan="5" class="text-end">Total Biaya:</th>
                    <th>Rp {{ number_format($pembelian->total_biaya, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>