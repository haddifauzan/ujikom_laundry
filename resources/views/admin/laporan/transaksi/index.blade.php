@extends('admin.template.master')
@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-body py-3 px-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-package-variant fs-4 me-2"></i>
                    <h5 class="mb-0">Laporan Transaksi</h5>
                </div>
                <div>
                    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection">
                        <i class="mdi mdi-filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body py-3 px-4">        
        <div class="collapse" id="filterSection">
            <div class="card-body border-bottom">
                <form action="{{ route('admin.laporan-transaksi.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Periode Awal</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Periode Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Transaksi</label>
                        <select class="form-select" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="diproses">Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="gagal">Gagal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Karyawan</label>
                        <select class="form-select" name="karyawan">
                            <option value="">Semua Karyawan</option>
                            @foreach($karyawan as $karyawanItem)
                                <option value="{{ $karyawanItem->id_karyawan }}" 
                                    {{ request('karyawan') == $karyawanItem->id_karyawan ? 'selected' : '' }}>
                                    {{ $karyawanItem->nama_karyawan }}
                                </option>
                            @endforeach
                        </select>
                    </div>                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-info">Terapkan Filter</button>
                        <a href="{{ route('admin.laporan-transaksi.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <div class="btn-group">
                    <a href="{{ route('admin.laporan-transaksi.print') }}?{{ http_build_query(request()->all()) }}" 
                       class="btn btn-outline-danger" target="_blank">
                        <i class="mdi mdi-printer me-2"></i> Print
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="table-transaksi">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Konsumen</th>
                            <th>Karyawan</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Aksi</th>
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
                            <td>
                                <span class="badge bg-{{ $item->status_transaksi == 'selesai' ? 'success' : ($item->status_transaksi == 'diproses' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($item->status_transaksi) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.laporan-transaksi.detail', $item->id_transaksi) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Total Pendapatan:</td>
                            <td colspan="2" class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    new DataTable('#table-transaksi', {
        paging: true,
        info: true,
        ordering: true
    });
});
</script>
@endsection

