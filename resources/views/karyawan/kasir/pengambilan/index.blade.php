@extends('karyawan.kasir.template.master')
@section('title', 'Kelola Pengambilan')

@section('content')
<div class="container-fluid px-4">
    <div class="card">
        <div class="card-body px-3 py-2 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="mdi mdi-clipboard-text me-1"></i>
                    Data Pengambilan Laundry
                </div>
                <button type="button" class="btn btn-secondary float-right" onclick="startScanner()" data-bs-toggle="modal" data-bs-target="#scanQRModal">
                    <i class="mdi mdi-qrcode-scan"></i> Scan QR Code Selesai Pesanan
                </button>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-pengambilan">
                    <thead>
                        <tr>
                            <th>No Transaksi</th>
                            <th>Waktu Transaksi</th>
                            <th>Konsumen</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Status Pesanan</th>
                            <th>Status Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->no_transaksi }}</td>
                            <td>{{ $transaksi->waktu_transaksi }}</td>
                            <td>{{ $transaksi->konsumen->nama_konsumen }}</td>
                            <td>{{ $transaksi->karyawan->nama_karyawan}}</td>
                            <td>Rp {{ number_format($transaksi->subtotal - $transaksi->diskon, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-success">
                                    {{ strtoupper($transaksi->statusPesanan->last()->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $transaksi->status_transaksi == 'selesai' ? 'badge-success' : 'badge-warning' }}">
                                    {{ strtoupper($transaksi->status_transaksi) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-info complete-transaction" 
                                        data-id="{{ $transaksi->id_transaksi }}"
                                        {{ $transaksi->status_transaksi == 'selesai' ? 'disabled' : '' }}>
                                    <i class="mdi mdi-check"></i> Selesaikan
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

<!-- Modal Scan QR -->
<div class="modal fade" id="scanQRModal" tabindex="-1" aria-labelledby="scanQRModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scanQRModalLabel">Scan QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="stopScanner()"></button>
            </div>
            <div class="modal-body">
                <div id="reader" class="mx-auto" style="width: 500px;"></div>
                <div id="result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="stopScanner()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/html5-qrcode"></script>

<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-pengambilan', {
            paging: true,
            info: true,
            ordering: true
        });
    });
</script>

<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        if (html5QrcodeScanner === null) {
            html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                showTorchButtonIfSupported: true
            });

            html5QrcodeScanner.render(onScanSuccess, onScanError);
        }
    }

    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
            html5QrcodeScanner = null;
        }
    }

    function onScanSuccess(decodedText) {
        // Stop scanning after successful scan
        stopScanner();
        
        $.ajax({
            url: "{{ route('pengambilan.verify-qr') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                no_transaksi: decodedText
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Transaksi berhasil diselesaikan',
                        icon: 'success'
                    }).then(() => {
                        $('#scanQRModal').modal('hide');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error'
                    }).then(() => {
                        // Restart scanner after error
                        startScanner();
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan jaringan atau server.',
                    icon: 'error'
                }).then(() => {
                    // Restart scanner after error
                    startScanner();
                });
            }
        });
    }

    function onScanError(error) {
        // Handle scan error if needed
        console.warn(`QR Code scan error: ${error}`);
    }

    // Handle modal events
    $('#scanQRModal').on('hidden.bs.modal', function () {
        stopScanner();
    });

    // Handle manual completion
    $('.complete-transaction').click(function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menyelesaikan transaksi ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('pengambilan.complete') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_transaksi: id
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', 'Transaksi berhasil diselesaikan', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan jaringan atau server.', 'error');
                    }
                });
            }
        });
    });
</script>
@endsection