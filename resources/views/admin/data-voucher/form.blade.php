@extends('admin.template.master')
@section('title', isset($voucher) ? 'Edit Voucher' : 'Tambah Voucher')

@section('content')
<div class="card">
    <div class="card-body border-bottom px-3 py-2">
        <div class="d-flex justify-content-between align-items-center my-2">
            <div class="text-dark">
                <i class="mdi mdi-ticket-percent me-1"></i>
                {{ isset($voucher) ? 'Edit Voucher' : 'Tambah Voucher' }}
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ isset($voucher) ? route('voucher.update', $voucher->id_voucher) : route('voucher.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @if(isset($voucher))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kode Voucher <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="kode_voucher" 
                               class="form-control @error('kode_voucher') is-invalid @enderror" 
                               value="{{ old('kode_voucher', $voucher->kode_voucher ?? '') }}" 
                               required>
                        <small class="text-muted">Kode voucher harus unik dan tidak boleh kosong</small>
                        @error('kode_voucher')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" 
                                  class="form-control @error('deskripsi') is-invalid @enderror" 
                                  rows="3">{{ old('deskripsi', $voucher->deskripsi ?? '') }}</textarea>
                        <small class="text-muted">Deskripsi voucher (opsional)</small>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Voucher <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="jumlah_voucher" 
                               class="form-control @error('jumlah_voucher') is-invalid @enderror" 
                               value="{{ old('jumlah_voucher', $voucher->jumlah_voucher ?? '0') }}" 
                               required>
                        <small class="text-muted">Minimal 0 (default: 0)</small>
                        @error('jumlah_voucher')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe Diskon <span class="text-danger">*</span></label>
                        <select name="tipe_diskon" class="form-select" id="tipeDiskon">
                            <option value="persen" {{ (isset($voucher) && $voucher->diskon_persen) ? 'selected' : '' }}>Persentase</option>
                            <option value="nominal" {{ (isset($voucher) && $voucher->diskon_nominal) ? 'selected' : '' }}>Nominal</option>
                        </select>
                        <small class="text-muted">Pilih salah satu tipe diskon</small>
                    </div>

                    <div class="mb-3" id="diskonPersen">
                        <label class="form-label">Diskon (%)</label>
                        <input type="number" 
                               name="diskon_persen" 
                               class="form-control @error('diskon_persen') is-invalid @enderror" 
                               value="{{ old('diskon_persen', $voucher->diskon_persen ?? '') }}" 
                               step="0.01">
                        <small class="text-muted">Format: 99.99 (maksimal 2 desimal)</small>
                        @error('diskon_persen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="diskonNominal">
                        <label class="form-label">Diskon (Rp)</label>
                        <input type="number" 
                               name="diskon_nominal" 
                               class="form-control @error('diskon_nominal') is-invalid @enderror" 
                               value="{{ old('diskon_nominal', $voucher->diskon_nominal ?? '') }}">
                        <small class="text-muted">Format: Angka dengan 2 desimal</small>
                        @error('diskon_nominal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Minimum Subtotal Transaksi <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="min_subtotal_transaksi" 
                               class="form-control @error('min_subtotal_transaksi') is-invalid @enderror" 
                               value="{{ old('min_subtotal_transaksi', $voucher->min_subtotal_transaksi ?? '0') }}" 
                               required>
                        <small class="text-muted">Minimal 0 (default: 0)</small>
                        @error('min_subtotal_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Maksimum Diskon</label>
                        <input type="number" 
                               name="max_diskon" 
                               class="form-control @error('max_diskon') is-invalid @enderror" 
                               value="{{ old('max_diskon', $voucher->max_diskon ?? '') }}">
                        <small class="text-muted">Batas maksimal diskon yang dapat diberikan (opsional)</small>
                        @error('max_diskon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Periode Berlaku</label>
                        <div class="input-group">
                            <input type="date" 
                                   name="masa_berlaku_mulai" 
                                   class="form-control @error('masa_berlaku_mulai') is-invalid @enderror" 
                                   value="{{ old('masa_berlaku_mulai', isset($voucher) && $voucher->masa_berlaku_mulai ? $voucher->masa_berlaku_mulai->format('Y-m-d') : '') }}">
                            <span class="input-group-text">sampai</span>
                            <input type="date" 
                                   name="masa_berlaku_selesai" 
                                   class="form-control @error('masa_berlaku_selesai') is-invalid @enderror" 
                                   value="{{ old('masa_berlaku_selesai', isset($voucher) && $voucher->masa_berlaku_selesai ? $voucher->masa_berlaku_selesai->format('Y-m-d') : '') }}">
                        </div>
                        <small class="text-muted">Periode masa berlaku voucher (opsional)</small>
                        @error('masa_berlaku_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('masa_berlaku_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Minimum Jumlah Transaksi <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="min_jumlah_transaksi" 
                               class="form-control @error('min_jumlah_transaksi') is-invalid @enderror" 
                               value="{{ old('min_jumlah_transaksi', $voucher->min_jumlah_transaksi ?? '1') }}" 
                               required>
                        <small class="text-muted">Minimal 1 transaksi (default: 1)</small>
                        @error('min_jumlah_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Syarat & Ketentuan</label>
                        <textarea name="syarat_ketentuan" 
                                  class="form-control @error('syarat_ketentuan') is-invalid @enderror" 
                                  rows="3">{{ old('syarat_ketentuan', $voucher->syarat_ketentuan ?? '') }}</textarea>
                        <small class="text-muted">Syarat dan ketentuan penggunaan voucher (opsional)</small>
                        @error('syarat_ketentuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Voucher</label>
                        <input type="file" 
                               name="gambar" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               accept="image/*">
                        <small class="text-muted">Gambar voucher (opsional)</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if(isset($voucher) && $voucher->gambar)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/voucher/'.$voucher->gambar) }}" 
                                     alt="Current Voucher Image" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="Aktif" {{ (isset($voucher) && $voucher->status == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                            <option value="Non-Aktif" {{ (isset($voucher) && $voucher->status == 'Non-Aktif') ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        <small class="text-muted">Status voucher (default: Aktif)</small>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('voucher.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-info">
                    <i class="mdi mdi-content-save me-1"></i>
                    {{ isset($voucher) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        function toggleDiskonFields() {
            const tipeDiskon = $('#tipeDiskon').val();
            if (tipeDiskon === 'persen') {
                $('#diskonPersen').show();
                $('#diskonNominal').hide();
            } else {
                $('#diskonPersen').hide();
                $('#diskonNominal').show();
            }
        }
    
        $('#tipeDiskon').change(toggleDiskonFields);
        toggleDiskonFields();
    });
</script>
@endsection