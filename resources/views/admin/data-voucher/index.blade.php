@extends('admin.template.master')
@section('title', 'Kelola Voucher Diskon')

@section('content')
<div class="card">
    <div class="card-body py-3 px-4 border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-ticket-percent fs-4 me-2"></i>
                <h5 class="mb-0">Data Voucher Diskon</h5>
            </div>
            <a href="{{ route('voucher.create') }}" class="btn btn-info btn-sm">
                <i class="mdi mdi-plus me-1"></i>Tambah Voucher
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
            <table class="table table-striped" id="table-voucher">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Jumlah</th>
                        <th>Diskon</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $key => $v)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($v->gambar)
                                <img src="{{ asset('uploads/voucher/'.$v->gambar) }}" 
                                     alt="Voucher {{ $v->kode_voucher }}" 
                                     style="width: 100px; height: 100px;">
                            @else
                                <img src="{{ asset('assets/img/default-voucher.png') }}" 
                                     alt="Default"
                                     style="width: 100px; height: 100px;">
                            @endif
                        </td>
                        <td>{{ $v->kode_voucher }}</td>
                        <td>{{ $v->deskripsi }}</td>
                        <td>{{ $v->jumlah_voucher }}</td>
                        <td>
                            @if($v->diskon_persen)
                                {{ $v->diskon_persen }}%
                            @else
                                Rp {{ number_format($v->diskon_nominal, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            @if($v->masa_berlaku_mulai && $v->masa_berlaku_selesai)
                                {{ $v->masa_berlaku_mulai->format('d/m/Y') }} -
                                {{ $v->masa_berlaku_selesai->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $v->status == 'Aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($v->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('voucher.edit', $v->id_voucher) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $v->id_voucher }}">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $v->id_voucher }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus voucher <strong>{{ $v->kode_voucher }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('voucher.destroy', $v->id_voucher) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-voucher', {
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
