@extends('admin.template.master')
@section('title', 'Laporan Barang')

@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-body py-3 px-4 border-bottom"> 
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-package-variant fs-4 me-2"></i>
                    <h5 class="mb-0">Laporan Barang</h5>
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
                <form action="{{ route('admin.laporan-barang.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Periode Awal</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Periode Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $kategori)
                                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Supplier</label>
                        <select class="form-select" name="supplier">
                            <option value="">Semua Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}" {{ request('supplier') == $supplier->id_supplier ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-info">Terapkan Filter</button>
                        <a href="{{ route('admin.laporan-barang.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>                
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <div class="btn-group">
                    <a href="{{ route('admin.laporan-barang.print') }}?{{ http_build_query(request()->all()) }}" 
                       class="btn btn-outline-danger" target="_blank">
                        <i class="mdi mdi-printer me-2"></i> Print
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="table-barang">
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
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    new DataTable('#table-barang', {
        paging: true,
        info: true,
        ordering: true
    });
});
</script>
@endsection