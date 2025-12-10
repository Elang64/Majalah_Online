@extends('templates.app')

@section('content')
    <div class="container py-4">
        <h3 class="text-center mb-3 fw-bold ">Seluruh Majalah</h3>

        <!-- Search Form -->
        <form method="GET" action="" class="max-w-lg mx-auto mb-3">
            <div class="input-group shadow-sm">
                <input type="text" name="search_magazine" class="form-control border-0 py-3"
                    placeholder="Cari judul majalah..." value="{{ request('search_magazine') }}"
                    style="border-radius: 50px 0 0 50px;">
                <button type="submit" class="btn btn-primary px-4" style="border-radius: 0 50px 50px 0;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Grid Majalah + Deskripsi -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            @foreach ($magazines as $item)
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden rounded-4 position-relative">
                        <!-- Gambar Cover -->
                        <img src="{{ asset('storage/' . $item['cover']) }}" class="card-img-top"
                            alt="{{ $item['title'] ?? 'Majalah' }}" style="height: auto    ; object-fit: cover;">

                        <!-- Deskripsi di bawah gambar -->
                        <div class="p-2 bg-white">


                            <!-- Tombol Beli tetap di bawah -->
                            <a href="{{ route('magazines.detail', $item['id']) }}"
                                class="btn btn-primary w-100 rounded-pill fw-bold mb-2">
                                BELI MAJALAH
                            </a>

                            <p class="text-muted small mb-3">
                                {{ Str::limit($item->description, 100) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if ($magazines->isEmpty())
            <div class="text-center py-5 my-5">
                <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                <p class="text-muted fs-5">Majalah tidak ditemukan</p>
            </div>
        @endif
    </div>
@endsection

@push('script')
    <style>
        h3 {
            color: var(--primary);
        }
    </style>
@endpush
