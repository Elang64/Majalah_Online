@extends('templates.app')

@section('content')
    <style>

        .container-main {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }



        .page-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 1.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn {
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background: #1e4a66;
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            color: var(--light);
            border: 1px solid var(--light);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: ;
        }

     */

        /* Table Styling */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-300);
            margin-bottom: 2rem;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .table thead {
            background: var(--gray-100);
            border-bottom: 2px solid var(--gray-300);
        }

        .table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.9rem;
            border: none;
        }

        .table tbody tr {
            border-bottom: 1px solid var(--gray-200);
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--gray-100);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            color: var(--gray-700);
            border: none;
        }

        /* Cover Image */
        .cover-img {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid var(--gray-300);
        }

        /* Status Badge */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-success {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .badge-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .badge-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 0.35rem 0.75rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid var(--gray-300);
            background: white;
            transition: all 0.2s ease;
            text-decoration: none;
            color: var(--gray-700);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-view {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
        }

        .btn-edit {
            color: #ffc107;
            border-color: #ffc107;
        }

        .btn-edit:hover {
            background: #ffc107;
            color: white;
        }

        .btn-delete {
            color: #dc3545;
            border-color: #dc3545;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        .btn-toggle {
            color: #28a745;
            border-color: #28a745;
        }

        .btn-toggle.inactive {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-toggle:hover {
            background: #28a745;
            color: white;
        }

        .btn-toggle.inactive:hover {
            background: #6c757d;
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-300);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: 1.5rem;
        }

        /* Modal */
        .modal-content {
            border-radius: 12px;
            border: none;
        }

        .modal-header {
            background: var(--primary);
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 1.25rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .detail-image {
            width: 100%;
            max-width: 200px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .detail-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-item strong {
            color: var(--primary);
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container-main {
                padding: 0 0.5rem;
            }

            .page-header {
                padding: 1rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.85rem;
            }

            .cover-img {
                width: 40px;
                height: 56px;
            }

            .action-btns {
                flex-direction: column;
                gap: 0.25rem;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="container-main">
        <!-- Success Alert -->
        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 6px;">
                <i class="fas fa-check-circle me-2"></i>
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="h1 fw-bold">Data Majalah</h1>
                        <p class="mb-0 opacity-75">Kelola data majalah</p>
                </div>
                <div class="action-buttons">
                       <a href="{{ route('admin.magazines.export') }}" class="btn btn-danger">
                        <i class="fa-regular fa-file-pdf me-1"></i>Export.pdf
                    </a>
                    <a href="{{ route('admin.magazines.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i>Export.xlsx
                    </a>
                    <a href="{{ route('admin.magazines.trash') }}" class="btn btn-info">
                        <i class="fas fa-trash-restore me-1"></i>Sampah
                    </a>
                    <a href="{{ route('admin.magazines.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah
                    </a>
                </div>
            </div>
        </div>

        <!-- Table -->
        @if (count($magazines) > 0)
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table" id="magazinesTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Cover</th>
                                <th>Judul</th>
                                <th>Promo</th>
                                <th>Kategori</th>
                                <th>Tahun</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        {{-- @foreach ($magazines as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $item->cover) }}"
                                     class="cover-img"
                                     alt="{{ $item->title }}"
                                     onclick="showModal({{ $item }})"
                                     style="cursor: pointer;">
                            </td>
                            <td>
                                <div class="fw-medium">{{ $item->title }}</div>
                                @if ($item->promo)
                                    <small class="badge-warning badge mt-1 d-inline-block">
                                        <i class="fas fa-tag me-1"></i>{{ $item->promo->promo_code }}
                                    </small>
                                @endif
                            </td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->publication_year }}</td>
                            <td>
                                @if ($item->promo)
                                    @php
                                        if($item->promo->type == 'percent') {
                                            $discountedPrice = $item->price - ($item->price * $item->promo->discount / 100);
                                        } else {
                                            $discountedPrice = $item->price - $item->promo->discount;
                                        }
                                        $discountedPrice = max(0, $discountedPrice);
                                    @endphp
                                    <div>
                                        <small class="text-muted"><s>Rp{{ number_format($item->price, 0, ',', '.') }}</s></small>
                                        <div class="fw-bold text-success">Rp{{ number_format($discountedPrice, 0, ',', '.') }}</div>
                                    </div>
                                @else
                                    <div class="fw-bold text-primary">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $item->actived == 1 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $item->actived == 1 ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button class="action-btn btn-view" onclick="showModal({{ $item }})">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                    <a href="{{ route('admin.magazines.edit', $item->id) }}" class="action-btn btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.magazines.patch', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn btn-toggle {{ $item->actived == 1 ? '' : 'inactive' }}">
                                            <i class="fas {{ $item->actived == 1 ? 'fa-pause' : 'fa-play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.magazines.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete"
                                                onclick="return confirm('Yakin ingin menghapus majalah ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h4>Belum Ada Data Majalah</h4>
                <p>Mulai dengan menambahkan majalah pertama</p>
                <a href="{{ route('admin.magazines.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Majalah
                </a>
            </div>
        @endif

        <!-- Detail Modal -->
        <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailLabel"><i class="fas fa-book me-2"></i>Detail Majalah</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalDetailBody">
                        <!-- Content akan diisi oleh JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Show Detail Modal
        function showModal(item) {
            let image = "{{ asset('storage/') }}/" + item.cover;

            let priceDisplay = '';
            let promoInfo = '';

            if (item.promo) {
                let discountedPrice = item.promo.type === 'percent' ?
                    item.price - (item.price * item.promo.discount / 100) :
                    item.price - item.promo.discount;
                discountedPrice = Math.max(0, discountedPrice);

                priceDisplay = `
                <div class="detail-item">
                    <strong>Harga</strong>
                    <div>
                        <div class="text-muted text-decoration-line-through">Rp${item.price.toLocaleString('id-ID')}</div>
                        <div class="text-success fw-bold fs-5">Rp${discountedPrice.toLocaleString('id-ID')}</div>
                        <div class="text-danger">
                            <i class="fas fa-shopping-bag me-1"></i>Hemat ${item.promo.discount}${item.promo.type === 'percent' ? '%' : ' Rupiah'}
                        </div>
                    </div>
                </div>
            `;

                promoInfo = `
                <div class="detail-item">
                    <strong>Informasi Promo</strong>
                    <div>
                        <div><strong>Nama:</strong> ${item.promo.name}</div>
                        <div><strong>Kode:</strong> <span class="badge bg-warning text-dark">${item.promo.promo_code}</span></div>
                        <div><strong>Jenis:</strong> ${item.promo.type === 'percent' ? 'Diskon Persentase' : 'Diskon Rupiah'}</div>
                    </div>
                </div>
            `;
            } else {
                priceDisplay = `
                <div class="detail-item">
                    <strong>Harga</strong>
                    <div>
                        <div class="text-primary fw-bold fs-5">Rp${item.price.toLocaleString('id-ID')}</div>
                    </div>
                </div>
            `;
            }

            let content = `
            <div class="text-center mb-3">
                <img src="${image}" class="detail-image" alt="${item.title}">
            </div>
            <div class="detail-item">
                <strong>Informasi Dasar</strong>
                <div>
                    <div><strong>Judul:</strong> ${item.title}</div>
                    <div><strong>Kategori:</strong> ${item.category}</div>
                    <div><strong>Tahun Terbit:</strong> ${item.publication_year}</div>
                    <div><strong>Status:</strong> <span class="badge ${item.actived ? 'bg-success' : 'bg-danger'}">${item.actived ? 'Aktif' : 'Non-Aktif'}</span></div>
                </div>
            </div>
            ${priceDisplay}
            ${promoInfo}
            <div class="detail-item">
                <strong>Deskripsi</strong>
                <div style="line-height: 1.6;">${item.description}</div>
            </div>
        `;

            document.getElementById("modalDetailBody").innerHTML = content;
            let modalDetail = new bootstrap.Modal(document.getElementById('modalDetail'));
            modalDetail.show();
        }
    </script>

    <script>
        $(function() {
            $('#magazinesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.magazines.datatables') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'cover',
                        name: 'cover',
                        orderable: false,
                        searchable: false,
                        width: '8%'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: true,
                        searchable: true,
                        width: '25%'
                    },
                      {
                        data: 'promo',
                        name: 'promo',
                        orderable: true,
                        searchable: true,
                        width: '8%'
                    },
                    {
                        data: 'category',
                        name: 'category',
                        orderable: true,
                        searchable: true,
                        width: '10%'
                    },
                    {
                        data: 'publication_year',
                        name: 'publication_year',
                        orderable: true,
                        searchable: true,
                        width: '8%'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: false,
                        searchable: false,
                        width: '12%'
                    },
                    {
                        data: 'actived_badge', // UBAH INI DARI 'status' KE 'status_badge'
                        name: 'actived',
                        orderable: false,
                        searchable: false,
                        width: '8%'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '24%'
                    },
                ],
            });
        });
    </script>
@endpush
