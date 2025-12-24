<!-- resources/views/admin/magazines/export-pdf-table.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tabel Data Majalah</title>
    <style>
        /* CSS sama seperti tabel di halaman web */
        body { font-family: Arial; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8f9fa; padding: 8px; border: 1px solid #dee2e6; }
        td { padding: 8px; border: 1px solid #dee2e6; }
        .cover-img { width: 40px; height: 56px; object-fit: cover; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 9px; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .text-muted { color: #6c757d; }
        .text-success { color: #28a745; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Data Majalah</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($magazines as $index => $magazine)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if(!empty($magazine['cover']))
                        <img src="{{ storage_path('app/public/' . $magazine['cover']) }}"
                             class="cover-img" alt="Cover">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $magazine['title'] }}</td>
                <td>{{ $magazine['category'] }}</td>
                <td>{{ $magazine['publication_year'] }}</td>
                <td>
                    @if($magazine['promo'])
                        <div>
                            <small class="text-muted">
                                <s>Rp{{ number_format($magazine['price'], 0, ',', '.') }}</s>
                            </small>
                            <div class="text-success">
                                Rp{{ number_format($magazine['price'] - $magazine['promo']['discount'], 0, ',', '.') }}
                            </div>
                        </div>
                    @else
                        <div>Rp{{ number_format($magazine['price'], 0, ',', '.') }}</div>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $magazine['actived'] ? 'badge-success' : 'badge-danger' }}">
                        {{ $magazine['actived'] ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
