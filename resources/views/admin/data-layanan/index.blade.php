@extends('admin.template.master')
@section('title', 'Kelola Layanan Tambahan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3 px-4 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-washing-machine fs-4 me-2"></i>
                            <h5 class="mb-0">Data Layanan Tambahan</h5>
                        </div>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="mdi mdi-plus me-1"></i>Tambah Layanan
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped" id="table-layanan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Layanan</th>
                                    <th>Deskripsi</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($layananTambahan as $index => $layanan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                    <td>{{ $layanan->deskripsi }}</td>
                                    <td>{{ $layanan->satuan }}</td>
                                    <td>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $layanan->status == 'Aktif' ? 'bg-success' : 'bg-danger' }} text-white">
                                            {{ ucfirst($layanan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $layanan->id_layanan }}">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $layanan->id_layanan }}">
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
                <h5 class="modal-title">Tambah Layanan Tambahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('layanan-tambahan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control @error('nama_layanan') is-invalid @enderror" 
                               name="nama_layanan" value="{{ old('nama_layanan') }}" required>
                        @error('nama_layanan')
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
                        <label class="form-label">Satuan</label>
                        <select class="form-select @error('satuan') is-invalid @enderror" name="satuan" required>
                            <option value="Per Kilo" {{ old('satuan') == 'Per Kilo' ? 'selected' : '' }}>Per Kilo</option>
                            <option value="Per Item" {{ old('satuan') == 'Per Item' ? 'selected' : '' }}>Per Item</option>
                            <option value="Per Noda" {{ old('satuan') == 'Per Noda' ? 'selected' : '' }}>Per Noda</option>
                            <option value="Per Meter" {{ old('satuan') == 'Per Meter' ? 'selected' : '' }}>Per Meter</option>
                        </select>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="text" class="form-control @error('harga') is-invalid @enderror" 
                               name="harga_display" id="harga_display" required>
                        <input type="hidden" name="harga" id="harga_real">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                        </select>
                        @error('status')
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
@foreach($layananTambahan as $layanan)
<div class="modal fade" id="editModal{{ $layanan->id_layanan }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white">Edit Layanan Tambahan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('layanan-tambahan.update', $layanan->id_layanan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" name="nama_layanan" value="{{ $layanan->nama_layanan }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" required>{{ $layanan->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <select class="form-select @error('satuan') is-invalid @enderror" name="satuan" required>
                            <option value="Per Kilo" {{ $layanan->satuan == 'Per Kilo' ? 'selected' : '' }}>Per Kilo</option>
                            <option value="Per Item" {{ $layanan->satuan == 'Per Item' ? 'selected' : '' }}>Per Item</option>
                            <option value="Per Noda" {{ $layanan->satuan == 'Per Noda' ? 'selected' : '' }}>Per Noda</option>
                            <option value="Per Meter" {{ $layanan->satuan == 'Per Meter' ? 'selected' : '' }}>Per Meter</option>
                        </select>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="text" class="form-control @error('harga') is-invalid @enderror" 
                               name="harga_display{{ $layanan->id_layanan }}" 
                               id="harga_display{{ $layanan->id_layanan }}"
                               value="Rp {{ number_format($layanan->harga, 0, ',', '.') }}" required>
                        <input type="hidden" name="harga" id="harga_real{{ $layanan->id_layanan }}" 
                               value="{{ $layanan->harga }}">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="Aktif" {{ $layanan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Non-Aktif" {{ $layanan->status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
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
<div class="modal fade" id="deleteModal{{ $layanan->id_layanan }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus layanan <strong>{{ $layanan->nama_layanan }}</strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('layanan-tambahan.destroy', $layanan->id_layanan) }}" method="POST" class="d-inline">
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
        new DataTable('#table-layanan', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>
<script>
    document.querySelectorAll('[id^="harga_display"]').forEach(input => {
        input.addEventListener('input', function(e) {
            const id = this.id.replace('harga_display', '');
            const hiddenInput = document.getElementById('harga_real' + id);

            // Remove non-numeric characters
            let value = this.value.replace(/\D/g, '');
            
            // Convert to number and format
            if (value !== '') {
                // Store original number in hidden input
                hiddenInput.value = value;
                
                // Format display value
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(value);
                
                // Remove currency code and trim spaces
                this.value = formatted.replace('IDR', 'Rp').trim();
            }
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
