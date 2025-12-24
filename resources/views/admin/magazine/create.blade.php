@extends('templates.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0 text-center w-100">
                                <i class="bi bi-journal-plus me-2"></i>Tambah Majalah Baru
                            </h4>
                        </div>

                        <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.magazines.index') }}" class="text-decoration-none">
                                        <i class="bi bi-journals me-1"></i>Data Majalah
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="bi bi-plus-circle me-1"></i>Tambah
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.magazines.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-semibold">Judul Majalah <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}"
                                            placeholder="Masukkan judul majalah" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label fw-semibold">Kategori</label>
                                        <input type="text" name="category" id="category"
                                            class="form-control @error('category') is-invalid @enderror"
                                            value="{{ old('category') }}"
                                            placeholder="Fashion, Teknologi, dll">
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-semibold">Harga (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="price" id="price" step="0.01"
                                                class="form-control @error('price') is-invalid @enderror"
                                                value="{{ old('price') }}"
                                                placeholder="0">
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="publication_year" class="form-label fw-semibold">Tahun Terbit</label>
                                        <input type="number" name="publication_year" id="publication_year"
                                            class="form-control @error('publication_year') is-invalid @enderror"
                                            value="{{ old('publication_year') ?? date('Y') }}"
                                            min="1900" max="{{ date('Y') + 5 }}">
                                        @error('publication_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="promo_id" class="form-label fw-semibold">Promo</label>
                                        <select name="promo_id" id="promo_id"
                                            class="form-select @error('promo_id') is-invalid @enderror">
                                            <option value="">-- Tanpa Promo --</option>
                                            @foreach ($promos as $promo)
                                                <option value="{{ $promo->id }}" {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                                                    {{ $promo->name }} (Diskon {{ $promo->discount }}{{ $promo->type == 'percent' ? '%' : ' Rp' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('promo_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cover" class="form-label fw-semibold">Cover Majalah</label>
                                        <input type="file" name="cover" id="cover"
                                            class="form-control @error('cover') is-invalid @enderror"
                                            accept="image/png, image/jpeg, image/jpg">
                                        <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                        @error('cover')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">Deskripsi</label>
                                <textarea name="description" id="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Masukkan deskripsi majalah...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.magazines.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-outline-secondary {
            border-radius: 30px
        }
    </style>
@endsection
