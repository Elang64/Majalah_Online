<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MagazineExport;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class MagazineController extends Controller
{
    /**
     * Tampilkan semua data majalah (admin)
     */
    public function index()
    {
        $magazines = Magazine::with('promo')->get();
        return view('admin.magazine.index', compact('magazines'));
    }

  public function datatables()
{
    $magazine = Magazine::query();

    return DataTables::of($magazine)
        ->addIndexColumn()
        ->addColumn('cover', function ($magazine) {
            $coverUrl = asset('storage/' . $magazine->cover);
            return '<img src="' . $coverUrl . '" class="cover-img" alt="' . $magazine->title . '" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">';
        })
        ->addColumn('promo', function ($magazine) {
            if ($magazine->promo) {
                return '<small class="badge badge-warning mt-1"><i class="fas fa-tag me-1"></i>' . $magazine->promo->promo_code . '</small>';
            }
            return '-';
        })
        ->addColumn('price', function ($magazine) {
            if ($magazine->promo) {
                $discountedPrice = $magazine->promo->type == 'percent'
                    ? $magazine->price - ($magazine->price * $magazine->promo->discount / 100)
                    : $magazine->price - $magazine->promo->discount;
                $discountedPrice = max(0, $discountedPrice);

                return '<div>
                    <small class="text-muted"><s>Rp' . number_format($magazine->price, 0, ',', '.') . '</s></small>
                    <div class="fw-bold text-success">Rp' . number_format($discountedPrice, 0, ',', '.') . '</div>
                </div>';
            }
            return '<div class="fw-bold text-primary">Rp' . number_format($magazine->price, 0, ',', '.') . '</div>';
        })
        ->addColumn('actived_badge', function ($magazine) {
            if ($magazine->actived) {
                return '<span class="badge badge-success">Aktif</span>';
            } else {
                return '<span class="badge badge-danger">Non-Aktif</span>';
            }
        })
        ->addColumn('action', function ($magazine) {
            $btnDetail = '<button class="action-btn btn-view" onclick=\'showModal(' . json_encode($magazine) .' )\'>
                            <i class="fas fa-eye"></i> Lihat
                          </button>';

            $btnEdit = '<a href="' . route('admin.magazines.edit', $magazine->id) . '" class="action-btn btn-edit">
                          <i class="fas fa-edit"></i> Edit
                        </a>';

            $btnStatus = '<form action="' . route('admin.magazines.patch', $magazine->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '
                            <button type="submit" class="action-btn btn-toggle ' . ($magazine->actived == 1 ? '' : 'inactive') . '">
                                <i class="fas ' . ($magazine->actived == 1 ? 'fa-pause' : 'fa-play') . '"></i>
                            </button>
                          </form>';

            $btnDelete = '<form action="' . route('admin.magazines.delete', $magazine->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="action-btn btn-delete" onclick="return confirm(\'Yakin ingin menghapus majalah ini?\')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                          </form>';

            return '<div class="d-flex justify-content-center align-items-center gap-2">
                      ' . $btnDetail . $btnEdit . $btnDelete . $btnStatus . '
                    </div>';
        })
        ->rawColumns(['cover', 'promo', 'price', 'actived_badge', 'action'])
        ->make(true);
}

    /**
     * Tampilkan halaman utama dengan majalah aktif
     */
    public function home()
    {
        $magazines = Magazine::with('promo')
            ->where('actived', 1)
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->get();

        return view('home', compact('magazines'));
    }

    /**
     * Fitur pencarian majalah
     */
    public function homeMagazines(Request $request)
    {
        $search = $request->search_magazine;

        $magazines = Magazine::with('promo')
            ->where('actived', 1)
            ->when($search, function ($query, $search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('magazines', compact('magazines'));
    }

    public function magazineList(Request $request, $magazines_id)
    {
        // $sortPrice = $request->sort_price;

        $magazines = Magazine::with('promo')->findOrFail($magazines_id);
        return view('showMagazine.detail', compact('magazines'));
    }


    /**
     * Form tambah majalah
     */
    public function create()
    {
        $promos = Promo::all();
        return view('admin.magazine.create', compact('promos'));
    }

    /**
     * Simpan majalah baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'cover' => 'required|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'promo_id' => 'nullable|exists:promos,id'
        ]);

        $cover = $request->file('cover');
        $fileName = Str::random(10) . '-cover.' . $cover->getClientOriginalExtension();
        $path = $cover->storeAs('cover', $fileName, 'public');

        $magazine = Magazine::create([
            'user_id' => auth()->id(),
            'promo_id' => $request->promo_id,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'publication_year' => $request->publication_year,
            'cover' => $path,
            'actived' => 1,
        ]);

        return $magazine
            ? redirect()->route('admin.magazines.index')->with('success', 'Berhasil menambahkan majalah!')
            : redirect()->back()->with('error', 'Gagal menambahkan, coba lagi!');
    }

    public function show(Magazine $magazine)
    {
        //
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $magazine = Magazine::with('promo')->findOrFail($id);
        $promos = Promo::all();
        return view('admin.magazine.edit', compact('magazine', 'promos'));
    }

    /**
     * Update data majalah
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'cover' => 'nullable|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'promo_id' => 'nullable|exists:promos,id'
        ]);

        $magazine = Magazine::findOrFail($id);

        if ($request->hasFile('cover')) {
            // Hapus file cover lama jika ada
            $filePath = storage_path('app/public/' . $magazine->cover);
            if ($magazine->cover && file_exists($filePath)) {
                unlink($filePath);
            }

            $file = $request->file('cover');
            $fileName = 'cover-' . Str::random(10) . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs('cover', $fileName, 'public');
        }

        $updateData = $magazine->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'publication_year' => $request->publication_year,
            'promo_id' => $request->promo_id,
            'cover' => $request->hasFile('cover') ? $path : $magazine->cover,
        ]);

        if ($updateData) {
            return redirect()->route('admin.magazines.index')->with('success', 'Berhasil memperbarui Majalah!');
        } else {
            return redirect()->back()->with('error', 'Gagal! silahkan coba lagi.');
        }
    }

    /**
     * Soft delete (hapus sementara) - TIDAK menghapus file cover
     */
    public function destroy($id)
    {
        $magazine = Magazine::findOrFail($id);

        // Hanya melakukan soft delete, TIDAK menghapus file cover
        $magazine->delete();

        return redirect()->route('admin.magazines.index')->with('success', 'Majalah berhasil dihapus sementara!');
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function patch($id)
    {
        $magazine = Magazine::findOrFail($id);

        // Toggle status: jika aktif maka nonaktifkan, jika nonaktif maka aktifkan
        $magazine->actived = !$magazine->actived;
        $magazine->save();

        // Pesan notifikasi sesuai kondisi
        $status = $magazine->actived ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.magazines.index')->with('success', "Majalah berhasil $status.");
    }

    /**
     * Tampilkan majalah yang dihapus
     */
    public function trash()
    {
        $magazineTrash = Magazine::with('promo')->onlyTrashed()->get();
        return view('admin.magazine.trash', compact('magazineTrash'));
    }

    /**
     * Restore majalah dari trash
     */
    public function restore($id)
    {
        $magazine = Magazine::onlyTrashed()->findOrFail($id);
        $magazine->restore();

        return redirect()->route('admin.magazines.trash')->with('success', 'Majalah berhasil dikembalikan.');
    }

    /**
     * Hapus permanen - baru di sini file cover dihapus
     */
    public function deletePermanent($id)
    {
        $magazine = Magazine::onlyTrashed()->findOrFail($id);

        // Hapus file cover dari storage
        $filePath = storage_path('app/public/' . $magazine->cover);
        if ($magazine->cover && file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus permanen dari database
        $magazine->forceDelete();

        return redirect()->route('admin.magazines.trash')->with('success', 'Majalah dihapus permanen.');
    }

    /**
     * Export ke Excel
     */
    public function export()
    {
        return Excel::download(new MagazineExport, 'data-majalah.xlsx');
    }

    /**
     * Apply promo to multiple magazines
     */
    public function applyPromo(Request $request)
    {
        $request->validate([
            'magazine_ids' => 'required|array',
            'magazine_ids.*' => 'exists:magazines,id',
            'promo_id' => 'required|exists:promos,id'
        ]);

        Magazine::whereIn('id', $request->magazine_ids)
            ->update(['promo_id' => $request->promo_id]);

        return redirect()->back()->with('success', 'Promo berhasil diterapkan ke majalah terpilih!');
    }

    /**
     * Remove promo from multiple magazines
     */
    public function removePromo(Request $request)
    {
        $request->validate([
            'magazine_ids' => 'required|array',
            'magazine_ids.*' => 'exists:magazines,id'
        ]);

        Magazine::whereIn('id', $request->magazine_ids)
            ->update(['promo_id' => null]);

        return redirect()->back()->with('success', 'Promo berhasil dihapus dari majalah terpilih!');
    }

    public function dashboard()
    {
        $magazineTrashCount = Magazine::onlyTrashed()->count();

        return view('admin.dashboard', compact('magazineTrashCount'));
    }

    public function purchased()
    {
        // if (!auth()->check()) {
        //     return redirect()->route('login');
        // }

        // Tampilkan semua majalah yang pernah diorder
        // tanpa memfilter status pembayaran
        $userId = auth()->id();
        // $search = $request->search_magazine;

        $purchasedMagazines = Magazine::whereIn('id', function ($query) use ($userId) {
            $query->select('magazine_id')
                ->from('orders')
                ->where('user_id', $userId);
        })->orderBy('created_at', 'desc')
        ->paginate(12);

        $purchasedCount = $purchasedMagazines->total();

        return view('magazine.index', compact('purchasedMagazines', 'purchasedCount'));
    }

    public function exportPdf()
    {
        // Ambil semua data majalah dengan relasi promo
        $magazines = Magazine::with('promo')->get()->toArray();

        // Kirim data ke view
        view()->share('magazines', $magazines);

        // Generate PDF
        $pdf = Pdf::loadView('admin.magazine.export-pdf', $magazines);

        // Penamaan file
        $fileName = 'DATA_MAJALAH_' . date('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
    }

    public function chart()
{
    $aktif = Magazine::where('actived', 1)->count();
    $nonAktif = Magazine::where('actived', 0)->count();

    return response()->json([
        'labels' => ['Aktif', 'Non-Aktif'],
        'data' => [$aktif, $nonAktif]
    ]);
}
}
