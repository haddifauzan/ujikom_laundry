@extends('landing.layout.master')

@section('title', 'Transactions - WashUP Laundry')

@section('content')
<!-- Hero Section -->
<div class="bg-secondary-subtle py-5">
    <div class="container py-5">
        <div class="row min-vh-25 align-items-center">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success mb-3">My Transactions</h1>
                <p class="lead mb-0">View your ongoing and completed transactions</p>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Section -->
<div class="py-5">
    <div class="container">
        <div class="row">
            <!-- Ongoing Transactions -->
            <div class="col-12 col-lg-6 mb-4">
                <h2 class="h3 mb-4">Ongoing Transactions</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaction Number</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ongoingTransactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaction->no_transaksi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->waktu_transaksi)->format('d M Y H:i') }}</td>
                                    <td>
                                        @switch($transaction->statusPesanan->last()->status)
                                            @case('pending')
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                </span>
                                                @break
                                            @case('diproses')
                                                <span class="badge bg-warning">
                                                    {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                </span>
                                                @break
                                            @case('selesai')
                                                <span class="badge bg-success">
                                                    {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                </span>
                                                @break
                                            @case('gagal')
                                                <span class="badge bg-danger">
                                                    {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-warning btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#ongoingModal{{ $transaction->id_transaksi }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal for Ongoing Transaction Details -->
                                <div class="modal fade" id="ongoingModal{{ $transaction->id_transaksi }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ongoing Transaction Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-center">Order Information</h6>
                                                        <p><strong>Order Number:</strong> {{ $transaction->no_transaksi }}</p>
                                                        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($transaction->waktu_transaksi)->format('d M Y H:i') }}</p>
                                                        <p><strong>Status:</strong> 
                                                            @switch($transaction->statusPesanan->last()->status)
                                                                @case('pending')
                                                                    <span class="badge bg-secondary">
                                                                        {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                                    </span>
                                                                    @break
                                                                @case('diproses')
                                                                    <span class="badge bg-warning">
                                                                        {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                                    </span>
                                                                    @break
                                                                @case('selesai')
                                                                    <span class="badge bg-success">
                                                                        {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                                    </span>
                                                                    @break
                                                                @case('gagal')
                                                                    <span class="badge bg-danger">
                                                                        {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                                                    </span>
                                                                    @break
                                                            @endswitch
                                                        </p>
                                                        <p><strong>Description:</strong> {{ $transaction->statusPesanan->last()->keterangan }}</p>
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <h6 class="fw-bold">Transaction QR Code</h6>
                                                        <div class="qr-code-container">
                                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data={{ urlencode($transaction->no_transaksi) }}" alt="QR Code" width="80" height="80">
                                                        </div>
                                                        <p class="mt-2"><small class="text-muted">Show this QR code when picking up your laundry</small></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-center">Order Summary</h6>
                                                        <p><strong>Subtotal:</strong> Rp {{ number_format($transaction->subtotal + $transaction->diskon, 0, ',', '.') }}</p>
                                                        @if($transaction->diskon)
                                                            <p><strong>Discount:</strong> Rp {{ number_format($transaction->diskon, 0, ',', '.') }}</p>
                                                        @endif
                                                        <p><strong>Total:</strong> Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h6 class="fw-bold">Order Items</h6>
                                                <div class="row">
                                                    @foreach($transaction->rincianTransaksi as $index => $item)
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Item {{ $index + 1 }}</h5>
                                                                    <ul class="list-unstyled">
                                                                        <li><strong>Service:</strong> {{ $item->tarifLaundry->jenisLaundry->nama_jenis ?? '-' }}</li>
                                                                        <li><strong>Additional Service:</strong> {{ $item->layananTambahan->nama_layanan ?? '-' }}</li>
                                                                        <li><strong>Quantity:</strong> {{ $item->jumlah }}</li>
                                                                        <li><strong>Price:</strong> Rp {{ number_format($item->tarifLaundry->tarif ?? $item->layananTambahan->harga, 0, ',', '.') }}</li>
                                                                        <li><strong>Subtotal:</strong> Rp {{ number_format($item->subtotal, 0, ',', '.') }}</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No ongoing transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Completed Transactions -->
            <div class="col-12 col-lg-6">
                <h2 class="h3 mb-4">Completed Transactions</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaction Number</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completedTransactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $transaction->no_transaksi }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->waktu_transaksi)->format('d M Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($transaction->status_transaksi) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-success btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#completedModal{{ $transaction->id_transaksi }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal for Completed Transaction Details -->
                                <div class="modal fade" id="completedModal{{ $transaction->id_transaksi }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Completed Transaction Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold">Order Information</h6>
                                                        <p><strong>Order Number:</strong> {{ $transaction->no_transaksi }}</p>
                                                        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($transaction->waktu_transaksi)->format('d M Y H:i') }}</p>
                                                        <p><strong>Status:</strong> 
                                                            <span class="badge bg-success">
                                                                {{ ucfirst($transaction->status_transaksi) }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold">Order Summary</h6>
                                                        <p><strong>Subtotal:</strong> Rp {{ number_format($transaction->subtotal + $transaction->diskon, 0, ',', '.') }}</p>
                                                        @if($transaction->diskon)
                                                            <p><strong>Discount:</strong> Rp {{ number_format($transaction->diskon, 0, ',', '.') }}</p>
                                                        @endif
                                                        <p><strong>Total:</strong> Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h6 class="fw-bold">Order Items</h6>
                                                <div class="row">
                                                    @foreach($transaction->rincianTransaksi as $index => $item)
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Item {{ $index + 1 }}</h5>
                                                                    <ul class="list-unstyled">
                                                                        <li><strong>Service:</strong> {{ $item->tarifLaundry->jenisLaundry->nama_jenis ?? '-' }}</li>
                                                                        <li><strong>Additional Service:</strong> {{ $item->layananTambahan->nama_layanan ?? '-' }}</li>
                                                                        <li><strong>Quantity:</strong> {{ $item->jumlah }}</li>
                                                                        <li><strong>Price:</strong> Rp {{ number_format($item->tarifLaundry->tarif ?? $item->layananTambahan->harga, 0, ',', '.') }}</li>
                                                                        <li><strong>Subtotal:</strong> Rp {{ number_format($item->subtotal, 0, ',', '.') }}</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No completed transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection