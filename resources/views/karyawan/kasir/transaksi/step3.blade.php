@extends('karyawan.kasir.template.master')

@section('title', 'Transaksi Laundry - Voucher')

@section('content')
<div class="container-fluid">
    <!-- Progress Bar -->
    <div class="progress-wrapper mb-4">
        <div class="steps">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item completed">
                    <span class="step-number">1</span>
                    <span class="step-title text-dark">Data Konsumen</span>
                </li>
                <li class="nav-item completed">
                    <span class="step-number">2</span>
                    <span class="step-title text-dark">Proses Transaksi</span>
                </li>
                <li class="nav-item active">
                    <span class="step-number">3</span>
                    <span class="step-title text-dark">Gunakan Voucher</span>
                </li>
                <li class="nav-item disabled">
                    <span class="step-number">4</span>
                    <span class="step-title">Invoice</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Left Side - Cart Summary -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Ringkasan Transaksi</h4>
                    <div id="cartSummary">
                        <!-- Cart summary will be loaded here -->
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5>Subtotal:</h5>
                        <h5 id="subtotalAmount">Rp 0</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center my-1" id="discountRow" style="display: none;">
                        <h5 class="text-success">Diskon Voucher:</h5>
                        <h5 class="text-success" id="discountAmount">-Rp 0</h5>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4>Total:</h4>
                        <h4 id="finalTotal">Rp 0</h4>
                    </div>
                    <button class="btn btn-danger btn-sm w-100 mt-3" id="cancelVoucher" style="display: none;">Batalkan Voucher</button>
                </div>
            </div>
        </div>

        <!-- Right Side - Voucher Section -->
        <div class="col-md-8">
            @if($konsumen->member)
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Masukkan Kode Voucher</h4>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="voucherCode" 
                               placeholder="Masukkan kode voucher">
                        <button class="btn btn-info" type="button" id="checkVoucher">
                            Cek Voucher
                        </button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Voucher yang Tersedia</h4>
                    <div class="row" id="availableVouchers">
                        @foreach($vouchers as $voucher)
                        <div class="col-md-6 mb-3">
                            <div class="voucher-card h-100">
                                @if($voucher->gambar)
                                <img src="{{ asset('uploads/voucher/'.$voucher->gambar) }}" class="card-img-top">
                                @endif
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5>{{ $voucher->kode_voucher }}</h5>
                                            <p class="mb-2">{{ $voucher->deskripsi }}</p>
                                        </div>
                                    </div>
                                    <div class="voucher-details">
                                        @if($voucher->diskon_persen)
                                        <p class="discount-text">Diskon {{ $voucher->diskon_persen }}%</p>
                                        @endif
                                        @if($voucher->diskon_nominal)
                                        <p class="discount-text">Potongan Rp {{ number_format($voucher->diskon_nominal) }}</p>
                                        @endif
                                        @if($voucher->min_subtotal_transaksi)
                                        <p class="small text-muted">
                                            Min. transaksi Rp {{ number_format($voucher->min_subtotal_transaksi) }}
                                        </p>
                                        @endif
                                        @if($voucher->max_diskon)
                                        <p class="small text-muted">
                                            Maks. diskon Rp {{ number_format($voucher->max_diskon) }}
                                        </p>
                                        @endif
                                        <p class="small text-muted">
                                            Berlaku sampai: {{ $voucher->masa_berlaku_selesai->format('d M Y') }}
                                        </p>
                                    </div>
                                    <button class="btn btn-outline-info w-100 mt-2" 
                                            onclick="applyVoucher('{{ $voucher->kode_voucher }}')">
                                        Gunakan Voucher
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body text-center">
                    <h4>Konsumen Non-Member</h4>
                    <p>Maaf, voucher hanya tersedia untuk member.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('transaksi.step2', ['id_konsumen' => $konsumen->id_konsumen]) }}" 
           class="btn btn-secondary">Kembali</a>
        <button class="btn btn-info" onclick="proceedToInvoice()">Lanjut ke Invoice</button>
    </div>
</div>

<script>
let cart = {};
let appliedVoucher = null;
let subtotal = 0;

$(document).ready(function() {
    // Load cart data from session storage
    const cartData = sessionStorage.getItem('laundryCart');
    if (cartData) {
        cart = JSON.parse(cartData);
        updateCartSummary();
    }
});

