@extends('karyawan.kasir.template.master')

@section('title', 'Transaksi Laundry - Pilih Layanan')

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
                <li class="nav-item active">
                    <span class="step-number">2</span>
                    <span class="step-title text-dark">Proses Transaksi</span>
                </li>
                <li class="nav-item disabled">
                    <span class="step-number">3</span>
                    <span class="step-title">Gunakan Voucher</span>
                </li>
                <li class="nav-item disabled">
                    <span class="step-number">4</span>
                    <span class="step-title">Invoice</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Left Side - Service Selection -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Pilih Jenis Layanan</h4>
                    <div class="mb-3 position-relative">
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                            <input type="text" id="searchLaundry" class="form-control" placeholder="Cari Jenis Layanan Laundry...">
                        </div>
                    </div>
                    <div class="row" id="laundryServices">
                        @foreach($jenisLaundry as $jenis)
                        <div class="col-md-6 mb-4">
                            <div class="service-card">
                                <img src="{{ asset('storage/jenis-laundry/'.$jenis->gambar) }}" class="service-image">
                                <div class="service-details">
                                    <h5>{{ $jenis->nama_jenis }}</h5>
                                    <p>{{ $jenis->deskripsi }}</p>
                                    <p><i class="mdi mdi-clock"></i> Estimasi: {{ $jenis->waktu_estimasi }} hari</p>
                                    <button class="btn btn-info" onclick="showTarifModal({{ $jenis->id_jenis }})">
                                        Pilih Layanan
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <h4 class="card-title mt-4">Layanan Tambahan</h4>
                    <div class="mb-3 position-relative">
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                            <input type="text" id="searchAdditionalService" class="form-control" placeholder="Cari Layanan Tambahan...">
                        </div>
                    </div>
                    <div class="row" id="additionalServices">
                        @foreach($layananTambahan as $layanan)
                        <div class="col-md-4 mb-3">
                            <div class="card additional-service-card border">
                                <div class="card-body">
                                    <h5>{{ $layanan->nama_layanan }}</h5>
                                    <p>{{ $layanan->deskripsi }}</p>
                                    <p class="price">Rp {{ number_format($layanan->harga) }}/{{ $layanan->satuan }}</p>
                                    <button class="btn btn-outline-info btn-sm" 
                                            onclick="addAdditionalService({{ $layanan->id_layanan }})">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Cart -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Keranjang</h4>
                    <div id="cartItems">
                        <!-- Cart items will be displayed here -->
                    </div>
                    <div class="cart-summary mt-3">
                        <h5>Total: <span id="cartTotal">Rp 0</span></h5>
                    </div>
                    <button id="btnNext" class="btn btn-info w-100 mt-3" disabled>
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tarif Modal -->
<div class="modal fade" id="tarifModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Tarif Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="tarifOptions">
                    <!-- Tarif options will be loaded here -->
                </div>
                <div class="mt-3">
                    <label class="form-label">Jumlah/Berat</label>
                    <input type="number" class="form-control" id="itemQuantity" min="1" step="0.1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-info" onclick="addToCart()">Tambah ke Keranjang</button>
            </div>
        </div>
    </div>
</div>

<script>
let cart = {
    items: [],
    additionalServices: []
};

function showTarifModal(jenisId) {
    $.get(`/get-tarif/${jenisId}`, function(data) {
        let html = '<div class="list-group">';
        data.forEach(tarif => {
            // Menggabungkan jenis_laundry dengan tampilan lainnya
            const display = tarif.jenis_tarif === 'satuan' 
                ? `${tarif.jenis_laundry.nama_jenis} (${tarif.satuan}) - Rp ${tarif.tarif}`
                : `${tarif.jenis_laundry.nama_jenis} (${tarif.nama_pakaian}) - Rp ${tarif.tarif}`;
            
            html += `
                <a href="#" class="list-group-item list-group-item-action"
                   onclick="selectTarif(${tarif.id_tarif}, '${display}', ${tarif.tarif})">
                    ${display}
                </a>
            `;
        });
        html += '</div>';
        $('#tarifOptions').html(html);
        $('#tarifModal').modal('show');
    });
}


