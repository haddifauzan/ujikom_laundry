@extends('admin.template.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                    <div class="d-flex align-items-center">
                        <h3 class="me-2">Kelola Halaman Utama</h3>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="homepageTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="true">
                                Edit Pengaturan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                                Kelola Ulasan
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content mt-4" id="homepageTabsContent">
                        <!-- Tab Edit Pengaturan -->
                        <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form action="{{ route('settings.home.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Bagian Hero -->
                                <h4>Section Hero</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hero_title" class="form-label">Judul Hero</label>
                                            <input type="text" class="form-control" id="hero_title" name="hero_title" value="{{ $settings->hero_title }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="hero_description" class="form-label">Deskripsi Hero</label>
                                            <textarea class="form-control" id="hero_description" name="hero_description">{{ $settings->hero_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hero_image" class="form-label">Gambar Hero</label>
                                            <input type="file" class="form-control" id="hero_image" name="hero_image">
                                            @if($settings->hero_image)
                                            <div class="mt-2">
                                                <img src="{{ asset($settings->hero_image) }}" alt="Gambar hero saat ini" class="img-thumbnail" style="max-height: 200px">
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian Tentang -->
                                <h4>Section Tentang</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="about_title" class="form-label">Judul Tentang</label>
                                            <input type="text" class="form-control" id="about_title" name="about_title" value="{{ $settings->about_title }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="about_description" class="form-label">Deskripsi Tentang</label>
                                            <textarea class="form-control" id="about_description" name="about_description">{{ $settings->about_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="about_image" class="form-label">Gambar Tentang</label>
                                            <input type="file" class="form-control" id="about_image" name="about_image">
                                            @if($settings->about_image)
                                            <div class="mt-2">
                                                <img src="{{ asset($settings->about_image) }}" alt="Gambar tentang saat ini" class="img-thumbnail" style="max-height: 200px">
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian Layanan -->
                                <h4>Section Layanan</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="services_title" class="form-label">Judul Layanan</label>
                                            <input type="text" class="form-control" id="services_title" name="services_title" value="{{ $settings->services_title }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="services_description" class="form-label">Deskripsi Layanan</label>
                                            <textarea class="form-control" id="services_description" name="services_description">{{ $settings->services_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian Pemasok -->
                                <h4>Section Pemasok</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="suppliers_title" class="form-label">Judul Pemasok</label>
                                            <input type="text" class="form-control" id="suppliers_title" name="suppliers_title" value="{{ $settings->suppliers_title }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="suppliers_description" class="form-label">Deskripsi Pemasok</label>
                                            <textarea class="form-control" id="suppliers_description" name="suppliers_description">{{ $settings->suppliers_description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success mt-3">Perbarui Pengaturan</button>
                            </form>
                        </div>

                        <!-- Tab Ulasan -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Kelola Ulasan</h3>
                                </div>
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                        
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-review">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Rating</th>
                                                    <th>Pesan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reviews as $review)
                                                <tr>
                                                    <td>{{ $review->created_at->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $review->name }}</td>
                                                    <td>{{ $review->email }}</td>
                                                    <td>
                                                        @for($i = 0; $i < $review->rating; $i++)
                                                            ⭐
                                                        @endfor
                                                    </td>
                                                    <td>{{ Str::limit($review->message, 40) }}</td>
                                                    <td>
                                                        <span class="badge {{ $review->is_displayed ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $review->is_displayed ? 'Ditampilkan' : 'Disembunyikan' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <form action="{{ route('reviews.toggle', $review->id_review) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-sm {{ $review->is_displayed ? 'btn-warning' : 'btn-success' }} me-2">
                                                                    <i class="mdi mdi-{{ $review->is_displayed ? 'eye-off' : 'eye' }}"></i>
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="{{ route('reviews.destroy', $review->id_review) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="mdi mdi-delete"></i>
                                                                </button>
                                                            </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatable -->
<script>
    $(document).ready(function() {
        new DataTable('#table-review', {
            paging: true,      // Mengaktifkan pagination
            info: true,        // Menampilkan informasi jumlah data
            ordering: true     // Mengaktifkan fitur pengurutan
        });
    });
</script>
@endsection
