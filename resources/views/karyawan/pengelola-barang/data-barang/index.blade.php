@extends('karyawan.pengelola-barang.template.master')
@section('title', 'Kelola Data Barang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-primary text-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Barang</h6>
                            <h2 class="mb-0">{{ $barang->count() }}</h2>
                        </div>
                        <div class="rounded-circle border border-primary p-3">
                            <i class="mdi mdi-package-variant text-primary h3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-success text-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Stok</h6>
                            <h2 class="mb-0">{{ $barang->sum('stok') }}</h2>
                        </div>
                        <div class="rounded-circle border border-success p-3">
                            <i class="mdi mdi-warehouse text-success h3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-warning text-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Supplier Aktif</h6>
                            <h2 class="mb-0">{{ $suppliers->count() }}</h2>
                        </div>
                        <div class="rounded-circle border border-warning p-3">
                            <i class="mdi mdi-truck-delivery text-warning h3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-info text-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Nilai Barang</h6>
                            <h4 class="mb-0">Rp {{ number_format($barang->sum(function($item) { 
                                return $item->stok * $item->harga_satuan;
                            }), 0, ',', '.') }}</h4>
                        </div>
                        <div class="rounded-circle border border-info p-3">
                            <i class="mdi mdi-currency-usd text-info h3 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Statistics -->
    <div class="row mb-4">
        @php
            $categories = $barang->groupBy('kategori_barang');
        @endphp
        @foreach($categories as $category => $items)
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ $category }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $items->count() }} Items</div>
                            <div class="text-muted small">Total Stok: {{ $items->sum('stok') }}</div>
                        </div>
                        <div class="rounded-circle bg-light p-3">
                            <i class="mdi mdi-folder text-primary h4 mb-0"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Data Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="mdi mdi-package-variant me-1"></i>
                            Data Barang
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($barang as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kode_barang }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->kategori_barang }}</span>
                                    </td>
                                    <td>
                                        @if($item->stok <= 10)
                                            <span class="badge bg-danger">{{ $item->stok }}</span>
                                        @elseif($item->stok <= 20)
                                            <span class="badge bg-warning">{{ $item->stok }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $item->stok }}</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td>{{ $item->supplier->nama_supplier }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Keep existing modals here -->

<!-- Enhanced Datatable Initialization -->
<script>
    $(document).ready(function() {
        new DataTable('#table-barang', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>
@endsection