@extends('admin.template.master')
@section('title', 'Kelola Data Akun')

@section('content')
<div class="card">
    <div class="card-body py-3 px-4 border-bottom">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-account-group fs-4 me-2"></i>
                <h5 class="mb-0">Kelola Data Akun</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-3">
            <label for="filter-role" class="form-label">Filter Akun</label>
            <select id="filter-role" class="form-select" onchange="filterAkun()">
                <option value="">Semua</option>
                <option value="Karyawan">Karyawan</option>
                <option value="Konsumen">Konsumen</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="table-akun">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Last Login</th>
                        <th>Status Akun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-role="{{ $user->role }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'Karyawan')
                                    {{ $user->karyawan->nama_karyawan ?? '-' }}
                                @elseif($user->role === 'Konsumen')
                                    {{ $user->konsumen->nama_konsumen ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                @if($user->last_login)
                                    <strong>{{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }}</strong> <br><br>
                                    {{ \Carbon\Carbon::parse($user->last_login)->format('d-m-Y H:i:s') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="form-switch d-flex align-items-center">
                                    <input class="form-check-input status-switch me-2 mt-0" type="checkbox" 
                                           id="status-{{ $user->id_login }}" 
                                           data-id="{{ $user->id_login }}" 
                                           {{ $user->status_akun == 'Aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label my-auto" for="status-{{ $user->id_login }}">
                                        {{ $user->status_akun }}
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>                
            </table>
        </div>
    </div>
</div>

<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-akun', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>

<script>
    function filterAkun() {
        const role = document.getElementById('filter-role').value;
        const rows = document.querySelectorAll('#table-akun tbody tr');
        rows.forEach(row => {
            row.style.display = role === '' || row.dataset.role === role ? '' : 'none';
        });
    }

    document.querySelectorAll('.status-switch').forEach(switchEl => {
        switchEl.addEventListener('change', function () {
            const userId = this.dataset.id;
            const status = this.checked ? 'Aktif' : 'Non-Aktif';
            fetch(`users/status/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ status }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.nextElementSibling.textContent = status;
                } else {
                    alert('Gagal mengubah status akun');
                }
            });
        });
    });
</script>
@endsection
