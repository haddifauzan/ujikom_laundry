@extends('admin.template.master')
@section('title', 'Admin Dashboard')
@section('content')

<div class="container-fluid">
    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card text-dark">
                <div class="card-body">
                    <h2 class="display-6">Welcome to WashUP Laundry Admin Dashboard</h2>
                    <p class="lead mb-0">{{ date('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-primary text-primary mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $totalKonsumen }}</h3>
                            <div>Total Konsumen</div>
                        </div>
                        <div>
                            <i class="mdi mdi-account-multiple" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small">
                        <span class="mdi mdi-arrow-up-bold"></span>
                        {{ $konsumenBulanIni }} konsumen baru bulan ini
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-info text-info mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                            <div>Total Pendapatan</div>
                        </div>
                        <div>
                            <i class="mdi mdi-currency-usd" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small">
                        <span class="mdi mdi-chart-line"></span>
                        Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }} pendapatan bulan ini
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-secondary text-secondary mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $totalTransaksi }}</h3>
                            <div>Total Transaksi</div>
                        </div>
                        <div>
                            <i class="mdi mdi-basket" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small">
                        <span class="mdi mdi-calendar-today"></span>
                        {{ $transaksiBulanIni }} transaksi bulan ini
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-warning text-warning mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $totalMember }}</h3>
                            <div>Total Member</div>
                        </div>
                        <div>
                            <i class="mdi mdi-card-account-details" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <div class="small">
                        <span class="mdi mdi-account-plus"></span>
                        {{ $memberBulanIni }} member baru bulan ini
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-chart-line me-2"></i>
                        Grafik Pendapatan Tahun {{ date('Y') }}
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="130"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-chart-pie me-2"></i>
                        Distribusi Jenis Laundry
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="laundryTypeChart" height="350"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance and Inventory Row -->
    <div class="row mb-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-account-star me-2"></i>
                        Performa Karyawan Bulan Ini
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th>Total Transaksi</th>
                                    <th>Total Pendapatan</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($performaKaryawan as $karyawan)
                                <tr>
                                    <td>{{ $karyawan->nama_karyawan }}</td>
                                    <td>{{ $karyawan->total_transaksi }}</td>
                                    <td>Rp {{ number_format($karyawan->total_pendapatan, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: {{ ($karyawan->rating/5)*100 }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-package-variant me-2"></i>
                        Stok Barang Menipis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stokMenipis as $barang)
                                <tr>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->kategori_barang }}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>
                                        @if($barang->stok <= 5)
                                            <span class="badge bg-danger">Kritis</span>
                                        @else
                                            <span class="badge bg-warning">Menipis</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Transactions Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="mdi mdi-clock-outline me-2"></i>
                        Transaksi Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Konsumen</th>
                                    <th>Jenis Laundry</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->no_transaksi }}</td>
                                    <td>{{ $transaksi->konsumen->nama_konsumen }}</td>
                                    <td>{{ $transaksi->rincianTransaksi->first()->tarifLaundry->jenisLaundry->nama_jenis ?? "-" }}</td>
                                    <td>Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                                    <td>
                                        @switch($transaksi->status_transaksi)
                                            @case('pending')
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case('proses')
                                                <span class="badge bg-info">Proses</span>
                                                @break
                                            @case('selesai')
                                                <span class="badge bg-success">Selesai</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $transaksi->status_transaksi }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($chartData['revenue']) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Grafik Pendapatan Bulanan'
                }
            }
        }
    });
    
    // Laundry Type Distribution Chart
    const typeCtx = document.getElementById('laundryTypeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartData['typeLabels']) !!},
            datasets: [{
                data: {!! json_encode($chartData['typeData']) !!},
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection