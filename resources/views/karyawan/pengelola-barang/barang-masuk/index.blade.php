@extends('karyawan.pengelola-barang.template.master')
@section('title', 'Data Barang Masuk')

@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-boxes me-1"></i> Form Pembelian Barang</h5>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalTambahPembelian">
                    <i class="mdi mdi-plus"></i> Tambah Pembelian
                </button>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <i class="mdi mdi-filter-variant me-1"></i>
            Filter Laporan Pembelian
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route("barang-masuk.index") }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Periode Pembelian</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                            <span class="input-group-text">sampai</span>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Range Total Biaya</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="min_biaya" 
                                   placeholder="Minimal" value="{{ request('min_biaya') }}">
                            <span class="input-group-text">sampai</span>
                            <input type="number" class="form-control" name="max_biaya" 
                                   placeholder="Maksimal" value="{{ request('max_biaya') }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Filter Barang</label>
                        <select class="form-select" name="id_barang">
                            <option value="">Semua Barang</option>
                            @foreach($barang as $b)
                            <option value="{{ $b->id_barang }}" 
                                    {{ request('id_barang') == $b->id_barang ? 'selected' : '' }}>
                                {{ $b->nama_barang }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-info me-md-2">
                                <i class="mdi mdi-filter"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary me-md-2">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                            <a href="{{ route('karyawan.pembelian.laporan') }}?{{ http_build_query(request()->all()) }}" 
                               class="btn btn-danger" target="_blank">
                                <i class="mdi mdi-printer"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Riwayat Pembelian -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <i class="mdi mdi-history me-1"></i>
            Riwayat Pembelian Barang
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-pembelian" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No Pembelian</th>
                            <th>Waktu</th>
                            <th>Total Biaya</th>
                            <th>Karyawan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian as $p)
                        <tr>
                            <td>{{ $p->no_pembelian }}</td>
                            <td>{{ $p->waktu_pembelian }}</td>
                            <td>Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</td>
                            <td>{{ $p->karyawan->nama_karyawan }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="lihatDetail('{{ $p->id_pembelian }}')">
                                    <i class="mdi mdi-eye"></i> Detail
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="cetakInvoice('{{ $p->id_pembelian }}')">
                                    <i class="mdi mdi-printer"></i> Cetak
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

<!-- Modal Tambah Pembelian -->
<div class="modal fade" id="modalTambahPembelian" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pembelian Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formPembelian" action="{{ route('karyawan.pembelian.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">No Pembelian</label>
                            <input type="text" class="form-control" name="no_pembelian" value="{{ $nomorPembelian }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu Pembelian</label>
                            <input type="datetime-local" class="form-control" name="waktu_pembelian" required>
                        </div>
                    </div>

                    <!-- Tabel Pemilihan Barang -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelBarang">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-select barang-select" name="barang[]" required>
                                            <option value="">Pilih Barang</option>
                                            @foreach($barang as $b)
                                            <option value="{{ $b->id_barang }}" data-harga="{{ $b->harga_satuan }}">
                                                {{ $b->nama_barang }} || {{ $b->kode_barang }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control jumlah-input" name="jumlah[]" min="1" required>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control harga-input" name="harga[]" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control subtotal-input" name="subtotal[]" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm hapus-baris">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-primary my-3" id="tambahBaris">
                        <i class="mdi mdi-plus"></i> Tambah Barang
                    </button>

                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <div class="form-group">
                                <label class="form-label">Total Biaya</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="totalBiaya" name="total_biaya" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Pembelian -->
<div class="modal fade" id="modalDetailPembelian" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailPembelianContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Event handler untuk pemilihan barang
        $(document).on('change', '.barang-select', function () {
            let row = $(this).closest('tr');
            let harga = $(this).find(':selected').data('harga') || 0;

            // Set harga satuan ke input
            row.find('.harga-input').val(harga);

            // Hitung subtotal
            hitungSubtotal(row);
        });

        // Event handler untuk perubahan jumlah
        $(document).on('input', '.jumlah-input', function () {
            let row = $(this).closest('tr');
            hitungSubtotal(row);
        });

        // Fungsi untuk menambah baris baru
        $('#tambahBaris').click(function () {
            let newRow = $('#tabelBarang tbody tr:first').clone();

            // Reset nilai pada baris baru
            newRow.find('select').val('');
            newRow.find('input').val('');
            
            // Tambahkan baris baru ke tabel
            $('#tabelBarang tbody').append(newRow);
        });

        // Event handler untuk menghapus baris
        $(document).on('click', '.hapus-baris', function () {
            if ($('#tabelBarang tbody tr').length > 1) {
                $(this).closest('tr').remove();
                hitungTotal();
            }
        });

        // Fungsi untuk menghitung subtotal
        function hitungSubtotal(row) {
            let jumlah = parseInt(row.find('.jumlah-input').val()) || 0;
            let harga = parseFloat(row.find('.harga-input').val()) || 0;
            let subtotal = jumlah * harga;
            row.find('.subtotal-input').val(subtotal);
            hitungTotal();
        }

        // Fungsi untuk menghitung total biaya
        function hitungTotal() {
            let total = 0;
            $('.subtotal-input').each(function () {
                total += parseFloat($(this).val()) || 0;
            });
            $('#totalBiaya').val(total);
        }
    });

    function lihatDetail(id) {
        $.get(`/karyawan/pengelola-barang/pembelian/${id}/detail`, function(data) {
            $('#detailPembelianContent').html(data);
            $('#modalDetailPembelian').modal('show');
        });
    }

    // Function to print invoice
    function cetakInvoice(id) {
        window.open(`/karyawan/pengelola-barang/pembelian/${id}/cetak`, '_blank');
    }
</script>

<script>
    $(document).ready(function() {
        new DataTable('#table-pembelian', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>

<script>
    // Handling filter dan cetak laporan
    $('#previewFilter').click(function() {
        let formData = new FormData($('#filterForm')[0]);
        formData.append('action', 'preview');
        
        $.ajax({
            url: "{{ route('karyawan.pembelian.laporan') }}",
            type: 'GET',
            data: Object.fromEntries(formData),
            success: function(response) {
                // Update tabel dengan data yang difilter
                let table = $('#table-pembelian').DataTable();
                table.clear();
                
                response.pembelian.forEach((p, index) => {
                    table.row.add([
                        p.no_pembelian,
                        moment(p.waktu_pembelian).format('DD/MM/YYYY HH:mm'),
                        'Rp ' + new Intl.NumberFormat('id-ID').format(p.total_biaya),
                        p.karyawan.nama,
                        `<button class="btn btn-info btn-sm" onclick="lihatDetail('${p.id_pembelian}')">
                            <i class="mdi mdi-eye"></i> Detail
                        </button>
                        <button class="btn btn-success btn-sm" onclick="cetakInvoice('${p.id_pembelian}')">
                            <i class="mdi mdi-printer"></i> Cetak
                        </button>`
                    ]);
                });
                
                table.draw();
            }
        });
    });
    
    $('#cetakLaporan').click(function() {
        let formData = new FormData($('#filterForm')[0]);
        let queryString = new URLSearchParams(formData).toString();
        window.open("{{ route('karyawan.pembelian.laporan') }}?" + queryString, '_blank');
    });
</script>



@endsection