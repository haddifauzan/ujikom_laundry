@extends('karyawan.kasir.template.master')

@section('title', 'Transaksi Laundry - Pembayaran')

@section('content')
<div class="container-fluid">
    <!-- Progress Bar -->
    <div class="progress-wrapper mb-4">
        <div class="steps">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item completed">
                    <span class="step-number">1</span>
                    <span class="step-title">Data Konsumen</span>
                </li>
                <li class="nav-item completed">
                    <span class="step-number">2</span>
                    <span class="step-title">Proses Transaksi</span>
                </li>
                <li class="nav-item completed">
                    <span class="step-number">3</span>
                    <span class="step-title">Gunakan Voucher</span>
                </li>
                <li class="nav-item active">
                    <span class="step-number">4</span>
                    <span class="step-title">Pembayaran</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Payment Details -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Detail Pembayaran</h4>
                    
                    <!-- Order Summary -->
                    <div class="order-summary mb-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th>Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="orderDetails">
                                <!-- Filled by JavaScript -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total</strong></td>
                                    <td class="text-end"><strong id="totalAmount">Rp 0</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end">Diskon Voucher</td>
                                    <td class="text-end" id="discountAmount">- Rp 0</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total Pembayaran</strong></td>
                                    <td class="text-end"><strong id="finalAmount">Rp 0</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Form -->
                    <form id="paymentForm" action="{{ route('kasir.transaksi.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart_data" id="cartData">
                        <input type="hidden" name="total_amount" id="totalAmountInput">
                        <input type="hidden" name="id_konsumen" value="{{ $konsumen->id_konsumen }}">
                        <input type="hidden" name="id_voucher" id="voucherIdInput">
                        <input type="hidden" name="diskon" id="discountAmountInput" value="">
                        <input type="hidden" name="subtotal" id="subtotalAmountInput">

                        <div class="mb-3">
                            <label class="form-label">Pesan Konsumen</label>
                            <textarea class="form-control" name="pesan_konsumen" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Karyawan</label>
                            <textarea class="form-control" name="pesan_karyawan" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Pembayaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="bayar" id="paymentAmount" required>
                            </div>
                        </div>

                        <div id="changeAmount" class="alert alert-info" style="display: none;">
                            Kembalian: <strong>Rp <span id="changeValue">0</span></strong>
                        </div>

                        <button type="submit" class="btn btn-info" id="processPayment">
                            Proses Pembayaran <i class="mdi mdi-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Invoice -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Preview Invoice</h4>
                    <div id="invoicePreview" class="p-3 border rounded">
                        <div class="text-center mb-4">
                            <h4>LAUNDRY INVOICE</h4>
                            <p id="invoiceNumber"></p>
                        </div>

                        <div class="customer-info mb-3">
                            <strong>Konsumen:</strong>
                            <p class="mb-1">{{ $konsumen->nama_konsumen }}</p>
                            <p class="mb-1">{{ $konsumen->noHp_konsumen }}</p>
                            <p>Kode: {{ $konsumen->kode_konsumen }}</p>
                        </div>

                        <div class="order-info mb-3">
                            <strong>Detail Pesanan:</strong>
                            <div id="invoiceDetails">
                                <!-- Filled by JavaScript -->
                            </div>
                        </div>

                        <div class="important-notice mt-3 p-2 text-dark" style="background-color: #e1e1e1">
                            <strong> PENTING:</strong><br>
                            Simpan invoice ini sebagai bukti pengambilan laundry.
                            @if(!$konsumen->member)
                            Kode konsumen diperlukan untuk pengambilan.
                            @endif
                        </div>

                        <div class="staff-info mt-3">
                            <p class="mb-1">Kasir: {{ auth()->user()->karyawan->nama_karyawan }}</p>
                            <p>{{ now()->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
let cart = JSON.parse(sessionStorage.getItem('laundryCart'));
let voucherData = JSON.parse(sessionStorage.getItem('appliedVoucher'));

console.log('Cart:', cart);
console.log('Voucher Data:', voucherData);

let totalAmount = 0;

function initializePage() {
    let orderHtml = '';
    let invoiceHtml = '';
    totalAmount = 0;

    // Process laundry items
    cart.items.forEach(item => {
        const subtotal = parseFloat(item.subtotal);
        totalAmount += subtotal;
        
        orderHtml += `
            <tr>
                <td>${item.display}</td>
                <td>${item.quantity}</td>
                <td class="text-end">Rp ${number_format(subtotal)}</td>
            </tr>
        `;

        invoiceHtml += `
            <p class="mb-1">
                ${item.display} x ${item.quantity}
                <span class="float-end">Rp ${number_format(subtotal)}</span>
            </p>
        `;
    });

    // Process additional services
    cart.additionalServices.forEach(service => {
        totalAmount += parseFloat(service.harga);
        
        orderHtml += `
            <tr>
                <td>${service.nama} (Tambahan)</td>
                <td>1</td>
                <td class="text-end">Rp ${number_format(service.harga)}</td>
            </tr>
        `;

        invoiceHtml += `
            <p class="mb-1">
                ${service.nama}
                <span class="float-end">Rp ${number_format(service.harga)}</span>
            </p>
        `;
    });

    $('#orderDetails').html(orderHtml);
    $('#invoiceDetails').html(invoiceHtml);
    $('#totalAmount').text(`Rp ${number_format(totalAmount)}`);
    $('#totalAmountInput').val(totalAmount);
    $('#cartData').val(JSON.stringify(cart));
    $('#voucherIdInput').val(voucherData ? voucherData.id_voucher : '');

    // Generate invoice number preview
    const date = new Date();
    const invoiceNumber = `INV/${date.getFullYear()}${(date.getMonth()+1).toString().padStart(2, '0')}${date.getDate().toString().padStart(2, '0')}/${Math.random().toString(36).substr(2, 5).toUpperCase()}`;
    $('#invoiceNumber').text(invoiceNumber);

    // Calculate final amount if voucher exists
    if (voucherData) {
        let voucherDiscount = 0;

        // Hitung diskon berdasarkan tipe voucher
        if (voucherData.diskon_persen) {
            voucherDiscount = (totalAmount * voucherData.diskon_persen) / 100;
            // Terapkan max_diskon jika ada
            if (voucherData.max_diskon && voucherDiscount > voucherData.max_diskon) {
                voucherDiscount = voucherData.max_diskon;
            }
        } else if (voucherData.diskon_nominal) {
            voucherDiscount = voucherData.diskon_nominal;
        }

        const finalAmount = totalAmount - voucherDiscount;
        $('#discountAmount').text(`- Rp ${number_format(voucherDiscount)}`);
        $('#finalAmount').text(`Rp ${number_format(finalAmount)}`);
        totalAmount = finalAmount;
        $('#discountAmountInput').val(voucherDiscount);
        $('#subtotalAmountInput').val(finalAmount);
    } else {
        $('#discountAmount').text(`- Rp 0`);
        $('#finalAmount').text(`Rp ${number_format(totalAmount)}`);
        $('#discountAmountInput').val(0);
        $('#subtotalAmountInput').val(totalAmount);
    }
}

$('#paymentAmount').on('input', function() {
    const payment = parseFloat($(this).val()) || 0;
    const change = payment - totalAmount;
    
    if (change >= 0) {
        $('#changeAmount').show();
        $('#changeValue').text(number_format(change));
        $('#processPayment').prop('disabled', false);
    } else {
        $('#changeAmount').hide();
        $('#processPayment').prop('disabled', true);
    }
});

$('#paymentForm').on('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const btn = $('#processPayment');
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Processing...');

    // Submit form
    this.submit();
});


function number_format(number) {
    return new Intl.NumberFormat('id-ID', { style: 'decimal' }).format(number);
}

// Initialize page
initializePage();
</script>



<style>
#invoicePreview {
    font-size: 0.9rem;
    background: white;
}

.important-notice {
    border-left: 4px solid #ffc107;
    font-size: 0.85rem;
}

.completed .step-number {
    background: #28a745;
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