let selectedTarif = null;

function selectTarif(tarifId, display, harga) {
    selectedTarif = { id: tarifId, display, harga };
    $('.list-group-item').removeClass('active');
    $(event.target).addClass('active');
}

function addToCart() {
    if (!selectedTarif || !$('#itemQuantity').val()) {
        alert('Pilih tarif dan masukkan jumlah');
        return;
    }

    const quantity = parseFloat($('#itemQuantity').val());
    const subtotal = quantity * selectedTarif.harga;

    cart.items.push({
        tarifId: selectedTarif.id,
        display: selectedTarif.display,
        quantity,
        subtotal
    });

    updateCartDisplay();
    $('#tarifModal').modal('hide');
    selectedTarif = null;
    $('#itemQuantity').val('');
}

function addAdditionalService(layananId) {
    $.get(`/get-layanan/${layananId}`, function(layanan) {
        cart.additionalServices.push({
            layananId: layanan.id_layanan,
            nama: layanan.nama_layanan,
            harga: layanan.harga
        });
        updateCartDisplay();
    });
}

function updateCartDisplay() {
    let html = '';
    let total = 0;

    cart.items.forEach((item, index) => {
        html += `
            <div class="cart-item">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>${item.display}</h6>
                        <small>Jumlah: ${item.quantity}</small>
                    </div>
                    <div class="text-end">
                        <div>Rp ${number_format(item.subtotal)}</div>
                        <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        total += parseFloat(item.subtotal);
    });

    cart.additionalServices.forEach((service, index) => {
        html += `
            <div class="cart-item">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6>${service.nama}</h6>
                        <small>Layanan Tambahan</small>
                    </div>
                    <div class="text-end">
                        <div>Rp ${number_format(service.harga)}</div>
                        <button class="btn btn-sm btn-danger" onclick="removeService(${index})">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        total += parseFloat(service.harga);
    });

    console.log('Total sebelum format:', total); // Debugging
    $('#cartItems').html(html);
    $('#cartTotal').text(`Rp ${number_format(total)}`);
    $('#btnNext').prop('disabled', total === 0);
}

function removeItem(index) {
    cart.items.splice(index, 1);
    updateCartDisplay();
}

function removeService(index) {
    cart.additionalServices.splice(index, 1);
    updateCartDisplay();
}

function number_format(number) {
    return new Intl.NumberFormat('id-ID', { style: 'decimal' }).format(number);
}

$('#btnNext').click(function() {
    // Store cart data in session storage for next step
    sessionStorage.setItem('laundryCart', JSON.stringify(cart));
    window.location.href = "{{ route('transaksi.step3', ['id_konsumen' => $konsumen->id_konsumen]) }}";
});
</script>

<script>
    // Fungsi untuk Memfilter Jenis Laundry
    document.getElementById('searchLaundry').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const services = document.querySelectorAll('#laundryServices .col-md-6');
    
        services.forEach(service => {
            const serviceName = service.querySelector('.service-details h5').textContent.toLowerCase();
            service.style.display = serviceName.includes(searchValue) ? '' : 'none';
        });
    });
    
    // Fungsi untuk Memfilter Layanan Tambahan
    document.getElementById('searchAdditionalService').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const additionalServices = document.querySelectorAll('#additionalServices .col-md-4');
    
        additionalServices.forEach(service => {
            const serviceName = service.querySelector('.card-body h5').textContent.toLowerCase();
            service.style.display = serviceName.includes(searchValue) ? '' : 'none';
        });
    });
</script>

<style>
.service-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.service-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.service-details {
    padding: 15px;
}

.cart-item {
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}

.completed .step-number {
    background: #28a745;
}

.additional-service-card {
    height: 100%;
}

.price {
    font-weight: bold;
    color: #007bff;
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