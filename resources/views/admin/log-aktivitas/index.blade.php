@extends('admin.template.master')
@section('title', 'Admin Log Aktivitas')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body py-3 px-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-account-group fs-4 me-2"></i>
                    <h5 class="mb-0">Log Aktivitas</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
        <!-- Filter Form -->
            <form action="{{ route('log-aktivitas.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <button type="submit" class="btn btn-info me-2">Filter</button>
                        <a href="{{ route('log-aktivitas.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <!-- Log Table -->
            <div class="table-responsive">
                <table class="table table-striped" id="table-log">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>User Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                            <th>Model</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</td>
                            <td>{{ $log->user->email }}</td>
                            <td>{{ $log->user_role }}</td>
                            <td>
                                @if($log->aksi == 'create')
                                    <span class="badge bg-success">Create</span>
                                @elseif($log->aksi == 'update')
                                    <span class="badge bg-warning">Update</span>
                                @else
                                    <span class="badge bg-danger">Delete</span>
                                @endif
                            </td>
                            <td>{{ class_basename($log->model) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $log->id }}">
                                    <i class="mdi mdi-eye-outline"></i>
                                </button>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Perubahan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>IP Address:</strong> {{ $log->ip_address }}</p>
                                                <p style="word-wrap: break-word;"><strong>User Agent:</strong> {{ $log->user_agent }}</p>
                                                <p><strong>Data:</strong></p>
                                                <pre>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                        </div>
                                    </div>
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

<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-log', {
            paging: true,
            info: true,
            ordering: true
        });
    });
</script>
@endsection
