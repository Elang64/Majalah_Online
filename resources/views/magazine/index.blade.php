@extends('templates.app')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4 text-center">Majalah Saya</h3>

        @if ($purchasedMagazines->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Anda belum membeli majalah apapun.
                <a href="{{ route('home.magazines.all') }}" class="alert-link">Lihat semua majalah</a>
            </div>
        @else
            <div class="row">
                @foreach ($purchasedMagazines as $magazine)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('magazines.detail', $magazine->id) }}" class="card-link">
                            <div class="card h-100 border">
                                <!-- Gambar -->
                                <img src="{{ asset('storage/' . $magazine->cover) }}" class="card-img-top"
                                    alt="{{ $magazine->title }}" style="height: auto; object-fit: cover;">

                                <!-- Body card -->
                                <div class="card-body">
                                    <!-- Judul -->
                                    <h6 class="card-title">{{ $magazine->title }}</h6>

                                    <!-- Tahun dan kategori -->
                                    <p class="card-text text-muted small mb-2">
                                        {{ $magazine->publication_year }} • {{ $magazine->category }}
                                    </p>

                                    <!-- Tombol download saja -->
                                    @if ($magazine->file_path)
                                        <a href="{{ asset('storage/' . $magazine->file_path) }}"
                                            class="btn btn-success btn-sm" download onclick="event.stopPropagation()">
                                            <i class="fas fa-download me-1"></i>Unduh
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $purchasedMagazines->links() }}
            </div>
        @endif
    </div>

    <style>
        .container {
            max-width: 1200px;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }


        .card {
            transition: border-color 0.2s, box-shadow 0.2s;
            border-radius: 6px;
        }

        .card:hover {
            box-shadow: 0 8px 18px rgba(44, 95, 125, 0.15);
        }

        .card-title {
            font-weight: 600;
            font-size: 1rem;
            color: #212529;
            margin-bottom: 0.25rem;
        }

        .card-text {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 576px) {
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
@endsection
