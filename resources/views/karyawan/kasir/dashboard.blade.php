@extends('karyawan.kasir.template.master')
@section('title', 'Kasir Dashboard')

@section('content')
<!-- Content Header -->
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card text-dark">
                <div class="card-body">
                    <h2 class="display-6">Halo {{auth()->user()->karyawan->nama_karyawan}}! <br> Selamat Datang di Dashboard Kasir</h2>
                    <p class="lead mb-0">{{ date('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Transactions Today -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-primary text-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Transaksi Hari Ini</h6>
                            <h2 class="mb-0">{{ $todayTransactions }}</h2>
                        </div>
                        <div class="rounded-circle border border-primary p-3">
                            <i class="mdi mdi-cart text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Today -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-info text-info h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Pendapatan Hari Ini</h6>
                            <h2 class="mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h2>
                        </div>
                        <div class="rounded-circle border border-info p-3">
                            <i class="mdi mdi-currency-usd text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-warning text-warning h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Pesanan Pending</h6>
                            <h2 class="mb-0">{{ $pendingOrders }}</h2>
                        </div>
                        <div class="rounded-circle border border-warning p-3">
                            <i class="mdi mdi-clock-outline text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Members -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-secondary text-secondary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Member</h6>
                            <h2 class="mb-0">{{ $totalMembers }}</h2>
                        </div>
                        <div class="rounded-circle border border-secondary p-3">
                            <i class="mdi mdi-account-group text-secondary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Weekly Revenue Chart -->
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Pendapatan Mingguan</h5>
                </div>
                <div class="card-body">
                    <canvas id="weeklyRevenueChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Order Status Chart -->
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Status Pesanan</h5>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Transaksi Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Waktu</th>
                                    <th>Konsumen</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->no_transaksi }}</td>
                                    <td>{{ $transaction->waktu_transaksi }}</td>
                                    <td>{{ $transaction->konsumen->nama_konsumen }}</td>
                                    <td>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->statusPesanan->last()->status === 'pending' ? 'warning' : ($transaction->statusPesanan->last()->status === 'diproses' ? 'info' : ($transaction->statusPesanan->last()->status === 'selesai' ? 'success' : 'danger')) }}">
                                            {{ ucfirst($transaction->statusPesanan->last()->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pesanan.show', $transaction->id_transaksi) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
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
@endsection

<script>
    // Load charts when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        initWeeklyRevenueChart();
        initOrderStatusChart();
    });
</script>

<script>
    // Chart initialization functions
    function initWeeklyRevenueChart() {
        fetch('/kasir/dashboard/chart-data')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
                
                // Process data for the chart
                const labels = data.weeklyRevenue.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('id-ID', { weekday: 'short' });
                });
                
                const values = data.weeklyRevenue.map(item => item.total);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan',
                            data: values,
                            fill: true,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', {
                                                style: 'currency',
                                                currency: 'IDR'
                                            }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            maximumFractionDigits: 0
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            });
    }

    function initOrderStatusChart() {
        fetch('/kasir/dashboard/chart-data')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('orderStatusChart').getContext('2d');
                
                // Define colors for different status
                const statusColors = {
                    'pending': '#ffc107',
                    'diproses': '#17a2b8',
                    'selesai': '#28a745',
                    'gagal': '#dc3545'
                };

                // Process data for the chart
                const labels = data.orderStatus.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1));
                const values = data.orderStatus.map(item => item.total);
                const colors = data.orderStatus.map(item => statusColors[item.status]);

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
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
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            });
    }

    // Add event listeners for refreshing data
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize both charts
        initWeeklyRevenueChart();
        initOrderStatusChart();

        // Refresh data every 5 minutes
        setInterval(() => {
            initWeeklyRevenueChart();
            initOrderStatusChart();
        }, 300000);

        // Add click handlers for any interactive elements
        const refreshButton = document.getElementById('refresh-dashboard');
        if (refreshButton) {
            refreshButton.addEventListener('click', () => {
                initWeeklyRevenueChart();
                initOrderStatusChart();
            });
        }
    });

    // Helper function to format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(amount);
    }

    // Helper function to format dates
    function formatDate(dateString) {
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    // Add error handling for fetch requests
    function handleFetchError(error) {
        console.error('Error fetching dashboard data:', error);
        // You could add UI feedback here
        const errorToast = document.createElement('div');
        errorToast.className = 'alert alert-danger alert-dismissible fade show';
        errorToast.role = 'alert';
        errorToast.innerHTML = `
            <strong>Error!</strong> Failed to update dashboard data.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.querySelector('.container-fluid').prepend(errorToast);
    }
</script>