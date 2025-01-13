@extends('landing.layout.master')

@section('title', 'Order Tracking - WashUP Laundry')

@section('content')
<!-- Hero Section -->
<div class="bg-secondary-subtle py-5">
    <div class="container py-5">
        <div class="row min-vh-25 align-items-center">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success mb-3">Track Your Order</h1>
                <p class="lead mb-0">Enter your order number to check the status</p>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Form Section -->
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('member.order.tracking') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" 
                                       name="order_number" 
                                       class="form-control form-control-lg" 
                                       placeholder="Enter your transaction number"
                                       value="{{ request('order_number') }}">
                                <button type="submit" class="btn btn-success btn-lg text-white">
                                    <i class="bi bi-search"></i> Track
                                </button>
                            </div>
                        </form>

                        @if($message)
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ $message }}
                            </div>
                        @endif

                        @if($order)
                            <!-- Order Details -->
                            <div class="card bg-light border-0 mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 text-dark">
                                            <h5 class="fw-bold mb-3">Order Information</h5>
                                            <p class="mb-1"><strong>Order Number:</strong> {{ $order->no_transaksi }}</p>
                                            <p class="mb-1"><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->waktu_transaksi)->format('d M Y H:i') }}</p>
                                            <p class="mb-1"><strong>Customer:</strong> {{ $order->konsumen->nama_konsumen }}</p>
                                            <p class="mb-0"><strong>Status:</strong> 
                                                <span class="badge bg-{{ $order->status_transaksi == 'selesai' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($order->status_transaksi) }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6 text-dark">
                                            <h5 class="fw-bold mb-3">Order Summary</h5>
                                            <p class="mb-1"><strong>Subtotal:</strong> Rp {{ number_format($order->subtotal + $order->diskon, 0, ',', '.') }}</p>
                                            @if($order->diskon)
                                                <p class="mb-1"><strong>Discount:</strong> Rp {{ number_format($order->diskon, 0, ',', '.') }}</p>
                                            @endif
                                            <p class="mb-0"><strong>Total:</strong> Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Timeline -->
                            <div class="position-relative">
                                <div class="timeline-track position-absolute" style="top: 0; bottom: 0; left: 20px; width: 2px; background-color: #dee2e6;"></div>
                                @foreach($order->statusPesanan as $status)
                                    <div class="timeline-item d-flex mb-4">
                                        <div class="timeline-icon rounded-circle bg-{{ $status->status == 'selesai' ? 'success' : ($status->status == 'gagal' ? 'danger' : 'warning') }} text-white d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; z-index: 1;">
                                            <i class="bi bi-{{ 
                                                $status->status == 'pending' ? 'clock' : 
                                                ($status->status == 'diproses' ? 'gear' : 
                                                ($status->status == 'selesai' ? 'check-lg' : 'x-lg')) }}"></i>
                                        </div>
                                        <div class="timeline-content ms-3">
                                            <h6 class="mb-1 fw-bold">{{ ucfirst($status->status) }}</h6>
                                            <p class="text-muted mb-1">{{ $status->keterangan }}</p>
                                            <small class="text-muted">
                                                <i class="bi bi-clock-history me-1"></i>
                                                {{ \Carbon\Carbon::parse($status->waktu_perubahan)->format('d M Y H:i') }}
                                            </small>                                            
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Items -->
                            <h5 class="fw-bold mb-3">Order Items</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Service</th>
                                            <th>Additional Service</th>
                                            <th>Quantity</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->rincianTransaksi as $index => $rincian)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if($rincian->tarifLaundry && $rincian->tarifLaundry->jenisLaundry)
                                                        {{ $rincian->tarifLaundry->jenisLaundry->nama_jenis }} - 
                                                        {{ $rincian->tarifLaundry->satuan ?? $rincian->tarifLaundry->nama_pakaian }} -
                                                        {{ $rincian->tarifLaundry->jenisLaundry->waktu_estimasi }} Hari
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                
                                                <td>{{ $rincian->layananTambahan->nama_layanan ?? '-' }}</td>
                                                <td>{{ $rincian->jumlah }}</td>
                                                <td>
                                                    Rp {{ number_format($rincian->layananTambahan->harga ?? $rincian->tarifLaundry->tarif, 0, ',', '.') }}
                                                </td>
                                                <td>Rp {{ number_format($rincian->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>                                    
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-icon {
    min-width: 40px;
    box-shadow: 0 0 0 4px #fff;
}

.timeline-track {
    z-index: 0;
}
</style>
@endsection