@extends('templates.app')

@section('content')
<style>
    :root {
        --primary: #2c5f7d;
        --radius: 16px;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .magazine-card {
        max-width: 960px;
        margin: 3rem auto;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-header {
        background: var(--primary);
        color: white;
        padding: 1.25rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .card-body {
        padding: 2.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(44, 95, 125, 0.15);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #e74c3c;
    }

    .btn {
        border-radius: 30px;
        padding: 0.7rem 2rem;
        font-weight: 600;
    }

    .btn-primary {
        background: var(--primary);
        border: none;
    }

    .btn-primary:hover {
        background: #1e4a66;
    }


    .current-cover {
        margin-top: 0.5rem;
    }

    .current-cover img {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .magazine-card { margin: 1rem; border-radius: 12px; }
        .card-body { padding: 1.5rem; }
        .card-header { padding: 1rem 1.5rem; font-size: 1rem; }
    }
</style>

    <div class="magazine-card">

         <div class="card-header">
        <a href="{{route('admin.magazines.index')}}" style="color: white;">Data Majalah </a>\ Tambah
    </div>



                    <div class="card-body">
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
