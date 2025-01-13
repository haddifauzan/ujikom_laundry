@extends('karyawan.kasir.template.master')
@section('title', 'Kelola Pesanan')

@section('content')
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body py-3 px-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="mdi mdi-clipboard-text me-1"></i>
                    Data Pesanan Laundry
                </div>
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
                <table class="table table-striped" id="table-pesanan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Transaksi</th>
                            <th>Waktu</th>
                            <th>Konsumen</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->no_transaksi }}</td>
                            <td>{{ $p->waktu_transaksi }}</td>
                            <td>{{ $p->konsumen->nama_konsumen}}</td>
                            <td>Rp {{ number_format($p->subtotal, 0, ',', '.') }}</td>
                            <td>
                                @if($p->statusPesanan->count() > 0)
                                    <span class="badge {{ 
                                        $p->statusPesanan->last()->status === 'pending' ? 'bg-secondary' : 
                                        ($p->statusPesanan->last()->status === 'diproses' ? 'bg-warning' : 
                                        ($p->statusPesanan->last()->status === 'selesai' ? 'bg-success' : 'bg-danger')) 
                                    }}">
                                        {{ ucfirst($p->statusPesanan->last()->status) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Belum ada status</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pesanan.show', $p->id_transaksi) }}" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-pesanan', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>
@endsection