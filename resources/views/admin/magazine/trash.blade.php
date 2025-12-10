@extends('templates.app')

@section('content')
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --danger-color: #e63946;
            --warning-color: #f4a261;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-main {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 15px;
        }



        .action-buttons .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }

        .trash-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            border: none;
            border-left: 4px solid var(--danger-color);
        }

        .trash-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }

        .magazine-cover {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }

        .magazine-info {
            padding: 1.25rem;
        }

        .magazine-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            line-height: 1.4;
        }

        .magazine-meta {
            color: #718096;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .magazine-price {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .card-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .card-actions .btn {
            flex: 1;
            min-width: 120px;
            border-radius: 6px;
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #718096;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #cbd5e0;
        }

        .warning-banner {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border-left: 4px solid var(--warning-color);
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-buttons .btn {
                width: 100%;
            }

            .trash-card {
                margin-bottom: 1rem;
            }

            .card-actions {
                flex-direction: column;
            }

            .card-actions .btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-main">
        <!-- Warning Banner -->
        {{-- <div class="warning-banner">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill text-warning me-3 fs-4"></i>
                <div>
                    <h5 class="mb-1 text-dark">Area Sampah</h5>
                    <p class="mb-0 text-dark">Data di sini akan dihapus permanen setelah 30 hari. Kembalikan data yang masih diperlukan.</p>
                </div>
            </div>
        </div> --}}

        <!-- Success Alert -->
        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="h3 mb-1">Data Sampah Majalah</h1>
                    <p class="mb-0 opacity-75">Kelola data majalah yang telah dihapus</p>
                </div>
                <div class="action-buttons mt-2 mt-md-0">
                    <a href="{{ route('admin.magazines.index') }}" class="btn btn-light" style="color: var(--primary)">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Utama
                    </a>
                </div>
            </div>
        </div>

        <!-- Magazine Trash Grid -->
        <div class="row">
            @forelse ($magazineTrash as $key => $item)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="trash-card">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <img src="{{ asset('storage/' . $item['cover']) }}" class="magazine-cover h-100" alt="{{ $item['title'] }}">
                            </div>
                            <div class="col-md-7">
                                <div class="magazine-info h-100 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="status-badge {{ $item['actived'] == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item['actived'] == 1 ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                        <span class="magazine-price">Rp{{ number_format($item['price'], 0, ',', '.') }}</span>
                                    </div>

                                    <h3 class="magazine-title">{{ $item['title'] }}</h3>

                                    <div class="magazine-meta">
                                        <div><i class="bi bi-tag me-1"></i> {{ $item['category'] }}</div>
                                        <div><i class="bi bi-calendar me-1"></i> {{ $item['publication_year'] }}</div>
                                    </div>

                                    <div class="card-actions mt-auto">
                                        <form action="{{ route('admin.magazines.restore', $item->id) }}" method="POST" class="w-100">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Kembalikan
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.magazines.delete_permanent', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus permanen majalah ini? Tindakan ini tidak dapat dibatalkan.')" class="w-100">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-trash-fill me-1"></i> Hapus Permanen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-trash"></i>
                        <h4 class="h5">Tempat sampah kosong</h4>
                        <p class="mb-3">Tidak ada data majalah yang dihapus</p>
                        <a href="{{ route('admin.magazines.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Utama
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Info Footer -->
        @if(count($magazineTrash) > 0)
            <div class="mt-4 text-center text-muted">
                <small>
                    <i class="bi bi-info-circle me-1"></i>
                    Menampilkan {{ count($magazineTrash) }} data yang dihapus
                </small>
            </div>
        @endif
    </div>
    @endsection
