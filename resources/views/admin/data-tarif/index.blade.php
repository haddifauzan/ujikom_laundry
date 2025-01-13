@extends('admin.template.master')
@section('title', 'Kelola Tarif Laundry')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-3 px-4 border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-cash-multiple fs-4 me-2"></i>
                            <h5 class="mb-0">Data Tarif Laundry</h5>
                        </div>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="mdi mdi-plus me-1"></i>Tambah Tarif Laundry
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
                        <table class="table table-striped" id="table-tarif">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Laundry</th>
                                    <th>Jenis Tarif</th>
                                    <th>Nama Pakaian</th>
                                    <th>Satuan</th>
                                    <th>Tarif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tarifLaundry as $index => $tarif)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $tarif->jenisLaundry->nama_jenis }}</td>
                                    <td>
                                        @if($tarif->jenis_tarif == 'satuan')
                                            <span class="badge bg-primary text-capitalize">{{ $tarif->jenis_tarif }}</span>
                                        @else
                                            <span class="badge bg-secondary text-capitalize">{{ $tarif->jenis_tarif }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $tarif->nama_pakaian ?? '-' }}</td>
                                    <td>{{ $tarif->satuan ?? '-' }}</td>
                                    <td>Rp {{ number_format($tarif->tarif, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $tarif->id_tarif }}">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tarif->id_tarif }}">
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
                <h5 class="modal-title">Tambah Tarif Laundry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tarif-laundry.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Laundry</label>
                        <select class="form-select @error('id_jenis') is-invalid @enderror" 
                                name="id_jenis" required>
                            <option value="">Pilih Jenis Laundry</option>
                            @foreach($jenisLaundry as $jenis)
                                <option value="{{ $jenis->id_jenis }}">{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                        @error('id_jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Tarif</label>
                        <select class="form-select @error('jenis_tarif') is-invalid @enderror" 
                                name="jenis_tarif" id="jenisTarifAdd" required>
                            <option value="">Pilih Jenis Tarif</option>
                            <option value="satuan">Satuan</option>
                            <option value="jenis pakaian">Jenis Pakaian</option>
                        </select>
                        @error('jenis_tarif')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Input Satuan - Initially Hidden -->
                    <div class="mb-3" id="satuanInputAdd" style="display: none;">
                        <label class="form-label">Satuan</label>
                        <select class="form-select @error('satuan') is-invalid @enderror" name="satuan">
                            <option value="Per Kilo">Per Kilo</option>
                        </select>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Input Nama Pakaian - Initially Hidden -->
                    <div class="mb-3" id="pakaianInputAdd" style="display: none;">
                        <label class="form-label">Jenis Pakaian</label>
                        <input type="text" class="form-control @error('nama_pakaian') is-invalid @enderror" 
                               name="nama_pakaian" placeholder="Contoh: Baju, Celana, dll">
                        @error('nama_pakaian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarif (Rp)</label>
                        <input type="text" class="form-control @error('tarif') is-invalid @enderror" 
                               name="tarif_display" id="tarif_display" required>
                        <input type="hidden" name="tarif" id="tarif_real">
                        @error('tarif')
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
@foreach($tarifLaundry as $tarif)
<div class="modal fade" id="editModal{{ $tarif->id_tarif }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white">Edit Tarif Laundry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tarif-laundry.update', $tarif->id_tarif) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Laundry</label>
                        <select class="form-select" name="id_jenis" required>
                            @foreach($jenisLaundry as $jenis)
                                <option value="{{ $jenis->id_jenis }}" 
                                    {{ $tarif->id_jenis == $jenis->id_jenis ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Tarif</label>
                        <select class="form-select" name="jenis_tarif" 
                                id="jenisTarifEdit{{ $tarif->id_tarif }}" required>
                            <option value="satuan" {{ $tarif->jenis_tarif == 'satuan' ? 'selected' : '' }}>Satuan</option>
                            <option value="jenis pakaian" {{ $tarif->jenis_tarif == 'jenis pakaian' ? 'selected' : '' }}>Jenis Pakaian</option>
                        </select>
                    </div>
                    <!-- Input Satuan -->
                    <div class="mb-3" id="satuanInputEdit{{ $tarif->id_tarif }}" 
                         style="display: {{ $tarif->jenis_tarif == 'satuan' ? 'block' : 'none' }};">
                        <label class="form-label">Satuan</label>
                        <select class="form-select @error('satuan') is-invalid @enderror" name="satuan">
                            <option value="Per Kilo" {{ $tarif->satuan == 'per kilo' ? 'selected' : '' }}>Per Kilo</option>
                        </select>
                    </div>
                    <!-- Input Nama Pakaian -->
                    <div class="mb-3" id="pakaianInputEdit{{ $tarif->id_tarif }}" 
                         style="display: {{ $tarif->jenis_tarif == 'pakaian' ? 'block' : 'none' }};">
                        <label class="form-label">Jenis Pakaian</label>
                        <input type="text" class="form-control" name="nama_pakaian" 
                               value="{{ $tarif->nama_pakaian }}" placeholder="Contoh: Baju, Celana, dll">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarif (Rp)</label>
                        <input type="text" class="form-control @error('tarif') is-invalid @enderror" 
                               name="tarif_display{{ $tarif->id_tarif }}" 
                               id="tarif_display{{ $tarif->id_tarif }}"
                               value="Rp {{ number_format($tarif->tarif, 0, ',', '.') }}" required>
                        <input type="hidden" name="tarif" id="tarif_real{{ $tarif->id_tarif }}" 
                               value="{{ $tarif->tarif }}">
                        @error('tarif')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
<div class="modal fade" id="deleteModal{{ $tarif->id_tarif }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus tarif untuk {{ $tarif->nama_pakaian }}?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('tarif-laundry.destroy', $tarif->id_tarif) }}" method="POST" class="d-inline">
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

<script>
    $(document).ready(function() {
        new DataTable('#table-tarif', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>

<!-- Alert Auto Close -->
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 3000);
</script>

<script>
    // Fungsi untuk modal tambah
    document.getElementById('jenisTarifAdd').addEventListener('change', function() {
        const satuanInput = document.getElementById('satuanInputAdd');
        const pakaianInput = document.getElementById('pakaianInputAdd');
        
        if (this.value === 'satuan') {
            satuanInput.style.display = 'block';
            pakaianInput.style.display = 'none';
            pakaianInput.querySelector('input').value = '';
        } else if (this.value === 'jenis pakaian') {
            satuanInput.style.display = 'none';
            pakaianInput.style.display = 'block';
            satuanInput.querySelector('input').value = '';
        } else {
            satuanInput.style.display = 'none';
            pakaianInput.style.display = 'none';
        }
    });
    
    // Fungsi untuk modal edit
    @foreach($tarifLaundry as $tarif)
        // Set initial display based on existing data
        window.addEventListener('load', function() {
            const satuanInput = document.getElementById('satuanInputEdit{{ $tarif->id_tarif }}');
            const pakaianInput = document.getElementById('pakaianInputEdit{{ $tarif->id_tarif }}');
            
            if ('{{ $tarif->jenis_tarif }}' === 'satuan') {
                satuanInput.style.display = 'block';
                pakaianInput.style.display = 'none';
            } else if ('{{ $tarif->jenis_tarif }}' === 'jenis pakaian') {
                satuanInput.style.display = 'none';
                pakaianInput.style.display = 'block';
            }
        });

        document.getElementById('jenisTarifEdit{{ $tarif->id_tarif }}').addEventListener('change', function() {
            const satuanInput = document.getElementById('satuanInputEdit{{ $tarif->id_tarif }}');
            const pakaianInput = document.getElementById('pakaianInputEdit{{ $tarif->id_tarif }}');
            
            if (this.value === 'satuan') {
                satuanInput.style.display = 'block';
                pakaianInput.style.display = 'none';
                pakaianInput.querySelector('input').value = '';
            } else if (this.value === 'jenis pakaian') {
                satuanInput.style.display = 'none';
                pakaianInput.style.display = 'block';
                satuanInput.querySelector('input').value = '';
            } else {
                satuanInput.style.display = 'none';
                pakaianInput.style.display = 'none';
            }
        });
    @endforeach
    
    // Form validation untuk memastikan input yang sesuai diisi
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const jenisTarif = this.querySelector('[name="jenis_tarif"]').value;
            const satuan = this.querySelector('[name="satuan"]').value;
            const namaPakaian = this.querySelector('[name="nama_pakaian"]').value;
            
            if (jenisTarif === 'satuan' && !satuan) {
                e.preventDefault();
                alert('Silakan isi satuan');
            } else if ( jenisTarif === 'jenis pakaian' && !namaPakaian) {
                e.preventDefault();
                alert('Silakan isi nama pakaian');
            }
        });
    });
</script>

<script>
    document.querySelectorAll('[id^="tarif_display"]').forEach(input => {
        input.addEventListener('input', function(e) {
            const id = this.id.replace('tarif_display', '');
            const hiddenInput = document.getElementById('tarif_real' + id);

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