@extends('karyawan.kasir.template.master')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body py-3 px-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="mdi mdi-history me-1"></i>
                    Laporan Riwayat Transaksi
                </div>
                <div>
                    <button onclick="printReport()" class="btn btn-outline-danger">
                        <i class="mdi mdi-printer"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('riwayat.print') }}" method="GET" id="printForm">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="startDate" class="form-control" value="{{ request('startDate') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="endDate" class="form-control" value="{{ request('endDate') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Status Pesanan</label>
                                <select name="statusPesanan" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="selesai" {{ request('statusPesanan') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="gagal" {{ request('statusPesanan') == 'gagal' ? 'selected' : '' }}>Gagal</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Minimum Total</label>
                                <input type="number" name="minTotal" class="form-control" value="{{ request('minTotal') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{route('riwayat.index')}}" class="btn btn-secondary"><i class="mdi mdi-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-striped" id="table-riwayat">
                    <thead>
                        <tr>
                            <th>No Transaksi</th>
                            <th>Waktu Transaksi</th>
                            <th>Konsumen</th>
                            <th>Status</th>
                            <th>Subtotal</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->no_transaksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('d/m/Y H:i') }}</td>
                            <td>{{ $transaksi->konsumen->nama_konsumen }}</td>
                            <td>
                                <span class="badge bg-success">{{ strtoupper($transaksi->statusPesanan->last()->status) }}</span>
                            </td>
                            <td>Rp {{ number_format($transaksi->subtotal + $transaksi->diskon, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" id="view-detail" data-id="{{ $transaksi->id_transaksi }}">
                                    <i class="mdi mdi-eye"></i> Detail
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

<!-- Modal Detail Transaksi -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">Loading...</div>
            </div>
        </div>
    </div>
</div>


<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-riwayat', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>

<script>
    function printReport() {
        window.open("{{ route('riwayat.print') }}?" + new URLSearchParams(new FormData(document.getElementById('printForm'))).toString(), '_blank');
    }
</script>
<script>
    $(document).ready(function () {
        // Handle View Detail
        $(document).on('click', '#view-detail', function () {
            const id = $(this).data('id');
            const url = `{{ url('riwayat/detail') }}/${id}`;

            // Clear existing content and show loading
            $('#detailContent').html('<p>Loading...</p>');

            // Fetch data using AJAX
            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    // Inject the response into the modal body
                    $('#detailContent').html(response);
                    // Show the modal
                    $('#detailModal').modal('show');
                },
                error: function () {
                    $('#detailContent').html('<p class="text-danger">Failed to load details. Please try again later.</p>');
                }
            });
        });
    });
</script>
@endsection