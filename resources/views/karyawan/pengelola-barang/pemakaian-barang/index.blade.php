@extends('karyawan.pengelola-barang.template.master')
@section('title', 'Kelola Pemakaian Barang')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title mb-4 text-center">Tambah Pemakaian Barang</h1>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('karyawan.pemakaian-barang.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Barang</label>
                                    <select class="form-select @error('id_barang') is-invalid @enderror" name="id_barang" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id_barang }}">
                                                {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                           name="jumlah" required min="1">
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Waktu Pemakaian</label>
                                    <input type="datetime-local" class="form-control @error('waktu_pemakaian') is-invalid @enderror" 
                                           name="waktu_pemakaian" required>
                                    @error('waktu_pemakaian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                              name="keterangan" required rows="3"></textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-info">
                                <i class="mdi mdi-content-save-outline me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <i class="mdi mdi-history me-1"></i>
                    Riwayat Pemakaian Barang
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <form action="{{ route('karyawan.pemakaian-barang.index') }}" method="GET">
                            <div class="row mb-4">
                                <div class="col-md-5">
                                    <label class="form-label">Filter berdasarkan tanggal:</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                                        <span class="input-group-text">sampai</span>
                                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Filter berdasarkan barang:</label>
                                    <select class="form-select" name="id_barang">
                                        <option value="">Semua Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id_barang }}" {{ request('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                                                {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-info">
                                            <i class="mdi mdi-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('karyawan.pemakaian-barang.index') }}" class="btn btn-secondary">
                                            <i class="mdi mdi-refresh"></i> Reset
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <a href="{{ route('karyawan.pemakaian-barang.cetak-laporan', request()->all()) }}" class="btn btn-danger" target="_blank">
                                            <i class="mdi mdi-printer"></i> Cetak Laporan
                                        </a>                                        
                                    </div>
                                </div>
                            </div>
                        </form>                        
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="table-pemakaian">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
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
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
    
<script>
    $(document).ready(function() {
        new DataTable('#table-pemakaian', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true,    // Mengaktifkan fitur pengurutan
            language: {
                emptyTable: "Tidak ada data ditemukan" // Menampilkan pesan jika data tidak tersedia
            }
        });
    });
</script>
@endsection