{{-- resources/views/karyawan/kasir/transaksi/member-invoice.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pendaftaran Member</title>
    <link rel="icon" href="{{ asset('images/logo_laundry_bg.jpeg') }}" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>INVOICE PENDAFTARAN MEMBER</h1>
            <h2>Laundry System</h2>
        </div>

        <div class="invoice-details">
            <div>
                <p><strong>Kode Member:</strong> {{ $konsumen->kode_konsumen }}</p>
                <p><strong>Tanggal:</strong> {{ now()->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p><strong>Nama:</strong> {{ $konsumen->nama_konsumen }}</p>
                <p><strong>No. HP:</strong> {{ $konsumen->noHp_konsumen }}</p>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Biaya Pendaftaran Member (Berlaku Selamanya)</td>
                    <td>Rp 100.000</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            Total: Rp 100.000
        </div>

        <div class="footer">
            <p>Terima kasih telah mendaftar sebagai member!</p>
            <p>Silakan gunakan kode member Anda untuk setiap transaksi.</p>
        </div>

        <div class="no-print" style="margin-top: 20px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px;">Cetak Invoice</button>
        </div>
    </div>
</body>
</html>