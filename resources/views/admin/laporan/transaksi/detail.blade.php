@extends('admin.template.master')
@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Transaksi {{ $transaksi->no_transaksi }}</h4>
                <a href="{{ route('admin.laporan-transaksi.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Informasi Transaksi -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informasi Transaksi</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">No Transaksi</td>
                            <td>: {{ $transaksi->no_transaksi }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: {{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: <span class="badge bg-primary text-uppercase">{{ $transaksi->status_transaksi }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Konsumen</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%">Nama</td>
                            <td>: {{ $transaksi->konsumen->nama_konsumen }}</td>
                        </tr>
                        <tr>
                            <td>Karyawan</td>
                            <td>: {{ $transaksi->karyawan->nama_karyawan }}</td>
                        </tr>
                        <tr>
                            <td>Voucher</td>
                            <td>: {{ $transaksi->voucher ? $transaksi->voucher->kode_voucher : 'Tidak ada' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Rincian Layanan -->
            <h5>Rincian Layanan</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Layanan</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->rincianTransaksi as $index => $rincian)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($rincian->tarifLaundry)
                                    {{ $rincian->tarifLaundry->jenisLaundry->nama_jenis ?? "" }}
                                    @if($rincian->tarifLaundry->nama_pakaian || $rincian->tarifLaundry->satuan)
                                        - {{ $rincian->tarifLaundry->nama_pakaian ?? $rincian->tarifLaundry->satuan }}
                                    @endif
                                @endif
                                @if($rincian->layananTambahan)
                                    <span class="text-primary fw-bold">
                                        {{ $rincian->layananTambahan->nama_layanan }}
                                    </span>
                                @endif
                            </td>
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
                            <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                            <td>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if($transaksi->diskon > 0)
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Diskon:</td>
                            <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total Bayar:</td>
                            <td class="fw-bold">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Status Pesanan Timeline -->
            @if($transaksi->statusPesanan->count() > 0)
            <div class="mt-4">
                <h5>Status Pesanan</h5>
                <div class="timeline">
                    @php
                    $sortedStatus = $transaksi->statusPesanan->sortByDesc(function ($status) {
                        return $status->status === 'pending' ? 3 : ($status->status === 'proses' ? 2 : 1);
                    });
                    @endphp
                    @foreach($sortedStatus as $status)
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-content">
                            <h6>
                                <span class="badge bg-{{ $status->status === 'pending' ? 'warning' : ($status->status === 'proses' ? 'info' : 'success') }} text-uppercase">
                                    {{ $status->status }}
                                </span>
                            </h6>
                            <p class="text-muted">
                                {{ \Carbon\Carbon::parse($status->created_at)->format('d/m/Y H:i') }}
                            </p>
                            @if($status->keterangan)
                            <p>{{ $status->keterangan }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}

.timeline-point {
    position: absolute;
    left: 0;
    width: 12px;
    height: 12px;
    background: #007bff;
    border-radius: 50%;
}

.timeline-point:before {
    content: '';
    position: absolute;
    left: 50%;
    top: 12px;
    bottom: -20px;
    width: 2px;
    background: #e9ecef;
    transform: translateX(-50%);
}

.timeline-item:last-child .timeline-point:before {
    display: none;
}

.timeline-content {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 4px;
}
</style>
@endsection