function updateCartSummary() {
    let html = '';
    subtotal = 0;

    // Display laundry items
    cart.items.forEach(item => {
        const itemSubtotal = parseFloat(item.subtotal) || 0; // Pastikan angka valid
        html += `
            <div class="mb-2">
                <div class="d-flex justify-content-between">
                    <span>${item.display}</span>
                    <span>Rp ${number_format(itemSubtotal)}</span>
                </div>
                <small class="text-muted">Jumlah: ${item.quantity}</small>
            </div>
        `;
        subtotal += itemSubtotal;
    });

    // Display additional services
    cart.additionalServices.forEach(service => {
        const servicePrice = parseFloat(service.harga) || 0; // Pastikan angka valid
        html += `
            <div class="mb-2">
                <div class="d-flex justify-content-between">
                    <span>${service.nama}</span>
                    <span>Rp ${number_format(servicePrice)}</span>
                </div>
                <small class="text-muted">Layanan Tambahan</small>
            </div>
        `;
        subtotal += servicePrice;
    });

    // Log untuk debugging
    console.log('Subtotal calculated:', subtotal);

    $('#cartSummary').html(html);
    $('#subtotalAmount').text(`Rp ${number_format(subtotal)}`);
    updateFinalTotal();
}

function applyVoucher(code) {
    $.post('{{ route("kasir.check-voucher") }}', {
        _token: '{{ csrf_token() }}',
        code: code,
        subtotal: subtotal
    }, function(response) {
        if (response.valid) {
            appliedVoucher = response.voucher;
            showVoucherSuccess(response.voucher);
            updateFinalTotal();
        } else {
            showVoucherError(response.message);
        }
    });
}

$('#checkVoucher').click(function() {
    const code = $('#voucherCode').val();
    if (code) {
        applyVoucher(code);
    }
});

function showVoucherSuccess(voucher) {
    Swal.fire({
        icon: 'success',
        title: 'Voucher Berhasil Digunakan',
        text: `Anda mendapatkan potongan ${voucher.diskon_persen ? voucher.diskon_persen + '%' : 
              'Rp ' + number_format(voucher.diskon_nominal)}`,
    });
    $('#discountRow').show();
    $('#cancelVoucher').show(); // Tampilkan tombol batalkan voucher
}

function showVoucherError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Voucher Tidak Valid',
        text: message
    });
}

function calculateDiscount() 
{
    if (!appliedVoucher) return 0;

    let discount = 0;
    if (appliedVoucher.diskon_persen) {
        discount = (subtotal * appliedVoucher.diskon_persen) / 100;
    } else if (appliedVoucher.diskon_nominal) {
        discount = appliedVoucher.diskon_nominal;
    }

    // Apply max discount if set
    if (appliedVoucher.max_diskon && discount > appliedVoucher.max_diskon) {
        discount = appliedVoucher.max_diskon;
    }

    return parseFloat(discount) || 0; // Pastikan return numeric value
}

function updateFinalTotal() 
{
    const discount = calculateDiscount();
    const total = Math.max(0, subtotal - discount); // Pastikan total tidak negatif

    if (discount > 0) {
        $('#discountRow').show();
        $('#discountAmount').text(`-Rp ${number_format(discount)}`);
    } else {
        $('#discountRow').hide();
    }

    $('#finalTotal').text(`Rp ${number_format(total)}`);
}

function proceedToInvoice() {
    // Store voucher data if applied
    if (appliedVoucher) {
        const voucherData = {
            ...appliedVoucher,
            calculated_discount: calculateDiscount(),
            subtotal: subtotal
        };
        sessionStorage.setItem('appliedVoucher', JSON.stringify(voucherData));
        console.log("Voucher applied and saved to sessionStorage", voucherData);  // Tambahkan log
    } else {
        sessionStorage.removeItem('appliedVoucher');
    }

    window.location.href = "{{ route('transaksi.step4', ['id_konsumen' => $konsumen->id_konsumen]) }}";
}

function number_format(number) {
    return new Intl.NumberFormat('id-ID', { style: 'decimal' }).format(number);
}

$('#cancelVoucher').click(function() {
    appliedVoucher = null; 
    sessionStorage.removeItem('appliedVoucher'); // Hapus dari session storage
    $('#discountRow').hide(); 
    $('#cancelVoucher').hide(); 
    $('#discountAmount').text('-Rp 0'); 
    updateFinalTotal(); 
    Swal.fire({
        icon: 'success',
        title: 'Voucher Dibatalkan',
        text: 'Voucher telah berhasil dibatalkan.'
    });
});
</script>


<style>
.voucher-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.voucher-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.discount-text {
    color: #28a745;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.voucher-details {
    margin-top: 1rem;
}

.steps .nav-pills {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}

.step-number {
    width: 30px;
    height: 30px;
    background: #6c757d;
    color: white;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}

.nav-item.active .step-number {
    background: #007bff;
}

.nav-item.completed .step-number {
    background: #28a745;
}

.step-title {
    font-weight: 500;
}

.nav-item.disabled {
    opacity: 0.6;
}
</style>
@endsection