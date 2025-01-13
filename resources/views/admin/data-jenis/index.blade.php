@extends('admin.template.master')
@section('title', 'Kelola Jenis Laundry')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3 px-4 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-washing-machine fs-4 me-2"></i>
                            <h5 class="mb-0">Data Jenis Laundry</h5>
                        </div>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="mdi mdi-plus me-1"></i>Tambah Jenis Laundry
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
                        <table class="table table-striped" id="table-jenis">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar Banner</th>
                                    <th>Nama Jenis</th>
                                    <th>Deskripsi</th>
                                    <th>Estimasi Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jenisLaundry as $index => $jenis)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><img src="{{ asset('storage/jenis-laundry/'.$jenis->gambar) }}" alt="{{ $jenis->nama_jenis }}" style="width: 150px; height: 100px; border-radius: 0;"></td>
                                    <td>{{ $jenis->nama_jenis }}</td>
                                    <td>
                                        <span title="{{ $jenis->deskripsi }}">
                                            {{ Str::limit($jenis->deskripsi, 50) }}
                                        </span>
                                    </td>
                                    <td>{{ $jenis->waktu_estimasi }} hari</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $jenis->id_jenis }}">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $jenis->id_jenis }}">
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
            <div class="modal-header text-white bg-info">
                <h5 class="modal-title">Tambah Jenis Laundry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jenis-laundry.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis</label>
                        <input type="text" class="form-control @error('nama_jenis') is-invalid @enderror" 
                               name="nama_jenis" value="{{ old('nama_jenis') }}" required>
                        @error('nama_jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Waktu Estimasi (hari)</label>
                        <input type="number" class="form-control @error('waktu_estimasi') is-invalid @enderror" 
                               name="waktu_estimasi" value="{{ old('waktu_estimasi') }}" required>
                        @error('waktu_estimasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                               name="gambar" required accept="image/*">
                        <small class="text-muted">Ukuran yang disarankan: 800x400 pixel (rasio 2:1)</small>
                        @error('gambar')
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
@foreach($jenisLaundry as $jenis)
<div class="modal fade" id="editModal{{ $jenis->id_jenis }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white">Edit Jenis Laundry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jenis-laundry.update', $jenis->id_jenis) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jenis</label>
                        <input type="text" class="form-control" name="nama_jenis" value="{{ $jenis->nama_jenis }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" required>{{ $jenis->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Waktu Estimasi (hari)</label>
                        <input type="number" class="form-control" name="waktu_estimasi" value="{{ $jenis->waktu_estimasi }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        <br>
                        <small class="text-muted">Ukuran yang disarankan: 800x400 pixel (rasio 2:1)</small>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Gambar Saat Ini:</label>
                        <img src="{{ asset('storage/jenis-laundry/'.$jenis->gambar) }}" alt="Current Image" 
                             class="img-thumbnail" style="max-height: 150px;">
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
<div class="modal fade" id="deleteModal{{ $jenis->id_jenis }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus jenis laundry <strong>{{ $jenis->nama_jenis }}</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('jenis-laundry.destroy', $jenis->id_jenis) }}" method="POST" class="d-inline">
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
        new DataTable('#table-jenis', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>
@endsection
<script>
    // Auto close alert after 3 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 3000);
</script>