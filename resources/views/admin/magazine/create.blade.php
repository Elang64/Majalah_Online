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

    @media (max-width: 768px) {
        .magazine-card { margin: 1rem; border-radius: 12px; }
        .card-body { padding: 1.5rem; }
        .card-header { padding: 1rem 1.5rem; font-size: 1rem; }
    }
</style>

<div class="magazine-card">
    <!-- Header Card -->
    <div class="card-header">
       <a href="{{route('admin.magazines.index')}} " style="color:white"> Data Majalah </a> \ Tambah
    </div>

    <!-- Body Card -->
    <div class="card-body">
        <form method="POST" action="{{ route('admin.magazines.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Judul Majalah</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label for="category" class="form-label">Kategori</label>
                    <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" placeholder="Fashion, Teknologi, Otomotif, dll">
                    @error('category') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="price" class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" id="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                    @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label for="publication_year" class="form-label">Tahun Terbit</label>
                    <input type="number" name="publication_year" id="publication_year" class="form-control @error('publication_year') is-invalid @enderror"
                           value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') + 5 }}">
                    @error('publication_year') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="promo_id" class="form-label">Promo (Opsional)</label>
                <select name="promo_id" id="promo_id" class="form-select @error('promo_id') is-invalid @enderror">
                    <option value="">-- Tanpa Promo --</option>
                    @foreach($promos as $promo)
                        <option value="{{ $promo->id }}" {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                            {{ $promo->name }} → Diskon {{ $promo->discount }}{{ $promo->type == 'percent' ? '%' : ' Rupiah' }}
                        </option>
                    @endforeach
                </select>
                @error('promo_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Cover Majalah</label>
                <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                @error('cover') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" rows="6" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.magazines.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Majalah</button>
            </div>
        </form>
    </div>
</div>
@endsection
