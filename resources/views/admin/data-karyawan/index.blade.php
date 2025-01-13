@extends('admin.template.master')
@section('title', 'Kelola Data Karyawan')

@section('content')
<div class="container-fluid px-4">
    <!-- Statistik Data Karyawan -->
    <div class="row">
        <div class="col-md-2">
            <div class="card border-secondary text-secondary mb-4">
                <div class="card-body px-3">
                    <h5>Total</h5>
                    <h3>{{ $countKaryawan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-info text-info mb-4">
                <div class="card-body px-3">
                    <h5>Laki-Laki</h5>
                    <h3>{{ $countLakiLaki }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-primary text-primary mb-4">
                <div class="card-body px-3">
                    <h5>Perempuan</h5>
                    <h3>{{ $countPerempuan }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-success text-success mb-4">
                <div class="card-body px-3">
                    <h5>Kasir</h5>
                    <h3>{{ $countKasir }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-warning text-warning mb-4">
                <div class="card-body px-3">
                    <h5>Pengelola Barang</h5>
                    <h3>{{ $countPengelola }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-dark text-dark mb-4">
                <div class="card-body px-3">
                    <h5>Karyawan Aktif</h5>
                    <h3>{{ $countKaryawanAktif }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Data Karyawan -->
    <div class="card mb-4">
        <div class="card-body py-3 px-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-account-group fs-4 me-2"></i>
                    <h5 class="mb-0">Data Karyawan</h5>
                </div>
                <a href="{{ route('karyawan.create') }}" class="btn btn-info btn-sm">
                    <i class="mdi mdi-plus me-1"></i>Tambah Karyawan
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped" id="table-karyawan">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Kode</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawan as $key => $k)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($k->foto_karyawan)
                                    <img src="{{ asset('uploads/karyawan/'.$k->foto_karyawan) }}" 
                                         alt="Foto {{ $k->nama_karyawan }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 70px;">
                                @else
                                    <img src="{{ asset('assets/img/default-user.png') }}" 
                                         alt="Default" 
                                         class="img-thumbnail" 
                                         style="max-width: 70px;">
                                @endif
                            </td>
                            <td>{{ $k->kode_karyawan }}</td>
                            <td>{{ $k->nik }}</td>
                            <td>{{ $k->nama_karyawan }}</td>
                            <td>{{ $k->noHp_karyawan }}</td>
                            <td>{{ $k->gender_karyawan == 'P' ? 'Perempuan' : 'Laki-laki' }}</td>
                            <td>
                                <span class="badge bg-{{ $k->status_karyawan == 'kasir' ? 'primary' : 'success' }}">
                                    {{ ucfirst($k->status_karyawan) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('karyawan.edit', $k->id_karyawan) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="deleteKaryawan({{ $k->id_karyawan }})">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $k->id_karyawan }}" 
                                      action="{{ route('karyawan.destroy', $k->id_karyawan) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deleteKaryawan(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data karyawan akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-karyawan', {
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
