<?php

namespace App\Exports;

use App\Models\Magazine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class MagazineExport implements FromCollection, WithHeadings, WithMapping
{
    // Buat menambahkan nomor urut otomatis
    private $key = 0;

    /**
     * Mengambil data dari database.
     */
    public function collection()
    {
        // Menampilkan data terbaru di urutan pertama
        return Magazine::orderBy('created_at', 'DESC')->get();
    }

    /**
     * Menentukan header (judul kolom) di file Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'Judul',
            'Penulis',
            'Kategori',
            'Tanggal Terbit',
            'Cover',
            'Deskripsi',
            'Status Aktif',
        ];
    }

    /**
     * Menentukan isi setiap baris data (td).
     */
    public function map($magazine): array
    {
        return [
            ++$this->key,
            $magazine->title,
            $magazine->author,
            $magazine->category ?? '-', // jika tidak ada kategori
            Carbon::parse($magazine->published_at)->translatedFormat('d F Y'),
            asset('storage/' . $magazine->cover),
            $magazine->description,
            $magazine->actived == 1 ? 'Aktif' : 'Non-Aktif',
        ];
    }
}
