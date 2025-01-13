<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="mdi mdi-information me-1"></i>
                Informasi Pesanan
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="30%">No Transaksi</th>
                        <td>{{ $pesanan->no_transaksi }}</td>
                    </tr>
                    <tr>
                        <th>Waktu Transaksi</th>
                        <td>{{ $pesanan->waktu_transaksi }}</td>
                    </tr>
                    <tr>
                        <th>Konsumen</th>
                        <td>{{ $pesanan->konsumen->nama_konsumen }}</td>
                    </tr>
                    <tr>
                        <th>Pesan Konsumen</th>
                        <td>{{ $pesanan->pesan_konsumen ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal</th>
                        <td>Rp {{ number_format($pesanan->subtotal + $pesanan->diskon, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Diskon</th>
                        <td>- Rp {{ number_format($pesanan->diskon, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="mdi mdi-format-list-bulleted me-1"></i>
        Rincian Pesanan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Layanan</th>
                        <th>Layanan Tambahan</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan->rincianTransaksi as $index => $rincian)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($rincian->tarifLaundry && $rincian->tarifLaundry->jenisLaundry)
                                {{ $rincian->tarifLaundry->jenisLaundry->nama_jenis }} - 
                                {{ $rincian->tarifLaundry->satuan ?? $rincian->tarifLaundry->nama_pakaian }} -
                                {{ $rincian->tarifLaundry->jenisLaundry->waktu_estimasi }} Hari
                            @else
                                - 
                            @endif
                        </td>
                        <td>{{ $rincian->layananTambahan->nama_layanan ?? '-' }}</td>
                        <td>{{ $rincian->jumlah }}</td>
                        <td>
                            Rp {{ number_format($rincian->layananTambahan->harga ?? $rincian->tarifLaundry->tarif, 0, ',', '.') }}
                        </td>
                        <td>Rp {{ number_format($rincian->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Subtotal</th>
                        <th>Rp {{ number_format($pesanan->subtotal + $pesanan->diskon, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-end">Diskon</th>
                        <th>- Rp {{ number_format($pesanan->diskon, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-end">Total</th>
                        <th>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="mdi mdi-history me-1"></i>
        Riwayat Status
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Karyawan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan->statusPesanan->sortByDesc('waktu_perubahan') as $index => $status)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $status->waktu_perubahan }}</td>
                        <td>
                            <span class="badge {{ 
                                $status->status === 'pending' ? 'bg-secondary' : 
                                ($status->status === 'diproses' ? 'bg-warning' : 
                                ($status->status === 'selesai' ? 'bg-success' : 'bg-danger')) 
                            }}">
                                {{ ucfirst($status->status) }}
                            </span>
                        </td>
                        <td>{{ $status->keterangan }}</td>
                        <td>{{ $status->karyawan->nama_karyawan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
