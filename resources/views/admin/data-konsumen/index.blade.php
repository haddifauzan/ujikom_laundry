@extends('admin.template.master')
@section('title', 'Kelola Data Konsumen')

@section('content')
<div class="container-fluid px-4">
    <!-- Statistik Data Konsumen -->
    <div class="row">
        <div class="col-md-4">
            <div class="card border-secondary text-secondary mb-4">
                <div class="card-body px-3">
                    <h5>Total Konsumen</h5>
                    <h3>{{ $countKonsumen }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success text-success mb-4">
                <div class="card-body px-3">
                    <h5>Member</h5>
                    <h3>{{ $countMember }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info text-info mb-4">
                <div class="card-body px-3">
                    <h5>Non-Member</h5>
                    <h3>{{ $countNonMember }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Data Konsumen -->
    <div class="card mb-4">
        <div class="card-body py-3 px-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-account-group fs-4 me-2"></i>
                    <h5 class="mb-0">Data Konsumen</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
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

            <div class="table-responsive">
                <table class="table table-striped" id="table-konsumen">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($konsumen as $key => $k)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $k->kode_konsumen }}</td>
                            <td>{{ $k->nama_konsumen }}</td>
                            <td>{{ $k->alamat_konsumen ?? "-" }}</td>
                            <td>{{ $k->noHp_konsumen }}</td>
                            <td>
                                <span class="badge bg-{{ $k->member ? 'success' : 'secondary' }}">
                                    {{ $k->member ? 'Member' : 'Non-Member' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="deleteKonsumen({{ $k->id_konsumen }})">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $k->id_konsumen }}" 
                                      action="{{ route('konsumen.destroy', $k->id_konsumen) }}" 
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
function deleteKonsumen(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data konsumen akan dihapus permanen!",
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

// Datatable initialization
$(document).ready(function() {
    new DataTable('#table-konsumen', {
        paging: true,
        info: true,
        ordering: true
    });
});

// Auto close alert after 3 seconds
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);
</script>
@endsection