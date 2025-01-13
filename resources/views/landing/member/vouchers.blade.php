<!-- resources/views/landing/voucher/index.blade.php -->
@extends('landing.layout.master')

@section('title', 'Vouchers - WashUP Laundry')

@section('content')
<!-- Hero Section -->
<div class="bg-secondary-subtle py-5">
    <div class="container py-5">
        <div class="row min-vh-25 align-items-center">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success mb-3">Available Vouchers</h1>
                <p class="lead mb-0">Exclusive Deals for Our Members</p>
            </div>
        </div>
    </div>
</div>

<!-- Vouchers Grid Section -->
<div class="py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($vouchers as $voucher)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm bg-secondary-subtle" data-aos="fade-up">
                    @if($voucher->gambar)
                        <img src="{{ asset('uploads/voucher/'. $voucher->gambar) }}" 
                             class="card-img-top" 
                             alt="{{ $voucher->kode_voucher }}"
                             style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="card-title h5 fw-bold">{{ $voucher->kode_voucher }}</h3>
                            <span class="badge bg-success">
                                @if($voucher->diskon_persen)
                                    {{ $voucher->diskon_persen }}% OFF
                                @else
                                    Rp {{ number_format($voucher->diskon_nominal, 0, ',', '.') }} OFF
                                @endif
                            </span>
                        </div>
                        <p class="card-text text-muted">{{ $voucher->deskripsi }}</p>
                        
                        <!-- Voucher Details -->
                        <div class="mt-3">
                            <div class="small text-muted mb-2">
                                <i class="bi bi-clock"></i> Valid until: 
                                {{ $voucher->masa_berlaku_selesai->format('d M Y') }}
                            </div>
                            @if($voucher->min_subtotal_transaksi)
                            <div class="small text-muted mb-2">
                                <i class="bi bi-cart"></i> Min. transaction: 
                                Rp {{ number_format($voucher->min_subtotal_transaksi, 0, ',', '.') }}
                            </div>
                            @endif
                            @if($voucher->max_diskon)
                            <div class="small text-muted mb-2">
                                <i class="bi bi-tag"></i> Max. discount: 
                                Rp {{ number_format($voucher->max_diskon, 0, ',', '.') }}
                            </div>
                            @endif
                            <div class="small text-muted">
                                <i class="bi bi-ticket-perforated"></i> 
                                {{ $voucher->jumlah_voucher }} vouchers left
                            </div>
                        </div>

                        <!-- Terms and Conditions Collapse -->
                        <div class="mt-3">
                            <button class="btn btn-link text-success p-0 d-flex align-items-center gap-2" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#terms{{ $voucher->id_voucher }}" 
                                    aria-expanded="false" 
                                    aria-controls="terms{{ $voucher->id_voucher }}">
                                <span>View Terms & Conditions</span>
                                <i class="bi bi-chevron-down" id="icon{{ $voucher->id_voucher }}"></i>
                            </button>
                            <div class="collapse" id="terms{{ $voucher->id_voucher }}">
                                <div class="mt-2 small text-muted">
                                    {!! nl2br(e($voucher->syarat_ketentuan)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    No vouchers available at the moment.
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add event listeners to all collapse buttons
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            const targetId = button.getAttribute('data-bs-target')?.replace('#', '');
            const target = document.getElementById(targetId);
            const icon = document.getElementById(`icon${targetId}`);

            // Ensure both target and icon exist
            if (target && icon) {
                target.addEventListener('show.bs.collapse', () => {
                    icon.classList.remove('bi-chevron-down');
                    icon.classList.add('bi-chevron-up');
                });

                target.addEventListener('hide.bs.collapse', () => {
                    icon.classList.remove('bi-chevron-up');
                    icon.classList.add('bi-chevron-down');
                });
            }
        });
    });
</script>
@endsection