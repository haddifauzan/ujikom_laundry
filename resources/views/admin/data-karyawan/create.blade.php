@extends('admin.template.master')
@section('title', 'Tambah Karyawan')

@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4 border-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="text-dark">
                    <i class="mdi mdi-account-multiple-plus me-1"></i>
                    <strong>Tambah Karyawan</strong>
                </div>
                <a href="{{ route('karyawan.index') }}" class="btn btn-outline-danger btn-sm">
                    <i class="mdi mdi-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                   id="nik" name="nik" value="{{ old('nik') }}" required>
                            @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror" 
                                   id="nama_karyawan" name="nama_karyawan" value="{{ old('nama_karyawan') }}" required>
                            @error('nama_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="noHp_karyawan" class="form-label">No HP</label>
                            <input type="text" class="form-control @error('noHp_karyawan') is-invalid @enderror" 
                                   id="noHp_karyawan" name="noHp_karyawan" value="{{ old('noHp_karyawan') }}" required>
                            @error('noHp_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gender_karyawan" class="form-label">Gender</label>
                            <select class="form-select @error('gender_karyawan') is-invalid @enderror" 
                                    id="gender_karyawan" name="gender_karyawan" required>
                                <option value="">Pilih Gender</option>
                                <option value="L" {{ old('gender_karyawan') == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P" {{ old('gender_karyawan') == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('gender_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status_karyawan" class="form-label">Status Karyawan</label>
                            <select class="form-select @error('status_karyawan') is-invalid @enderror" 
                                    id="status_karyawan" name="status_karyawan" required>
                                <option value="">Pilih Status</option>
                                <option value="kasir" {{ old('status_karyawan') == 'kasir' ? 'selected' : '' }}>
                                    Kasir
                                </option>
                                <option value="pengelola barang" {{ old('status_karyawan') == 'pengelola Barang' ? 'selected' : '' }}>
                                    Pengelola Barang
                                </option>
                            </select>
                            @error('status_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto_karyawan" class="form-label">Foto</label>
                            <input type="file" class="form-control @error('foto_karyawan') is-invalid @enderror" 
                                   id="foto_karyawan" name="foto_karyawan" accept="image/*"
                                   onchange="previewImage()">
                            @error('foto_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <img id="preview" src="#" alt="Preview" style="max-width: 100px; display: none;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="mdi mdi-eye-outline"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage() {
    const preview = document.getElementById('preview');
    const file = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
</script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const password = document.getElementById('password');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('mdi-eye-outline');
        this.querySelector('i').classList.toggle('mdi-eye-off-outline');
    });
</script>

@endsection