@extends('admin.template.master')
@section('title', 'Kelola Data Barang')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
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
                <div class="card-body px-3 py-4">
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3 px-4 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-package-variant fs-4 me-2"></i>
                            <h5 class="mb-0">Data Barang</h5>
                        </div>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="mdi mdi-plus me-1"></i>Tambah Data Barang
                        </button>
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
                                    <th>Aksi</th>
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
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id_barang }}">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id_barang }}">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </button>
                                    </td>
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

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Tambah Data Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                               name="nama_barang" value="{{ old('nama_barang') }}" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select @error('kategori_barang') is-invalid @enderror" 
                                name="kategori_barang" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Detergen dan Bahan Kimia">Detergen dan Bahan Kimia</option>
                            <option value="Mesin dan Peralatan">Mesin dan Peralatan</option>
                            <option value="Perlengkapan Laundry">Perlengkapan Laundry</option>
                            <option value="Sparepart dan Aksesoris Mesin">Sparepart dan Aksesoris Mesin</option>
                            <option value="Pakaian dan Seragam">Pakaian dan Seragam</option>
                        </select>
                        @error('kategori_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Satuan</label>
                        <input type="text" class="form-control harga-input @error('harga_satuan') is-invalid @enderror" 
                               name="harga_satuan" value="{{ old('harga_satuan') }}" required>
                        @error('harga_satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Supplier</label>
                        <select class="form-select @error('id_supplier') is-invalid @enderror" name="id_supplier" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                        @error('id_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info">
                        <i class="mdi mdi-content-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
@foreach($barang as $item)
<div class="modal fade" id="editModal{{ $item->id_barang }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white">Edit Data Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('barang.update', $item->id_barang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" value="{{ $item->nama_barang }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select @error('kategori_barang') is-invalid @enderror" name="kategori_barang" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Detergen dan Bahan Kimia" {{ $item->kategori_barang == 'Detergen dan Bahan Kimia' ? 'selected' : '' }}>Detergen dan Bahan Kimia</option>
                            <option value="Mesin dan Peralatan" {{ $item->kategori_barang == 'Mesin dan Peralatan' ? 'selected' : '' }}>Mesin dan Peralatan</option>
                            <option value="Perlengkapan Laundry" {{ $item->kategori_barang == 'Perlengkapan Laundry' ? 'selected' : '' }}>Perlengkapan Laundry</option>
                            <option value="Sparepart dan Aksesoris Mesin" {{ $item->kategori_barang == 'Sparepart dan Aksesoris Mesin' ? 'selected' : '' }}>Sparepart dan Aksesoris Mesin</option>
                            <option value="Pakaian dan Seragam" {{ $item->kategori_barang == 'Pakaian dan Seragam' ? 'selected' : '' }}>Pakaian dan Seragam</option>
                        </select>
                        @error('kategori_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Satuan</label>
                        <input type="text" class="form-control harga-input" name="harga_satuan" 
                               value="Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Supplier</label>
                        <select class="form-select" name="id_supplier" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}" 
                                    {{ $supplier->id_supplier == $item->id_supplier ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="mdi mdi-content-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal{{ $item->id_barang }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus barang <strong>{{ $item->nama_barang }}</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="mdi mdi-delete"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-barang', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>
<script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 3000);
    });

    // Format harga input
    $('.harga-input').on('input', function() {
        // Remove non-digit characters
        let value = this.value.replace(/\D/g, '');
        
        // Format to currency
        if(value != "") {
            value = parseInt(value);
            value = "Rp " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        this.value = value;
    });

    // Clean input on focus
    $('.harga-input').on('focus', function() {
        let value = this.value.replace(/\D/g, '');
        this.value = value;
    });

    // Format input on blur
    $('.harga-input').on('blur', function() {
        let value = this.value.replace(/\D/g, '');
        if(value != "") {
            value = parseInt(value);
            value = "Rp " + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            this.value = value;
        }
    });
</script>
@endsection