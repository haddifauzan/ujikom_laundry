@extends('karyawan.kasir.template.master')

@section('title', 'Transaksi Laundry - Data Konsumen')

@section('content')
<div class="container-fluid">
    <!-- Progress Bar -->
    <div class="progress-wrapper mb-4">
        <div class="steps">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item active">
                    <span class="step-number">1</span>
                    <span class="step-title text-dark">Data Konsumen</span>
                </li>
                <li class="nav-item disabled">
                    <span class="step-number">2</span>
                    <span class="step-title">Proses Transaksi</span>
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

    <!-- Main Content -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Konsumen</h4>
            
            <!-- Member Check Section -->
            <div class="mb-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="customerType" id="existingMember" value="member">
                    <label class="form-check-label" for="existingMember">Member</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="customerType" id="newCustomer" value="new">
                    <label class="form-check-label" for="newCustomer">Konsumen Baru</label>
                </div>
            </div>

            <!-- Existing Member Search Form -->
            <div id="memberSearchForm" class="mb-4" style="display: none;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="memberSearch" placeholder="Cari member berdasarkan nama/kode...">
                            <button class="btn btn-info" type="button" id="searchMember">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                        </div>
                    </div>
                </div>
                <div id="memberSearchResult" class="mt-3"></div>
            </div>

            <!-- New Customer Form -->
            <form id="newCustomerForm" style="display: none;" action="{{ route('konsumen.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Konsumen</label>
                            <input type="text" class="form-control" name="nama_konsumen" required>
                        </div>
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" class="form-control" name="noHp_konsumen" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="wantMember" name="want_member">
                            <label class="form-check-label" for="wantMember">
                                Daftar sebagai Member
                            </label>
                        </div>
                        <div id="memberFields" style="display: none;">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat_konsumen" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="alert alert-info">
                                <i class="mdi mdi-information"></i>
                                Biaya pendaftaran member: Rp 100.000 (berlaku selamanya)
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info mt-3">Selanjutnya</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle radio button changes
    $('input[name="customerType"]').change(function() {
        if (this.value === 'member') {
            $('#memberSearchForm').show();
            $('#newCustomerForm').hide();
        } else {
            $('#memberSearchForm').hide();
            $('#newCustomerForm').show();
        }
    });

    // Handle member checkbox
    $('#wantMember').change(function() {
        if (this.checked) {
            $('#memberFields').slideDown();
        } else {
            $('#memberFields').slideUp();
        }
    });

    // Handle member search
    $('#searchMember').click(function() {
        const searchTerm = $('#memberSearch').val();
        $.ajax({
            url: "{{ route('konsumen.search') }}",
            method: 'GET',
            data: { search: searchTerm },
            success: function(response) {
                let html = '<div class="list-group">';
                response.forEach(member => {
                    html += `
                        <a href="step2/${member.id_konsumen}" 
                           class="list-group-item list-group-item-action">
                            ${member.kode_konsumen} - ${member.nama_konsumen}
                            <br>
                            <small>${member.noHp_konsumen}</small>
                        </a>
                    `;
                });
                html += '</div>';
                $('#memberSearchResult').html(html);
            }
        });
    });

    $('#newCustomerForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.member) {
                    // Open invoice in new window
                    window.open(response.invoice_url, '_blank');
                    
                    // Show confirmation modal
                    Swal.fire({
                        title: 'Pendaftaran Member Berhasil',
                        text: 'Apakah Anda ingin melanjutkan transaksi?',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, lanjutkan transaksi',
                        cancelButtonText: 'Tidak, selesai disini'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.next_step_url;
                        } else {
                            window.location.href = '/transaksi/step1';
                        }
                    });
                } else {
                    // Direct to next step for non-member
                    window.location.href = response.next_step_url;
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '<ul>';
                    Object.keys(errors).forEach(key => {
                        errorMessage += `<li>${errors[key][0]}</li>`;
                    });
                    errorMessage += '</ul>';
                    
                    Swal.fire({
                        title: 'Error!',
                        html: errorMessage,
                        icon: 'error'
                    });
                }
            }
        });
    });
});
</script>


<style>
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

.step-title {
    font-weight: 500;
}

.nav-item.disabled {
    opacity: 0.6;
}
</style>
@endsection