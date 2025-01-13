@extends('karyawan.pengelola-barang.template.master')
@section('title', 'Pengelola Barang Dashboard')

@section('content')
<!-- Content Header -->
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card text-dark">
                <div class="card-body">
                    <h2 class="display-6">Halo {{auth()->user()->karyawan->nama_karyawan}}! <br>  Selamat Datang di Dashboard Pengelola Barang</h2>
                    <p class="lead mb-0">{{ date('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Items -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-primary text-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Barang</h6>
                            <h2 class="mb-0">{{ $totalItems }}</h2>
                        </div>
                        <div class="rounded-circle border border-primary p-3">
                            <i class="mdi mdi-package text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-warning text-warning h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Stok Menipis</h6>
                            <h2 class="mb-0">{{ $lowStockItems }}</h2>
                        </div>
                        <div class="rounded-circle border border-warning p-3">
                            <i class="mdi mdi-alert-circle text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Usage -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-info text-info h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Pemakaian Hari Ini</h6>
                            <h2 class="mb-0">{{ $todayUsage }}</h2>
                        </div>
                        <div class="rounded-circle border border-info p-3">
                            <i class="mdi mdi-cart-outline text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Suppliers -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-secondary text-secondary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Supplier</h6>
                            <h2 class="mb-0">{{ $totalSuppliers }}</h2>
                        </div>
                        <div class="rounded-circle border border-secondary p-3">
                            <i class="mdi mdi-truck text-secondary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Stock Distribution Chart -->
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Distribusi Stok per Barang</h5>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="stockChartFilter" data-bs-toggle="dropdown">
                            Filter
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua Barang</a></li>
                            <li><a class="dropdown-item" href="#">Stok Menipis</a></li>
                            <li><a class="dropdown-item" href="#">Stok Aman</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="stockDistributionChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Item Usage Chart -->
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Pemakaian Barang Terbanyak per Bulan</h5>
                </div>
                <div class="card-body">
                    <canvas id="itemUsageChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-info btn-sm active">Semua</button>
                        <button type="button" class="btn btn-outline-info btn-sm">Pembelian</button>
                        <button type="button" class="btn btn-outline-info btn-sm">Pemakaian</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Tipe</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Karyawan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActivities as $activity)
                                <tr>
                                    <td>{{ $activity['waktu'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $activity['tipe'] === 'Pembelian' ? 'success' : 'info' }}">
                                            {{ $activity['tipe'] }}
                                        </span>
                                    </td>
                                    <td>{{ $activity['barang'] }}</td>
                                    <td>{{ $activity['jumlah'] }}</td>
                                    <td>{{ $activity['karyawan'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $activity['status'] === 'Selesai' ? 'success' : 'warning' }}">
                                            {{ $activity['status'] }}
                                        </span>
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
</div>

<script>
    let stockDistributionChart;
    let itemUsageChart;
    
    // Inisialisasi semua fungsi pada saat dokumen siap
    document.addEventListener('DOMContentLoaded', function () {
        initStockDistributionChart(); // Memuat chart distribusi stok dengan filter default
        initItemUsageChart();         // Memuat chart penggunaan barang
        setupAutoRefresh();           // Menyiapkan auto-refresh untuk dashboard
        initDashboardEventListeners(); // Menambahkan event listener untuk tombol dan filter
    });
    
    // Fungsi untuk memuat chart distribusi stok
    function initStockDistributionChart(filter = 'Semua Barang') {
        fetch('{{ route("karyawan.pengelola-barang.dashboard.chart-data") }}')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('stockDistributionChart').getContext('2d');
    
                // Hancurkan chart lama jika ada
                if (stockDistributionChart) {
                    stockDistributionChart.destroy();
                }
    
                // Filter data berdasarkan pilihan filter
                let filteredData = data.stockDistribution;
                if (filter === 'Stok Menipis') {
                    filteredData = filteredData.filter(item => item.stok < 5); // Contoh: Stok < 5
                } else if (filter === 'Stok Aman') {
                    filteredData = filteredData.filter(item => item.stok >= 5); // Contoh: Stok >= 5
                }
    
                // Siapkan data untuk chart
                const labels = filteredData.map(item => item.nama_barang);
                const totals = filteredData.map(item => item.stok);
                const colors = labels.map(() => getRandomColor()); // Warna acak untuk setiap barang
    
                // Buat chart baru
                stockDistributionChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Stok',
                            data: totals,
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return `Jumlah: ${context.parsed.y} item`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            })
            .catch(handleFetchError);
    }
    
    // Fungsi untuk menambahkan event listener pada tombol dan filter
    function initDashboardEventListeners() {
        // Event listener untuk filter dropdown di chart distribusi stok
        const stockFilterItems = document.querySelectorAll('#stockChartFilter + .dropdown-menu .dropdown-item');
        stockFilterItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const filter = this.textContent;
    
                // Perbarui teks tombol filter
                document.getElementById('stockChartFilter').textContent = filter;
    
                // Muat ulang chart dengan filter baru
                initStockDistributionChart(filter);
            });
        });
    
        // Event listener untuk tombol filter tabel aktivitas
        const activityButtons = document.querySelectorAll('.btn-group .btn');
        activityButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Hapus class aktif dari semua tombol
                activityButtons.forEach(btn => btn.classList.remove('active'));
    
                // Tambahkan class aktif pada tombol yang diklik
                this.classList.add('active');
    
                // Filter baris tabel berdasarkan pilihan
                const filter = this.textContent.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');
    
                tableRows.forEach(row => {
                    const type = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (filter === 'semua' || type.includes(filter)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Fungsi untuk memuat chart penggunaan barang
    function initItemUsageChart() {
        fetch('{{ route("karyawan.pengelola-barang.dashboard.chart-data") }}')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('itemUsageChart').getContext('2d');
    
                // Hancurkan chart lama jika ada
                if (itemUsageChart) {
                    itemUsageChart.destroy();
                }
    
                // Siapkan data untuk chart
                const labels = data.itemUsage.map(item => item.barang.nama_barang);
                const values = data.itemUsage.map(item => item.total_usage);
    
                itemUsageChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                '#4e73df',
                                '#1cc88a',
                                '#36b9cc',
                                '#f6c23e',
                                '#e74a3b'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} unit (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            })
            .catch(handleFetchError);
    }
    
    // Fungsi auto-refresh dashboard setiap 5 menit
    function setupAutoRefresh() {
        setInterval(() => {
            initStockDistributionChart();
            initItemUsageChart();
        }, 300000); // 300.000 ms = 5 menit
    }
    
    // Helper: Menghasilkan warna acak
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    
    // Helper: Menangani error saat fetch data
    function handleFetchError(error) {
        console.error('Error fetching dashboard data:', error);
        const errorToast = document.createElement('div');
        errorToast.className = 'alert alert-danger alert-dismissible fade show';
        errorToast.role = 'alert';
        errorToast.innerHTML = `
            <strong>Error!</strong> Gagal memuat data dashboard.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.querySelector('.container-fluid').prepend(errorToast);
    }
</script>
    
@endsection